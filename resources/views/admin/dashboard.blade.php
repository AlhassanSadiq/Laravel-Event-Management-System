<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AWE Academy</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            background: #1A1E5A;
            color: white;
            position: fixed;
            height: 100vh;
            padding: 20px 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px 25px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #3B2A8F;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-top: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            border-bottom: 4px solid #6C4BFF;
        }

        .stat-card h3 {
            margin: 0;
            color: #777;
            font-size: 1rem;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: 800;
            color: #1A1E5A;
            margin-top: 10px;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-form input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-form button {
            padding: 10px 20px;
            background: #6C4BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 40px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f9f9f9;
            color: #555;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status.valid {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status.used {
            background: #ffebee;
            color: #c62828;
        }

        .status.success {
            background: #e8f5e9;
            color: #2e7d32;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>AWE Academy</h2>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.verify') }}">Verify Tickets</a>
        <a href="{{ route('admin.manual.register') }}">Manual Registration</a>
        <a href="{{ route('admin.event.edit') }}">Event Settings</a>
        <a href="{{ route('admin.coupons.index') }}">Coupons</a>
        <a href="{{ route('admin.email.test') }}">Test Email</a>
        <a href="/">View Site</a>
        <a href="{{ route('admin.logout') }}">Logout</a>
    </div>

    <div class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="margin: 0;">Dashboard</h1>
            <a href="{{ route('admin.manual.register') }}" style="background: #E53935; color: white; padding: 12px 20px; text-decoration: none; border-radius: 8px; font-weight: bold;">+ ISSUE MANUAL TICKET</a>
        </div>

        @if(session('success'))
            <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px;">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px;">{{ session('error') }}</div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Tickets Sold</h3>
                <div class="value">{{ number_format($totalTicketsSold) }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="value">₦{{ number_format($totalRevenue, 2) }}</div>
            </div>
            <div class="stat-card">
                <h3>Attendees Checked In</h3>
                <div class="value">{{ number_format($attendeesCheckedIn) }}</div>
            </div>
        </div>

        <div class="top-actions">
            <h2>Recent Tickets</h2>
            <form class="search-form" method="GET" action="{{ route('admin.dashboard') }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search name, email or code...">
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Ticket Code</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Ref</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr>
                    <td><strong><a href="{{ route('ticket.show', $ticket->ticket_code) }}" target="_blank">{{ $ticket->ticket_code }}</a></strong></td>
                    <td>{{ $ticket->name }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td>{{ $ticket->payment_reference }}</td>
                    <td><span class="status {{ strtolower($ticket->status) }}">{{ strtoupper($ticket->status) }}</span></td>
                    <td>{{ $ticket->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        <a href="{{ route('ticket.show', $ticket->ticket_code) }}" target="_blank" style="color: #6C4BFF; font-weight: bold; text-decoration: none;">Download</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- We would also paginate and list payments, excluded for brevity but can be added in a tab -->

    </div>

</body>

</html>