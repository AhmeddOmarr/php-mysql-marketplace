<?php include 'check.php'; ?>

<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Agarly Rental Marketplace">
    <meta name="keywords" content="Agarly, rental, marketplace, items">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/php-mysql-marketplace/manifest.json">
    <meta name="theme-color" content="#001f3f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Agarly">
    <link rel="apple-touch-icon" href="/php-mysql-marketplace/src/images/agarlylogo.png">
    <meta name="msapplication-TileImage" content="/php-mysql-marketplace/src/images/agarlylogo.png">
    <meta name="msapplication-TileColor" content="#001f3f">
    
    <link rel="icon" href="/php-mysql-marketplace/favicon.ico">
    <title>Agarly | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="./src/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="./src/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Override existing green colors with navy blue */
        body {
            /* If there's a default green text or background, you can set it here. */
            /* color: #001f3f; */
        }

        /* Common elements that might have green */
        .primary-btn,
        .site-btn {
            background-color: #001f3f !important; /* Navy Blue */
        }

        .primary-btn:hover,
        .site-btn:hover {
            background: linear-gradient(135deg, #00b4d8, #0043b0) !important; /* Gradient Navy Blue */
            color: #fff !important;
        }

        /* Specific Ogani template classes that are often green */
        .header__top__right__auth a {
            color: #001f3f; /* Likely green for login/register */
            transition: color 0.3s ease; /* Smooth transition */
        }

        .header__top__right__auth a:hover {
            color: #0043b0; /* Hover effect */
        }

        .hero__categories ul li a {
            color: #001f3f; /* Category list links */
            transition: color 0.3s ease; /* Smooth transition */
        }

        .hero__categories ul li a:hover {
            color: #0043b0;
        }

        .hero__search__phone .hero__search__phone__icon {
            background-color: #001f3f; /* Phone icon background */
        }

        .hero__search__phone .hero__search__phone__text h5 {
            color: #001f3f; /* Phone number text */
        }

        /* --- Product Hover Icons (fav, add to cart, details) --- */
        /* This rule specifically targets the hover state of the product action icons */
        .product__item__pic__hover li a {
            background-color: #001f3f; /* Navy Blue */
            border: 1px solid #001f3f; /* Navy Blue border */
            color: #fff; /* White icon color */
            transition: all 0.3s ease; /* Smooth transition */
        }

        .product__item__pic__hover li a:hover {
            background-color: #0043b0 !important; /* Darker Navy Blue on hover */
            border-color: #0043b0 !important; /* Darker Navy Blue border on hover */
            color: #fff !important; /* White icon color on hover */
            transform: translateY(-3px); /* Subtle lift on hover */
        }

        /* --- General Product Item Enhancements (excluding product__discount items) --- */
        /* Applied to the product cards in the main grid */
        .product__item {
            border: 1px solid #f0f0f0; /* Subtle light gray border */
            border-radius: 8px; /* Slightly rounded corners for a modern feel */
            overflow: hidden; /* Ensures content respects border-radius */
            transition: box-shadow 0.3s ease, transform 0.3s ease; /* Smooth transitions for hover effects */
            margin-bottom: 30px; /* Consistent spacing between product cards */
            background-color: #ffffff; /* Explicit white background */
        }

        .product__item:hover {
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.1); /* Soft shadow for a "lift" effect on hover */
            transform: translateY(-5px); /* Slight vertical lift on hover */
        }

        .product__item__pic {
            overflow: hidden; /* Ensures image doesn't overflow rounded corners */
            position: relative; /* Needed for absolute positioning of potential sale badge */
        }

        .product__item__pic img {
            width: 100%; /* Ensure image fills its container */
            display: block; /* Removes extra space below image */
            transition: transform 0.5s ease; /* Smooth zoom on image hover */
        }

        .product__item:hover .product__item__pic img {
            transform: scale(1.05); /* Slight zoom effect on the image when hovering over the card */
        }

        .product__item__text {
            padding: 20px; /* Ample padding inside the text area */
            text-align: center; /* Center align text for a cleaner look */
        }

        .product__item__text span {
            color: #001f3f; /* Navy Blue for category name */
            font-size: 14px; /* Standard font size */
            display: block; /* Ensures it takes full width */
            margin-bottom: 5px;
            font-weight: 600; /* Bolder category name */
            text-transform: uppercase; /* Uppercase for a subtle design touch */
            letter-spacing: 0.5px; /* Slight letter spacing */
        }

        .product__item__text h5 a {
            font-size: 19px; /* Slightly larger product name */
            font-weight: 700; /* Bolder product name */
            color: #333; /* Darker for better contrast and readability */
            margin-bottom: 10px;
            transition: color 0.3s ease; /* Smooth color change on hover */
            line-height: 1.3; /* Better line spacing for longer names */
        }

        .product__item__text h5 a:hover {
            color: #0043b0; /* Darker navy blue on hover for product name */
        }

        .product__item__price {
            color: #001f3f; /* Navy Blue for current price */
            font-size: 24px; /* Larger current price to stand out */
            font-weight: 800; /* Extra bold for emphasis */
            display: block;
            margin-top: 10px;
            white-space: nowrap; /* Prevent price from wrapping */
        }

        .product__item__price span {
            font-size: 16px; /* Appropriate size for old price */
            color: #999; /* Muted gray for old price */
            text-decoration: line-through; /* Strikethrough for old price */
            margin-left: 8px; /* Space between current and old price */
            font-weight: 400; /* Normal weight for old price */
        }

        /* --- Sidebar Category List Enhancement - Option 1: Soft Boxes on Hover --- */
        .sidebar__item ul {
            list-style: none; /* Remove default bullet points */
            padding: 0; /* Remove default padding */
            margin: 0;
        }

        .sidebar__item ul li {
            margin-bottom: 5px; /* Space between list items */
        }

        .sidebar__item ul li a {
            color: #555; /* Default text color */
            font-size: 16px;
            padding: 10px 15px; /* More padding for a larger clickable area */
            display: block; /* Makes the whole area clickable */
            border-radius: 5px; /* Slightly rounded corners for the "box" */
            transition: all 0.3s ease; /* Smooth transition for hover effects */
            text-decoration: none; /* Remove underlines */
        }

        .sidebar__item ul li a:hover {
            background-color: #f5f5f5; /* Very light gray background on hover */
            color: #001f3f; /* Darker navy blue text on hover */
            transform: translateX(5px); /* Subtle slide effect to the right */
        }

        /* Ensure the title remains bold and separated */
        .sidebar__item h4 {
            color: #001f3f;
            font-weight: 700;
            margin-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        /* --- Price Range Slider Enhancements --- */
        .ui-slider .ui-slider-range {
            background: #001f3f; /* Navy Blue fill for the slider range */
            border-radius: 5px; /* Rounded range bar */
        }

        .ui-state-default,
        .ui-widget-content .ui-state-default,
        .ui-widget-header .ui-state-default {
            background: #001f3f; /* Navy Blue for slider handles */
            border-color: #001f3f;
            border-radius: 50%; /* Circular handles */
            width: 18px; /* Slightly larger handles */
            height: 18px;
            top: -7px; /* Adjust vertical position */
            cursor: grab; /* Cursor hint for dragging */
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2); /* Subtle shadow for handles */
            transition: all 0.2s ease; /* Smooth transition on interaction */
        }

        .ui-state-default:active {
            cursor: grabbing; /* Cursor hint when actively dragging */
            transform: scale(1.1); /* Slight enlarge on active drag */
        }

        .price-input {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            gap: 10px;
        }

        .price-input input {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 8px 10px;
            font-size: 15px;
            color: #333;
            text-align: left;
            width: 120px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .price-input input:focus {
            border-color: #0043b0; /* Darker navy blue highlight on focus */
            box-shadow: 0 0 0 2px rgba(0, 67, 176, 0.2); /* Soft focus ring */
            outline: none; /* Remove default outline */
        }

        /* --- Section Titles (e.g., "New Arrivals", "Category Name") --- */
        .section-title h2 {
            font-size: 38px; /* Larger, more impactful titles */
            font-weight: 900; /* Very bold for strong hierarchy */
            color: #333; /* Dark gray for excellent contrast */
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 12px; /* Space for the underline */
        }

        .section-title h2:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100px; /* A more substantial underline */
            height: 4px; /* Thicker underline */
            background: #001f3f; /* Navy Blue underline */
            border-radius: 2px; /* Slightly rounded ends for the underline */
        }

        /* --- Filter Bar Refinements --- */
        .filter__item {
            border-bottom: 1px solid #f0f0f0; /* Light gray divider */
            padding-bottom: 25px;
            margin-bottom: 30px;
        }

        .filter__sort span {
            font-weight: 600;
            color: #555;
            margin-right: 10px;
        }

        .filter__sort select {
            border: 1px solid #ddd;
            padding: 10px 20px 10px 15px; /* More padding for better feel */
            border-radius: 5px;
            font-size: 15px;
            color: #555;
            appearance: none; /* Hide default browser arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23001f3f" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); /* Custom navy blue arrow */
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 18px;
            cursor: pointer;
            transition: border-color 0.3s ease; /* Smooth transition on hover/focus */
        }

        .filter__sort select:hover,
        .filter__sort select:focus {
            border-color: #0043b0; /* Darker navy blue border on hover/focus */
            outline: none;
        }

        .filter__found h6 {
            color: #555;
            font-size: 16px;
            font-weight: 400;
        }

        .filter__found h6 span {
            color: #001f3f; /* Navy Blue for the product count */
            font-weight: 700; /* Bolder product count */
        }

        .filter__option span {
            font-size: 22px; /* Slightly larger icons */
            color: #999;
            margin-left: 12px; /* More space between icons */
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .filter__option span:hover {
            color: #001f3f; /* Navy Blue on hover */
        }

        /* --- Pagination --- */
        .pagination {
            margin-top: 40px; /* More space above pagination */
            text-align: center; /* Center pagination links */
        }

        .pagination a {
            display: inline-flex; /* Use flex to easily center content */
            justify-content: center;
            align-items: center;
            width: 42px; /* Slightly larger buttons */
            height: 42px;
            border: 1px solid #ddd;
            border-radius: 5px; /* Rounded pagination buttons */
            margin: 0 4px; /* Consistent margin between buttons */
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            color: #001f3f; /* Navy blue for default numbers */
            text-decoration: none; /* Remove underline */
        }

        .pagination a.active,
        .pagination a:hover {
            background-color: #001f3f;
            color: #fff;
            border-color: #001f3f;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow on active/hover */
        }

        /* --- Footer Links & Icons --- */
        .footer__about ul li a:hover {
            color: #0043b0; /* Footer link hover */
        }

        .footer__copyright__text i {
            color: #001f3f; /* Heart icon in footer */
            font-size: 18px; /* Slightly larger heart icon */
        }

        /* --- Header Menu Enhancements --- */
        .humberger__menu__wrapper .humberger__menu__widget ul li.active a,
        .header__menu ul li.active a {
            color: #001f3f; /* Active menu item */
            font-weight: 700; /* Bolder for active menu item */
        }

        .header__menu ul li a {
            transition: color 0.3s ease; /* Smooth transition for menu items */
        }

        .header__menu ul li a:hover {
            color: #001f3f; /* Menu item hover */
        }

        .header__cart ul li {
            color: #001f3f; /* Cart icons */
        }

        .header__cart ul li span {
            background-color: #001f3f; /* Cart item count bubble */
            border-radius: 50%; /* Ensure it's perfectly round */
            padding: 2px 7px; /* Adjust padding for better look */
            font-size: 12px;
            font-weight: 600;
            line-height: 1; /* Prevent vertical misalignment */
        }

        /* --- DO NOT EDIT THIS - Keeping specific product__discount styles as requested --- */
        .product__discount__item__text span {
            color: #001f3f;
        }
        .product__discount__item__pic__hover li a {
            background-color: #001f3f;
            border: 1px solid #001f3f;
            color: #fff;
            transition: all 0.3s ease;
        }
        .product__discount__item__pic__hover li a:hover {
            background-color: #0043b0 !important;
            border-color: #0043b0 !important;
            color: #fff !important;
        }
    </style>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>category</h4>
                            <ul>
                                <?php
                                $categories = $query->select('categories', '*');
                                foreach ($categories as $category): ?>
                                    <li><a
                                            href="category.php?category=<?php echo $category['id'] ?>"><?php echo $category['category_name']; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="sidebar__item">
                            <h4>Price</h4>
                            <?php
                            $result = $query->executeQuery("SELECT MIN(price_current) AS min_price, MAX(price_current) AS max_price FROM products");
                            $row = $result->fetch_assoc();
                            $min_price = $row['min_price'];
                            $max_price = $row['max_price'];
                            ?>

                            <div class="price-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="<?php echo $min_price; ?>" data-max="<?php echo $max_price; ?>">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                </div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <input type="text" id="minamount" value="$<?php echo $min_price; ?>" readonly>
                                        <input type="text" id="maxamount" value="$<?php echo $max_price; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <?php
                    $categories = $query->select('categories', '*', 'LIMIT 3');
                    foreach ($categories as $category): ?>


                        <div class="product__discount">
                            <div class="section-title product__discount__title">

                                <h2><?php echo $category['category_name']; ?></h2>

                            </div>
                            <div class="row">
                                <div class="product__discount__slider owl-carousel">
                                    <?php
                                    $products = $query->select('products', '*', 'WHERE category_id = ' . $category['id'] . ' LIMIT 6');

                                    foreach ($products as $product):
                                        $product_name = $product['name'];
                                        $category_name = $category['category_name'];
                                        ;
                                        $price_current = $product['price_current'];
                                        $price_old = $product['price_old'];
                                        $product_id = $product['id'];
                                        $image = $query->select('product_images', 'image_url', "where product_id = '$product_id'")[0]['image_url'];
                                        ?>

                                        <div class="col-lg-4">
                                            <div class="product__discount__item">
                                                <div class="product__discount__item__pic set-bg"
                                                    data-setbg="./src/images/products/<?php echo $image ?>">
                                                    <ul class="product__item__pic__hover">
                                                        <li><a onclick="addToWishlist(<?php echo $product_id; ?>)"><i
                                                                    class="fa fa-heart"></i></a></li>
                                                        <li><a onclick="openProductDetails(<?php echo $product_id; ?>)"><i
                                                                    class="fa fa-retweet"></i></a></li>
                                                        <li><a onclick="addToCart(<?php echo $product_id; ?>)"><i
                                                                    class="fa fa-shopping-cart"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="product__discount__item__text">
                                                    <span><?php echo $category_name; ?></span>
                                                    <h5><a
                                                            onclick="openProductDetails(<?php echo $product_id; ?>)"><?php echo $product_name; ?></a>
                                                    </h5>
                                                    <div class="product__item__price">EGP <?php echo $price_current; ?>
                                                        <span>EGP <?php echo $price_old; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span>16</span> Products found</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $products = $query->select('products', '*', "LIMIT 15");
                        foreach ($products as $product):
                            $product_name = $product['name'];
                            $category_name = $query->select('categories', 'category_name', 'WHERE id=' . $product['category_id'])[0]['category_name'];
                            $price_current = $product['price_current'];
                            $price_old = $product['price_old'];
                            $product_id = $product['id'];
                            $image = $query->select('product_images', 'image_url', "where product_id = '$product_id'")[0]['image_url'];
                            ?>

                            <div class="col-lg-4">
                                <div class="product__discount__item">
                                    <div class="product__discount__item__pic set-bg"
                                        data-setbg="./src/images/products/<?php echo $image ?>">
                                        <ul class="product__item__pic__hover">
                                            <li><a onclick="addToWishlist(<?php echo $product_id; ?>)"><i
                                                        class="fa fa-heart"></i></a></li>
                                            <li><a onclick="openProductDetails(<?php echo $product_id; ?>)"><i
                                                        class="fa fa-retweet"></i></a></li>
                                            <li><a onclick="addToCart(<?php echo $product_id; ?>)"><i
                                                        class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__discount__item__text">
                                        <span><?php echo $category_name; ?></span>
                                        <h5><a
                                                onclick="openProductDetails(<?php echo $product_id; ?>)"><?php echo $product_name; ?></a>
                                        </h5>
                                        <div class="product__item__price">EGP <?php echo $price_current; ?>
                                            <span>EGP <?php echo $price_old; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php include './includes/footer.php'; ?>
    <?php include './includes/nav-buttons.php'; ?>

    <script src="./src/js/jquery-3.3.1.min.js"></script>
    <script src="./src/js/bootstrap.min.js"></script>
    <script src="./src/js/jquery.nice-select.min.js"></script>
    <script src="./src/js/jquery-ui.min.js"></script>
    <script src="./src/js/jquery.slicknav.js"></script>
    <script src="./src/js/mixitup.min.js"></script>
    <script src="./src/js/owl.carousel.min.js"></script>
    <script src="./src/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function addToCart(productId) {
            var xhr = new XMLHttpRequest();
            var url = 'add_to_cart.php?product_id=' + productId;
            xhr.open('GET', url, true);
            xhr.send();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Product added to cart!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                }
            };
        }

        function addToWishlist(productId) {
            var xhr = new XMLHttpRequest();
            var url = 'add_to_wishlist.php?product_id=' + productId;
            xhr.open('GET', url, true);
            xhr.send();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Product added to wishlist!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                }
            };
        }

        function openProductDetails(productId) {
            window.location.href = 'shop-details.php?product_id=' + productId;
        }
    </script>

    <!-- Service Worker Registration -->
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/php-mysql-marketplace/sw.js')
                .then(registration => {
                    console.log('ServiceWorker registration successful');
                })
                .catch(err => {
                    console.log('ServiceWorker registration failed: ', err);
                });
        });
    }

    // Handle "Add to Home Screen" prompt
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later
        deferredPrompt = e;
        
        // Show your custom "Add to Home Screen" button
        const addBtn = document.createElement('button');
        addBtn.textContent = 'Install App';
        addBtn.style.position = 'fixed';
        addBtn.style.bottom = '20px';
        addBtn.style.right = '20px';
        addBtn.style.zIndex = '1000';
        addBtn.style.padding = '10px 20px';
        addBtn.style.backgroundColor = '#001f3f';
        addBtn.style.color = 'white';
        addBtn.style.border = 'none';
        addBtn.style.borderRadius = '5px';
        addBtn.style.cursor = 'pointer';
        
        addBtn.addEventListener('click', () => {
            // Hide our user interface that shows our A2HS button
            addBtn.style.display = 'none';
            // Show the prompt
            deferredPrompt.prompt();
            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
            });
        });
        
        document.body.appendChild(addBtn);
    });
    </script>

</body>

</html>