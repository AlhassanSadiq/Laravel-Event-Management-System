<x-mail::message>
    # Ticket Confirmed

    Hi {{ $ticket->name }},

    Your ticket for **{{ $ticket->event->name }}** is confirmed.

    **Event Details:**
    - **Date:** {{ \Carbon\Carbon::parse($ticket->event->date)->format('F jS, Y') }}
    - **Location:** {{ $ticket->event->location }}

    **Your Ticket Code:** {{ $ticket->ticket_code }}

    You can view and download your QR code ticket by clicking the link below:

    <x-mail::button :url="route('ticket.show', ['code' => $ticket->ticket_code])">
        View Ticket
    </x-mail::button>

    Alternatively, save this email to show at the event.

    Thanks,<br>
    AWE Academy
</x-mail::message>