<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Event;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\TicketPurchased;
use chillerlan\QRCode\QRCode;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function dashboard(Request $request)
    {
        $search = $request->query('search');

        $ticketsQuery = Ticket::with('event')->orderBy('created_at', 'desc');
        $paymentsQuery = Payment::orderBy('created_at', 'desc');

        if ($search) {
            $ticketsQuery->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('ticket_code', 'like', "%{$search}%");

            $paymentsQuery->where('reference', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $tickets = $ticketsQuery->paginate(15, ['*'], 'tickets_page');
        $payments = $paymentsQuery->paginate(15, ['*'], 'payments_page');

        // Analytics
        $totalTicketsSold = Ticket::count();
        $totalRevenue = Payment::where('status', 'success')->sum('amount');
        $attendeesCheckedIn = Ticket::where('status', 'used')->count();

        return view('admin.dashboard', compact(
            'tickets',
            'payments',
            'totalTicketsSold',
            'totalRevenue',
            'attendeesCheckedIn',
            'search'
        ));
    }

    // Event Management
    public function editEvent()
    {
        $event = Event::first();
        return view('admin.event_edit', compact('event'));
    }

    public function updateEvent(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'date' => 'required|date',
            'location' => 'required|string',
        ]);

        $event = Event::first();
        $event->update($request->all());

        // Clear cache
        cache()->forget('event_details');

        return back()->with('success', 'Event details updated successfully!');
    }

    // Coupon Management
    public function couponsIndex()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupons', compact('coupons'));
    }

    public function couponStore(Request $request)
    {
        $request->merge([
            'code' => strtoupper(trim($request->code)),
            'is_active' => true
        ]);

        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_amount' => 'required|numeric',
            'type' => 'required|in:fixed,percentage',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create($request->all());

        return back()->with('success', 'Coupon created successfully!');
    }

    public function couponDelete($id)
    {
        Coupon::findOrFail($id)->delete();
        return back()->with('success', 'Coupon deleted successfully!');
    }

    public function manualRegister()
    {
        $event = Event::first();
        return view('admin.manual_register', compact('event'));
    }

    public function manualStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $event = Event::first();
        $reference = 'MANUAL-' . Str::upper(Str::random(10));

        // Create Payment record
        Payment::create([
            'reference' => $reference,
            'email' => $request->email,
            'amount' => $request->amount,
            'status' => 'success',
        ]);

        // Generate Ticket
        $ticketCode = 'TICKET-' . Str::upper(Str::random(8));
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ticket_code' => $ticketCode,
            'qr_code' => '', // Will be updated below
            'payment_reference' => $reference,
            'status' => 'valid',
        ]);

        // Generate QR Code
        $qrcode = (new QRCode)->render($ticketCode);
        $ticket->update(['qr_code' => $qrcode]);

        // Send Email
        try {
            Mail::to($ticket->email)->send(new TicketPurchased($ticket));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Manual Ticket Mail failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.dashboard')->with('success', 'Manual ticket issued and email sent successfully!');
    }

    public function testEmail()
    {
        try {
            Mail::raw('This is a test email from your AWE Academy Ticketing System. If you are reading this, your SMTP settings are working perfectly!', function ($message) {
                $message->to(Auth::user()->email)
                    ->subject('SMTP Connection Test Success');
            });
            return back()->with('success', 'Test email sent successfully to ' . Auth::user()->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Mail failed: ' . $e->getMessage());
        }
    }
}
