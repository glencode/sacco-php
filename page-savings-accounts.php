<?php
// page-savings-accounts.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savings Accounts - Secure Your Financial Future</title>
    <style>
        :root {
            --primary: #B1F0F7;
            --secondary: #81BFDA;
            --accent: #F5F0CD;
            --warm: #FADA7A;
            --text-dark: #2C3E50;
            --text-light: #34495E;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 50px;
            padding: 40px 0;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--secondary), var(--text-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
            margin-bottom: 50px;
        }

        .content-section {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .content-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        .content-text {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: var(--text-light);
        }

        .benefits-list {
            list-style: none;
            margin: 30px 0;
        }

        .benefits-list li {
            margin: 15px 0;
            padding: 15px;
            background: var(--accent);
            border-radius: 10px;
            border-left: 5px solid var(--secondary);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .benefits-list li:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .benefit-title {
            font-weight: bold;
            color: var(--text-dark);
            font-size: 1.1rem;
        }

        .benefit-desc {
            color: var(--text-light);
            margin-top: 5px;
        }

        .image-section {
            position: relative;
            text-align: center;
        }

        .hero-image {
            width: 100%;
            max-width: 500px;
            height: 400px;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .hero-image::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .cta-section {
            text-align: center;
            margin: 50px 0;
            padding: 40px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .cta-button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(45deg, var(--secondary), var(--warm));
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 50px 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--warm);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-circle:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-circle:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .content-section {
                padding: 25px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="container">
        <header>
            <h1 class="hero-title">Savings Accounts</h1>
            <p class="hero-subtitle">Your journey to financial freedom starts here</p>
        </header>

        <div class="main-content">
            <div class="content-section">
                <h2 class="content-title">Ready to turn your financial dreams into reality?</h2>
                <p class="content-text">
                    Discover our range of savings products, thoughtfully designed to help you achieve your unique goals. 
                </p>
                
                <p class="content-text" style="font-weight: bold; color: var(--text-dark);">
                    Enjoy the benefits of:
                </p>

                <ul class="benefits-list">
                    <li>
                        <div class="benefit-title">💰 High-interest returns</div>
                        <div class="benefit-desc">Watch your money grow faster with competitive rates</div>
                    </li>
                    <li>
                        <div class="benefit-title">🎯 Multiple savings options</div>
                        <div class="benefit-desc">Find the perfect fit for your unique aspirations</div>
                    </li>
                    <li>
                        <div class="benefit-title">⚡ Easy account management</div>
                        <div class="benefit-desc">Take control of your savings effortlessly with our tools</div>
                    </li>
                </ul>

                <p class="content-text" style="font-weight: bold; font-size: 1.2rem;">
                    Secure your future and start building your wealth today. It's simpler than you think!
                </p>
            </div>

            <div class="image-section">
                <div class="hero-image">
                    💎✨
                    <div style="position: absolute; bottom: 20px; font-size: 1rem; color: rgba(255,255,255,0.8);">
                        Your Financial Dreams
                    </div>
                </div>
            </div>
        </div>

        <div class="cta-section">
            <h3 style="margin-bottom: 20px; font-size: 2rem;">Start Your Savings Journey Today</h3>
            <p style="margin-bottom: 30px; font-size: 1.1rem; color: var(--text-light);">
                Join thousands of satisfied customers who have secured their financial future with us.
            </p>
            <a href="#" class="cta-button">Open Your Account Now</a>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🏦</div>
                <h4>Trusted Institution</h4>
                <p>FDIC insured with decades of reliable service and customer satisfaction.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h4>Digital Banking</h4>
                <p>Manage your savings anytime, anywhere with our user-friendly mobile app.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h4>Secure & Safe</h4>
                <p>Advanced security measures protect your money and personal information.</p>
            </div>
        </div>
    </div>
     <!-- Load jQuery and your script at the bottom -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/main.js?ver=1.0.0"></script>
</body>
</html>