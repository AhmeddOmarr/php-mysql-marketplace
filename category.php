<?php include 'check.php';

$category_id = $query->validate($_GET['category']);
$product_id = $query->select('products', 'id', 'where category_id = ' . $category_id);
if (!is_numeric($category_id) or !$product_id) {
    header("Location: ./");
    exit;
}
$name = $query->select('categories', 'category_name', "where id = '$category_id'")[0]['category_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="./favicon.ico">
    <title>Category - <?php echo htmlspecialchars($name); ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="./src/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="./src/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="./src/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="./src/css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Override green colors with navy blue */
        .primary-btn, .site-btn, .btn-primary {
            background: #001f3f !important;
            border-color: #001f3f !important;
        }
        .primary-btn:hover, .site-btn:hover, .btn-primary:hover {
            background: linear-gradient(135deg, #0043b0, #001f3f) !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .product__item__pic__hover li a {
            background-color: #001f3f !important;
            border-color: #001f3f !important;
            color: #ffffff !important;
        }
        .product__item__pic__hover li a:hover {
            background: linear-gradient(135deg, #0043b0, #001f3f) !important;
            color: #ffffff !important;
        }
        .product__item__pic__hover li a i {
            color: #ffffff !important;
        }
        .product__item__text span {
            color: #001f3f !important;
        }
        .product__item__price {
            color: #001f3f !important;
        }
        .section-title h2:after {
            background: #001f3f !important;
        }
        .filter__sort select {
            border-color: #001f3f !important;
        }
        .filter__sort select:focus {
            border-color: #0043b0 !important;
        }
        .filter__option span {
            color: #001f3f !important;
        }
        .filter__option span:hover {
            color: #0043b0 !important;
        }
        /* Footer hover effects */
        .footer__widget ul li a:hover {
            color: #0043b0 !important;
        }
        .footer__widget__social a,
        .footer__widget__social a i,
        .footer__widget__social a:hover,
        .footer__widget__social a:hover i {
            color: #ffffff !important;
        }
        .footer__widget__social a {
            background: #001f3f !important;
            border-color: #001f3f !important;
        }
        .footer__widget__social a:hover {
            background: linear-gradient(135deg, #0043b0, #001f3f) !important;
            border-color: #001f3f !important;
        }
        /* Override any existing color styles */
        .footer__widget__social a[href*="facebook"],
        .footer__widget__social a[href*="instagram"],
        .footer__widget__social a[href*="twitter"],
        .footer__widget__social a[href*="linkedin"] {
            color: #ffffff !important;
        }
        .footer__widget__social a[href*="facebook"] i,
        .footer__widget__social a[href*="instagram"] i,
        .footer__widget__social a[href*="twitter"] i,
        .footer__widget__social a[href*="linkedin"] i {
            color: #ffffff !important;
        }
        .footer__copyright__text a:hover {
            color: #0043b0 !important;
        }
        .footer__copyright__payment a:hover {
            color: #0043b0 !important;
        }
    </style>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2><?php echo $name ?> </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $products = $query->select('products', '*', "WHERE category_id = '$category_id'");
                foreach ($products as $product):
                    $product_name = $product['name'];
                    $category_name = $query->select('categories', 'category_name', 'WHERE id=' . $product['category_id'])[0]['category_name'];
                    $price_current = $product['price_current'];
                    $price_old = $product['price_old'];
                    $product_id = $product['id'];
                    $image = $query->select('product_images', 'image_url', "where product_id = '$product_id'")[0]['image_url'];
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
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
                <?php endforeach; ?>

            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Footer Section Begin -->
    <?php include './includes/footer.php'; ?>
    <?php include './includes/nav-buttons.php'; ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
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

            xhr.onreadystatechange = function() {
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

            xhr.onreadystatechange = function() {
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

</body>

</html>