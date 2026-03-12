<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;

class TicketController extends Controller
{
    public function show($code)
    {
        $ticket = Ticket::with('event')->where('ticket_code', $code)->firstOrFail();

        // Generate QR code on the fly or load from db
        if (!$ticket->qr_code) {
            $qrcode = (new QRCode)->render($code);
            $ticket->update(['qr_code' => $qrcode]);
        }

        return view('ticket', compact('ticket'));
    }

    public function verifyPage()
    {
        return view('admin.verify');
    }

    public function verifyTicket(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return back()->with('error', 'Ticket code is required.');
        }

        $ticket = Ticket::where('ticket_code', $code)->first();

        if (!$ticket) {
            return back()->with('error', 'Invalid Ticket Code.');
        }

        if ($ticket->status === 'used') {
            return back()->with('error', 'Ticket Already Used by ' . $ticket->name);
        }

        // Mark as used
        $ticket->update(['status' => 'used']);

        return back()->with('success', [
            'message' => 'Valid Ticket! Attendee: ' . $ticket->name,
            'payment_reference' => $ticket->payment_reference
        ]);
    }
}
