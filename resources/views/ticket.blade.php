<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Ticket - {{ $ticket->ticket_code }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .ticket-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            overflow: hidden;
            border-top: 5px solid #6C4BFF;
            text-align: center;
            padding-bottom: 20px;
        }

        .header {
            background: rgba(108, 75, 255, 0.1);
            padding: 20px;
        }

        .header h2 {
            margin: 0;
            color: #1A1E5A;
        }

        .header p {
            margin: 5px 0 0;
            color: #555;
            font-weight: 600;
        }

        .qr-section {
            padding: 20px;
        }

        .qr-section img {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 10px;
        }

        .details {
            padding: 0 20px;
            text-align: left;
        }

        .details p {
            margin: 10px 0;
            font-size: 1.1rem;
            border-bottom: 1px dashed #eee;
            padding-bottom: 10px;
        }

        .details strong {
            color: #1A1E5A;
        }

        .print-btn {
            background: #1A1E5A;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="ticket-card">
        <div class="header">
            <h2>{{ $ticket->event->name }}</h2>
            <p>{{ \Carbon\Carbon::parse($ticket->event->date)->format('F jS, Y') }} | {{ $ticket->event->location }}</p>
        </div>

        <div class="qr-section">
            <img src="{{ $ticket->qr_code }}" alt="QR Code">
            <p><strong>Code:</strong> {{ $ticket->ticket_code }}</p>
        </div>

        <div class="details">
            <p><strong>Attendee Name:</strong> {{ $ticket->name }}</p>
            <p><strong>Ticket ID:</strong> {{ $ticket->ticket_code }}</p>
            <p><strong>Payment Ref:</strong> {{ $ticket->payment_reference }}</p>
            <p><strong>Status:</strong> <span style="color: {{ $ticket->status === 'valid' ? 'green' : 'red' }}; font-weight: bold;">{{ strtoupper($ticket->status) }}</span></p>
        </div>

        <button class="print-btn" onclick="window.print()">Print Ticket</button>
        <button id="download-btn" class="print-btn" style="background: #E53935;">Download as Image</button>
    </div>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        document.getElementById('download-btn').addEventListener('click', function() {
            const ticket = document.querySelector('.ticket-card');
            const btn = this;
            const printBtn = document.querySelector('.print-btn');
            
            // Hide buttons for the screenshot
            btn.style.display = 'none';
            printBtn.style.display = 'none';
            
            html2canvas(ticket).then(canvas => {
                const link = document.createElement('a');
                link.download = 'ticket-{{ $ticket->ticket_code }}.png';
                link.href = canvas.toDataURL();
                link.click();
                
                // Show buttons again
                btn.style.display = 'inline-block';
                printBtn.style.display = 'inline-block';
            });
        });
    </script>
</body>

</html>