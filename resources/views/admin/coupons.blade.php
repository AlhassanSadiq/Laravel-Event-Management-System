<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupons - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; margin: 0; padding: 0; }
        .sidebar { 
            width: 250px; 
            background: #1A1E5A; 
            color: white; 
            position: fixed; 
            height: 100vh; 
            padding: 20px 0;
            transition: 0.3s;
            z-index: 1000;
        }
        .sidebar.active { left: 0; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 15px 25px; transition: background 0.3s; }
        .sidebar a:hover { background: #3B2A8F; }
        .main-content { margin-left: 250px; padding: 40px; transition: 0.3s; }
        
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1A1E5A;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            z-index: 1100;
            cursor: pointer;
            font-weight: bold;
            border: none;
        }

        .card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .form-inline { display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap; }
        .form-group { margin-bottom: 0; flex: 1; min-width: 150px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.8rem;}
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        
        .table-responsive { width: 100%; overflow-x: auto; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; white-space: nowrap; }
        th { background: #f9f9f9; color: #555; }
        
        .btn { padding: 10px 20px; background: #6C4BFF; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-danger { background: #E53935; }
        .alert { padding: 15px; background: #e8f5e9; color: #2e7d32; border-radius: 8px; margin-bottom: 20px; }

        @media (max-width: 992px) {
            .sidebar { left: -250px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; padding: 60px 20px 20px; }
            .mobile-toggle { display: block; }
            .form-inline { flex-direction: column; align-items: stretch; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">☰ MENU</button>

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
        <h1>Coupons Management</h1>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="card">
            <h3>Add New Coupon</h3>
            <form action="{{ route('admin.coupons.store') }}" method="POST" class="form-inline">
                @csrf
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" name="code" placeholder="e.g. SAVE10" required>
                </div>
                <div class="form-group">
                    <label>Discount Amount</label>
                    <input type="number" name="discount_amount" required>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="type">
                        <option value="fixed">Fixed (₦)</option>
                        <option value="percentage">Percentage (%)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="date" name="expires_at">
                </div>
                <button type="submit" class="btn">Create Coupon</button>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Type</th>
                        <th>Expires At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td><strong>{{ $coupon->code }}</strong></td>
                        <td>{{ number_format($coupon->discount_amount) }}</td>
                        <td>{{ ucfirst($coupon->type) }}</td>
                        <td>{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('M d, Y') : 'Never' }}</td>
                        <td>
                            <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
