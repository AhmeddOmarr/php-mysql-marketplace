<?php include 'check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | اجرلي</title>
    <link rel="icon" type="image/png" href="./src/images/agarlylogo.png">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/style.css" type="text/css">
    <style>
    .about-us-bg {
        background-image: url("./src/images/about2.jpg");
        background-size: cover;
        background-position: center;
        height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        padding-top: 100px; /* Increased from 70px to 100px */
        margin-top: 30px; /* Added margin to push it down from header */
    }

    .about-us-bg h2 {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .about-us-bg p {
        font-size: 1.2rem;
        max-width: 60%;
        margin: 0 auto;
        display: none;
    }

    .about-us__pic img {
        max-width: 300px;
        height: auto;
        border-radius: 8px;
        object-fit: cover;
        object-position: top;
    }

    .about-us__content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .about-us__text {
        flex: 1;
        margin-right: 0;
    }

    .about-us__pic {
        flex: 1;
        margin-left: 0;
    }
    </style>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <section class="about-us-bg">
       
    </section>

    <section class="about-us spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-us__content">
                        <div class="about-us__pic">
                            <img src="./src/images/about1.jpg" alt="About اجرلي" class="img-fluid rounded">
                        </div>
                        <div class="about-us__text">
                            <h3>Welcome to <span style="color:#001f3f;">اجرلي</span></h3>
                            <p style="text-align: justify;">اجرلي is a unique online renting platform for pre-loved electronic devices such as tablets, phones, speakers, and more. We offer an affordable, eco-friendly alternative to buying new gadgets. Whether you need a device for a few days, weeks, or months — اجرلي has you covered.</p>
                            <h5>Why Choose Us?</h5>
                            <ul>
                                <li>✔️ Affordable rental prices for top-quality devices.</li>
                                <li>✔️ Hassle-free online booking system.</li>
                                <li>✔️ Customer ratings and reviews for reliable choices.</li>
                                <li>✔️ Secure and verified electronic devices only.</li>
                                <li>✔️ Easy wishlist and cart management.</li>
                            </ul>
                            <p>We're committed to making electronics accessible for everyone, reducing e-waste, and promoting a smart, sharing economy. Join our community and rent smarter with <strong>اجرلي</strong> today!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include './includes/footer.php'; ?>

    <script src="./src/js/jquery-3.3.1.min.js"></script>
    <script src="./src/js/bootstrap.min.js"></script>
</body>

</html>