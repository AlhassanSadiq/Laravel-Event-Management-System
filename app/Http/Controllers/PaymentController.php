<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'coupon_code' => 'nullable|string',
        ]);

        $event = Event::findOrFail($request->event_id);
        
        // Base Price (Regular or Discounted)
        $actualUnitPrice = $event->discount_price > 0 ? $event->discount_price : $event->price;
        $totalAmount = $actualUnitPrice * $request->quantity;

        // Apply Coupon if provided
        if ($request->coupon_code) {
            $couponCode = strtoupper(trim($request->coupon_code));
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid()) {
                if ($coupon->type === 'percentage') {
                    $discount = ($coupon->discount_amount / 100) * $totalAmount;
                    $totalAmount -= $discount;
                } else {
                    $totalAmount -= $coupon->discount_amount;
                }
                if ($totalAmount < 0) $totalAmount = 0;
            }
        }

        $reference = 'AWE-' . Str::upper(Str::random(10));

        // If amount is 0 (e.g., 100% discount), bypass Paystack and issue ticket directly
        if ($totalAmount <= 0) {
            Payment::create([
                'reference' => $reference,
                'email' => $request->email,
                'amount' => 0,
                'status' => 'success',
            ]);

            $tickets = [];
            for ($i = 0; $i < $request->quantity; $i++) {
                $ticketCode = 'TICKET-' . Str::upper(Str::random(8));
                $ticket = Ticket::create([
                    'event_id' => $event->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'ticket_code' => $ticketCode,
                    'qr_code' => '',
                    'payment_reference' => $reference,
                    'status' => 'valid',
                ]);

                $qrcode = (new \chillerlan\QRCode\QRCode)->render($ticketCode);
                $ticket->update(['qr_code' => $qrcode]);
                $tickets[] = $ticket;

                try {
                    \Illuminate\Support\Facades\Mail::to($ticket->email)->send(new \App\Mail\TicketPurchased($ticket));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Mail sending failed: ' . $e->getMessage());
                }
            }

            return redirect()->route('ticket.show', ['code' => $tickets[0]->ticket_code])->with('success', 'Tickets claimed successfully with 100% discount!');
        }

        // Paystack API call
        $url = "https://api.paystack.co/transaction/initialize";
        $secretKey = env('PAYSTACK_SECRET_KEY', 'sk_test_dummy_key');

        $data = [
            'email' => $request->email,
            'amount' => round($totalAmount * 100), // Kobo
            'reference' => $reference,
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'event_id' => $event->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'quantity' => $request->quantity,
                'applied_coupon' => $request->coupon_code
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        if ($response->successful()) {
            return redirect($response->json()['data']['authorization_url']);
        }

        return back()->with('error', 'Payment initialization failed. Please try again.');
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        if (!$reference) {
            abort(400, 'Invalid reference');
        }

        $secretKey = env('PAYSTACK_SECRET_KEY', 'sk_test_dummy_key');
        $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->get($url);

        if ($response->successful() && $response->json()['data']['status'] === 'success') {
            $data = $response->json()['data'];

            // Prevent duplicate processing
            $existingPayment = Payment::where('reference', $reference)->first();
            if ($existingPayment) {
                return redirect()->route('home')->with('message', 'Payment already processed.');
            }

            // Create Payment record
            Payment::create([
                'reference' => $reference,
                'email' => $data['customer']['email'],
                'amount' => $data['amount'] / 100,
                'status' => 'success',
            ]);

            // Generate Tickets
            $metadata = $data['metadata'];
            $tickets = [];

            for ($i = 0; $i < $metadata['quantity']; $i++) {
                $ticketCode = 'TICKET-' . Str::upper(Str::random(8));
                $ticket = Ticket::create([
                    'event_id' => $metadata['event_id'],
                    'name' => $metadata['name'],
                    'email' => $data['customer']['email'],
                    'phone' => $metadata['phone'],
                    'ticket_code' => $ticketCode,
                    'qr_code' => '',
                    'payment_reference' => $reference,
                    'status' => 'valid',
                ]);

                // Update QR locally here
                $qrcode = (new \chillerlan\QRCode\QRCode)->render($ticketCode);
                $ticket->update(['qr_code' => $qrcode]);

                $tickets[] = $ticket;

                // Send Email
                try {
                    \Illuminate\Support\Facades\Mail::to($ticket->email)->send(new \App\Mail\TicketPurchased($ticket));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Mail sending failed: ' . $e->getMessage());
                }
            }

            return redirect()->route('ticket.show', ['code' => $tickets[0]->ticket_code])->with('success', 'Tickets purchased successfully!');
        }

        return redirect()->route('home')->with('error', 'Payment verification failed.');
    }
}
