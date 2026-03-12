<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Registration - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; margin: 0; padding: 0; }
        .sidebar { width: 250px; background: #1A1E5A; color: white; position: fixed; height: 100vh; padding: 20px 0;}
        .sidebar h2 { text-align: center; margin-bottom: 30px; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 15px 25px; transition: background 0.3s; }
        .sidebar a:hover { background: #3B2A8F; }
        .main-content { margin-left: 250px; padding: 40px; }
        
        .card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 600px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; }
        
        .btn { padding: 12px 24px; background: #E53935; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; font-size: 1rem; }
        .btn:hover { background: #c62828; }
        .alert { padding: 15px; background: #e8f5e9; color: #2e7d32; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>AWE Academy</h2>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.verify') }}">Verify Tickets</a>
        <a href="{{ route('admin.manual.register') }}" style="background: #3B2A8F;">Manual Registration</a>
        <a href="{{ route('admin.event.edit') }}">Event Settings</a>
        <a href="{{ route('admin.coupons.index') }}">Coupons</a>
        <a href="/">View Site</a>
        <a href="{{ route('admin.logout') }}">Logout</a>
    </div>

    <div class="main-content">
        <h1>Manual Ticket Registration</h1>
        <p style="color: #666; margin-bottom: 30px;">Use this form to issue tickets for payments received outside the website (e.g., Bank Transfer, Cash).</p>

        <div class="card">
            <form action="{{ route('admin.manual.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Attendee Full Name</label>
                    <input type="text" name="name" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label>Amount Paid (₦)</label>
                    <input type="number" name="amount" value="{{ $event->discount_price > 0 ? $event->discount_price : $event->price }}" required>
                </div>
                <button type="submit" class="btn">ISSUE MANUAL TICKET</button>
            </form>
        </div>
    </div>
</body>
</html>
