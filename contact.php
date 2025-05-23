<?php include 'check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | اجرلي</title>
    <link rel="icon" type="image/png" href="./src/images/agarlylogo.png">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/style.css" type="text/css">
    <style>
        /* Button Styles */
        .gradient-btn {
            background: #001f3f;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 10px 30px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .gradient-btn:hover {
            background: linear-gradient(135deg, #0077ff, #001f3f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: white;
        }
        
        /* Banner Styles */
        .contact-banner {
            background-image: url('./src/images/contact.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            margin: 20px;
            border-radius: 15px;
            position: relative;
        }
        .contact-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 31, 63, 0.7);
            border-radius: 15px;
        }
        .contact-banner h2 {
            position: relative;
            color: #fff;
            font-weight: bold;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            font-size: 2.5rem;
        }
        
        /* Contact Form Styles */
        .contact__form {
            padding: 30px;
            border: 2px solid #001f3f;
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 128, 0.2);
        }
        
        /* Contact Info Styles */
        .contact__text ul li {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .contact__text ul li i {
            color: #001f3f;
            margin-right: 10px;
            width: 20px;
        }
        
        /* Social Icons */
        .contact__social a {
            display: inline-block;
            margin-right: 15px;
            color: #001f3f;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        .contact__social a:hover {
            color: #0077ff;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <section class="contact-banner">
        <div class="container text-center">
            <h2>Contact Us</h2>
        </div>
    </section>

    <section class="contact spad">
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-lg-6">
                    <div class="contact__text">
                        <h3>Get In Touch</h3>
                        <p>Have questions about our rental service, a product, or anything else?<br> Reach out — we'd love to hear from you.</p>
                        
                        <ul style="padding-left: 0; list-style: none;">
                            <li><i class="fa fa-map-marker"></i> Cairo, Egypt</li>
                            <li><i class="fa fa-phone"></i> +20 123 456 7890</li>
                            <li><i class="fa fa-envelope"></i> support@agarly.com</li>
                        </ul>

                        <div class="contact__social" style="margin-top: 30px;">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-whatsapp"></i></a>
                        </div>
                        
                        <div class="text-center my-4">
                            <img src="./src/images/help-desk.jpg" alt="Help Desk" style="max-width: 150px; margin: 20px auto;">
                            <p style="font-size: 18px; font-weight: 500; color: #333;">
                                We're here to help you stay connected and make your renting experience smooth and easy!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-6">
                    <div class="contact__form">
                        <h3>Send Us a Message</h3>
                        <form action="#" method="post">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Your Name" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Your Email" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" placeholder="Subject" required class="form-control">
                            </div>
                            <div class="form-group">
                                <textarea name="message" placeholder="Message" rows="5" required class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn gradient-btn d-block mx-auto">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include './includes/footer.php'; ?>

    <script src="./src/js/jquery-3.3.1.min.js"></script>
    <script src="./src/js/bootstrap.min.js"></script>
    <script>
        // Fix for categories if not working
        $(document).ready(function() {
            // Ensure category dropdown works
            $('.hero__categories__all').on('click', function() {
                $('.hero__categories ul').slideToggle();
            });
            
            // Make sure all links work
            $('a[href*="category.php"]').on('click', function(e) {
                e.preventDefault();
                window.location.href = $(this).attr('href');
            });
        });
    </script>
</body>

</html>