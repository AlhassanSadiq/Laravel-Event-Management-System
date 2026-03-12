<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBS Workshop - AWE Academy</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1A1E5A;
            --primary-light: #3B2A8F;
            --accent: #E53935;
            --violet: #6C4BFF;
            --white: #FFFFFF;
            --gray-light: #F8F9FA;
            --text-dark: #1A1E5A;
            --text-muted: #555;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--white);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* --- Hero Section --- */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 100px 0 80px;
            text-align: center;
            border-bottom-right-radius: 60px;
        }

        .hero-tag {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 100px;
            display: inline-block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 3.8rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 16px;
            letter-spacing: -1px;
        }

        .hero h2 {
            font-size: clamp(1.1rem, 3vw, 1.6rem);
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 40px;
        }

        .hero-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .info-pill {
            background: var(--white);
            color: var(--primary);
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .info-pill.price { background: var(--accent); color: var(--white); }

        .cta-primary {
            display: inline-block;
            background: var(--accent);
            color: var(--white);
            padding: 20px 48px;
            border-radius: 100px;
            font-size: 1.2rem;
            font-weight: 800;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 15px 30px rgba(229, 57, 53, 0.3);
        }

        .cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(229, 57, 53, 0.4);
        }

        /* --- Section Styling --- */
        section { padding: 80px 0; }
        
        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-header h3 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .section-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* --- Learning List --- */
        .learning-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        .learning-card {
            background: var(--gray-light);
            padding: 30px;
            border-radius: 20px;
            border-left: 6px solid var(--violet);
            transition: transform 0.3s;
        }

        .learning-card:hover { transform: translateX(10px); }

        .learning-card p {
            font-weight: 500;
            font-size: 1.1rem;
            color: var(--primary);
        }

        /* --- Purchase Form --- */
        .purchase-section {
            background: var(--primary);
            color: var(--white);
            border-top-left-radius: 60px;
        }

        .purchase-card {
            background: var(--white);
            color: var(--text-dark);
            padding: 50px;
            border-radius: 30px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 30px 60px rgba(0,0,0,0.2);
        }

        .form-group { margin-bottom: 24px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 16px;
            border: 2px solid #EEE;
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--violet);
        }

        .submit-btn {
            width: 100%;
            background: var(--primary);
            color: var(--white);
            padding: 18px;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 800;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .submit-btn:hover { opacity: 0.9; }

        /* --- Footer --- */
        footer {
            background: #111;
            color: #888;
            padding: 60px 0;
            text-align: center;
        }

        footer p { margin-bottom: 10px; }
        footer a { color: var(--white); text-decoration: none; font-weight: 600; }

        @media (max-width: 768px) {
            .hero { padding: 60px 0; border-bottom-right-radius: 30px; }
            .purchase-section { border-top-left-radius: 30px; }
            .purchase-card { padding: 30px; }
        }
    </style>
</head>
<body>

    <header class="hero">
        <div class="container">
            <div class="hero-tag">AWE Academy Presents</div>
            <h1>OBS: Online Business Strategy <br> through Content</h1>
            <h2>Turn Content Into Sales Workshop</h2>
            
            <div class="hero-info">
                <div class="info-pill">📍 {{ $event->location }}</div>
                <div class="info-pill">📅 {{ \Carbon\Carbon::parse($event->date)->format('F jS, Y') }}</div>
                <div class="info-pill price">
                    @if($event->discount_price > 0)
                        <span style="text-decoration: line-through; opacity: 0.6; font-size: 0.9rem; margin-right: 5px;">₦{{ number_format($event->price, 0) }}</span>
                        ₦{{ number_format($event->discount_price, 0) }}
                    @else
                        ₦{{ number_format($event->price, 0) }}
                    @endif
                </div>
            </div>

            <a href="#register" class="cta-primary">SECURE MY TICKET</a>
            <p style="margin-top: 24px; font-weight: 300; opacity: 0.8;">Limited Spots Available – Enroll Today</p>
        </div>
    </header>

    <section class="learning">
        <div class="container">
            <div class="section-header">
                <h3>Master Your Content</h3>
                <p>Everything you need to turn views into high-value clients.</p>
            </div>

            <div class="learning-grid">
                <div class="learning-card"><p>Convert views, likes and followers into paying customers</p></div>
                <div class="learning-card"><p>Create content that generates leads, sales, authority and trust</p></div>
                <div class="learning-card"><p>Increase sales without increasing ad spend</p></div>
                <div class="learning-card"><p>Monetize your audience through multiple income streams</p></div>
                <div class="learning-card"><p>Use storytelling to sell without sounding salesy</p></div>
                <div class="learning-card"><p>Turn your personal story into a powerful marketing asset</p></div>
                <div class="learning-card"><p>Structure stories that naturally lead to sales</p></div>
                <div class="learning-card"><p>Create magnetic hooks that stop the scroll and demand attention</p></div>
                <div class="learning-card"><p>Scale your personal brand into a predictable revenue machine</p></div>
            </div>
        </div>
    </section>

    <section class="audience" style="background-color: var(--gray-light);">
        <div class="container" style="text-align: center;">
            <div class="section-header">
                <h3>Who Is This For?</h3>
            </div>
            <p style="font-size: 1.3rem; max-width: 800px; margin: 0 auto; color: var(--text-dark); font-weight: 500;">
                Content creators, entrepreneurs, social media managers, and anyone tired of posting without results.
            </p>
        </div>
    </section>

    <section class="purchase-section" id="register">
        <div class="container">
            <div class="section-header" style="color: white;">
                <h3 style="color: white;">Join the Workshop</h3>
                <p style="color: rgba(255,255,255,0.7);">Register now to secure your spot in Abuja.</p>
            </div>

            <div class="purchase-card">
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" required placeholder="Enter your full name">
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" required placeholder="you@example.com">
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" required placeholder="e.g. +234 800 000 0000">
                    </div>

                    <div class="form-group">
                        <label>Coupon Code (Optional)</label>
                        <input type="text" name="coupon_code" placeholder="Enter code if you have one">
                    </div>

                    <div class="form-group">
                        <label>Ticket Quantity</label>
                        <select name="quantity" required>
                            <option value="1">1 Ticket</option>
                            <option value="2">2 Tickets</option>
                            <option value="3">3 Tickets</option>
                            <option value="4">4 Tickets</option>
                            <option value="5">5 Tickets</option>
                        </select>
                    </div>

                    <button type="submit" class="submit-btn">GET TICKETS NOW</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>Email: <a href="mailto:hello@aweacademy.net">hello@aweacademy.net</a> | Web: <a href="http://www.aweacademy.net" target="_blank">www.aweacademy.net</a></p>
            <p>Support: +234 806 555 0861, +234 701 414 1413</p>
            <p style="margin-top: 20px; font-size: 0.8rem; opacity: 0.5;">&copy; {{ date('Y') }} AWE Academy. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>