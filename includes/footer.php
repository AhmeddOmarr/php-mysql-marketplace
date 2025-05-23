<footer class="footer">
    <style>
        .footer {
            background-color: #001f3f !important;
            color:#90e0ef;
            padding: 30px 0;
            position: relative;
            overflow: hidden;
            border-radius: 40px;
        }

        .footer a {
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .footer a:hover {
            color: #90e0ef;
            text-decoration: none;
            transform: translateX(5px);
        }

        .footer__about__logo h2 {
            font-weight: 700;
            font-size: 2rem;
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .footer__widget ul li a {
            color: #ffffff;
        }

        .footer__widget ul li a i {
            color: #ffffff;
            transition: color 0.3s ease;
            margin-right: 5px;
        }

        .footer__widget ul li a:hover {
            color: #90e0ef;
        }

        .footer__widget ul li a:hover i {
            color: #90e0ef;
        }

        .payment-methods {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .payment-methods i {
            font-size: 2rem;
            color: #ffffff;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .payment-methods i:hover {
            opacity: 1;
            transform: translateY(-3px);
        }

        .site-btn {
            background: #ffffff;
            color: #001f3f;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .site-btn:hover {
            background: #d6e4f0;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .footer__widget h6 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
            color: #ffffff;
        }

        .footer__widget h6:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 2px;
            background: #90e0ef;
        }

        .footer__widget__social a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 50px !important;
            height: 50px !important;
            background: #90e0ef !important;
            border-radius: 50% !important;
            margin-right: 10px !important;
            transition: all 0.3s ease !important;
            color: #001f3f !important;
            font-size: 1.5rem !important;
            border: 1px solid #90e0ef !important;
        }

        .footer__widget__social a:hover {
            background: linear-gradient(135deg, #0043b0, #001f3f) !important;
            color: #ffffff !important;
            transform: scale(1.2) translateY(-5px) !important;
            border-color: #001f3f !important;
        }

        .footer__widget__social a i {
            color: #001f3f !important;
        }

        .footer__widget__social a:hover i {
            color: #ffffff !important;
        }

        .footer ul li,
        .footer p {
            color: #ffffff;
        }

        /* Enhanced Styles */
        .footer {
            border-radius: 60px 0;
            padding: 40px 0;
            margin-top: 20px;
            box-shadow: 2px -15px 25px rgba(0, 0, 0, 0.1);
        }

        .footer__about {
            text-align: center;
        }

        .footer__about__logo h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .footer__about ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .footer__about ul li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
        }

        .footer__widget h6 {
            font-size: 1.4rem;
            margin-bottom: 25px;
        }

        .footer__widget ul {
            list-style: none;
            padding-left: 0;
        }

        .footer__widget ul li {
            margin-bottom: 0.75rem;
        }

        .footer__widget ul li a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-methods {
            justify-content: center;
            margin-top: 1rem;
        }


        .payment-methods i {
            font-size: 3rem;
            opacity: 0.7;
        }

        .payment-methods i:hover {
            opacity: 1;
            transform: scale(1.1) translateY(-5px);
        }

        .site-btn {
            padding: 12px 30px;
            font-size: 1.1rem;
        }

        .footer__widget__social {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .footer__widget__social a {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .footer__widget__social a:hover {
            transform: scale(1.2) translateY(-5px);
            background: #90e0ef;
        }

        .footer p {
            text-align: center;
        }

        .newsletter-input {
            border-radius: 30px;
        }

        .footer-email-text {
            /* color: white; */
            color: #ffffff;
        }

        .newsletter-text {
            /* color: white; */
            color: #ffffff;
            
        
    
        }

        /* Remove any conflicting styles */
        .footer__widget .footer__widget__social a:hover {
            background: linear-gradient(135deg, #0043b0, #001f3f) !important;
            color: #ffffff !important;
            border-color: #001f3f !important;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <h2>أجرلي</h2>
                    </div>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Cairo, Egypt</li>
                        <li><i class="fas fa-phone"></i> +20 123 456 7890</li>
                        <li><i class="fas fa-envelope"></i> <span class="footer-email-text">info@agarly.com</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>Quick Links</h6>
                    <ul>
                        <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Our Products</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Services</a></li>
                        <li><a href="contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>Payment Options</h6>
                    <div class="payment-methods">
                        <i class="fab fa-cc-visa" title="Visa"></i>
                        <i class="fab fa-cc-apple-pay" title="Apple Pay"></i>
                        <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                        <i class="fab fa-cc-paypal" title="PayPal"></i>
                        <i class="fab fa-cc-amazon-pay" title="Amazon Pay"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>Newsletter</h6>
                    <p class="newsletter-text">Subscribe for updates and special offers</p>
                    <form action="#">
                        <input type="text" placeholder="Your email" class="form-control mb-2 newsletter-input"
                            style="background: #00264d; color: white; border: 1px solid rgba(255,255,255,0.3);">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__widget__social mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/agrly_eg?igsh=d21yYzBycjhxNDJv" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
