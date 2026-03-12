<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Ticket - AWE Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #1A1E5A;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }

        .verify-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 20px;
            font-size: 1.1rem;
            text-align: center;
        }

        .btn {
            width: 100%;
            background: #6C4BFF;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #4b36c6;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        #reader {
            width: 100%;
            margin-top: 20px;
            display: none;
        }

        .scan-btn {
            background: #E53935;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="{{ route('admin.dashboard') }}">← Back to Dashboard</a>
        <span>Ticket Verification</span>
    </div>

    <div class="container">

        @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success')['message'] }}<br>
            <small>Payment Ref: {{ session('success')['payment_reference'] }}</small>
        </div>
        @endif

        <div class="verify-box">
            <h2>Manual Entry</h2>
            <form action="{{ route('admin.verify.post') }}" method="POST" id="verify-form">
                @csrf
                <div class="form-group">
                    <input type="text" name="code" id="ticket-code" placeholder="Enter Ticket Code (e.g. TICKET-XYZ123)" required>
                </div>
                <button type="submit" class="btn">Verify Ticket</button>
            </form>

            <hr style="margin: 30px 0; border: 0; border-top: 1px dashed #ccc;">

            <h2>Or Scan QR Code</h2>
            <button class="btn scan-btn" id="start-scan-btn" onclick="startQR()">Start Scanner</button>

            <div id="reader"></div>
        </div>

    </div>

    <script>
        function startQR() {
            document.getElementById('reader').style.display = 'block';
            document.getElementById('start-scan-btn').style.display = 'none';

            let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: 250
            });
            html5QrcodeScanner.render(onScanSuccess);
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Fill the input and submit the form
            document.getElementById('ticket-code').value = decodedText;
            document.getElementById('verify-form').submit();
        }
    </script>
</body>

</html>