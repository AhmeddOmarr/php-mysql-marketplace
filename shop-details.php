<?php include 'check.php'; ?>

<?php
$product_id = $query->validate($_GET['product_id']);
if (!is_numeric($product_id) or $query->select('products', 'id', 'where id = ' . $product_id)[0]['id'] !== $product_id) {
    header("Location: ./");
    exit;
}

$product = $query->getProduct($product_id);

// Fetch customer name and rating (assuming you have a way to link products to customers who added them)
// For demonstration, I'm using placeholder values.
// You'll need to replace this with actual database queries to fetch the correct data.
$customer_name = "John Doe"; // Placeholder
$customer_rating = 4; // Placeholder (out of 5)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./favicon.ico" />
    <title>Product | <?php echo $product['name']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./src/css/bootstrap.min.css" />
    <link rel="stylesheet" href "./src/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./src/css/elegant-icons.css" />
    <link rel="stylesheet" href="./src/css/nice-select.css" />
    <link rel="stylesheet" href="./src/css/jquery-ui.min.css" />
    <link rel="stylesheet" href="./src/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="./src/css/slicknav.min.css" />
    <link rel="stylesheet" href="./src/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        body {
            font-family: 'Inter', 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }

        .primary-btn {
            background-color: #001f3f;
            color: white !important;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .primary-btn:hover {
            background: linear-gradient(to right, #001f3f, #3399ff);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        .heart-icon {
            font-size: 22px;
            color: #ff4b5c;
            margin-left: 10px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .heart-icon:hover {
            transform: scale(1.2);
        }

        .product__details__pic__item img {
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Changed star color to dark navy blue */
        .rating-stars {
            color: #001f3f;
            font-size: 18px;
        }

        .product__details__text h3 {
            font-weight: 600;
            font-size: 28px;
        }

        .product__item__price span {
            text-decoration: line-through;
            opacity: 0.6;
            font-size: 14px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Removed border, padding, and width to allow full control by the elements inside */
        }

        .quantity-controls button {
            background: none;
            border: 1px solid #ccc; /* Added back border for buttons */
            border-radius: 8px; /* Added back border-radius for buttons */
            font-size: 18px;
            cursor: pointer;
            padding: 5px 10px; /* Added padding for buttons */
        }

        .quantity-label {
            font-weight: 600;
            color: #333;
            user-select: none;
            margin-right: 10px; /* Added margin for spacing */
        }

        .collapsible-description {
            max-height: 100px;
            overflow: hidden;
            position: relative;
            transition: max-height 0.3s ease;
        }

        .collapsible-description.collapsed::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30px;
            background: linear-gradient(to top, #f8f9fa, transparent);
        }

        .read-more {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            cursor: pointer;
            user-select: none;
        }

        /* New style for product details text color */
        .product-details-heading {
            color: #001f3f; /* Navy Blue */
        }
    </style>
</head>

<body>
    <?php include './includes/header.php'; ?>

    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <?php
                            $arr = $query->getProductImageID($product_id);
                            echo '<img class="product__details__pic__item--large" src="./src/images/products/' . $query->getProductImage($arr[0]) . '" alt="">';
                            ?>
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <?php
                            foreach ($arr as $id) {
                                echo '<img data-imgbigurl="./src/images/products/' . $query->getProductImage($id) . '" src="./src/images/products/' . $query->getProductImage($id) . '" alt="">';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $product['name']; ?></h3>
                        <div class="product-price">
                            <div class="product__item__price">
                                EGP <?php echo $product['price_current'] ?> <span>EGP <?php echo $product['price_old'] ?></span>
                            </div>
                        </div>

                        <div class="customer-info mt-2">
                            <span>Added by: <b><?php echo $customer_name; ?></b></span>
                            <span class="ml-3">Customer Rating:
                                <?php
                                for ($i = 0; $i < $customer_rating; $i++) {
                                    echo '<i class="fas fa-star rating-stars"></i>';
                                }
                                for ($i = $customer_rating; $i < 5; $i++) {
                                    echo '<i class="far fa-star rating-stars"></i>'; // Empty star for remaining rating
                                }
                                ?>
                            </span>
                        </div>

                        <p class="collapsible-description collapsed" id="productDescription">
                            <b class="product-details-heading">Product details:</b><br>
                            <span style="white-space: pre-wrap;"><?= $product['description']; ?></span>
                        </p>
                        <span class="read-more" id="toggleDescription">View more</span>

                        <div class="quantity-controls mt-3" style="align-items: center;">
                            <span class="quantity-label">Number of days</span>
                            <div style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 8px;">
                                <button onclick="changeQty(-1)">-</button>
                                <input type="text" value="1" id="quantityInput" style="width: 40px; text-align: center; border: none; padding: 5px 0;" readonly>
                                <button onclick="changeQty(1)">+</button>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <a onclick="addToCart(<?php echo $product_id; ?>, document.getElementById('quantityInput').value)" class="primary-btn">Add to Cart</a>
                            <span onclick="addToWishlist(<?php echo $product_id; ?>)" class="heart-icon"><i class="fas fa-heart"></i></span>
                        </div>

                        <div id="rentalSummary" class="mt-3">
                            <div class="alert alert-info">
                                <h6>Rental Summary</h6>
                                <div>Total Days: <span id="totalDays">1</span></div>
                                <div>Price per Day: EGP <span id="pricePerDay"><?php echo $product['price_current']; ?></span></div>
                                <div>Total Price: EGP <span id="totalPrice"><?php echo $product['price_current']; ?></span></div>
                                <div>Security Deposit: EGP <span id="securityDeposit"><?php echo $product['security_deposit'] ?? 0; ?></span></div>
                            </div>
                        </div>

                        <ul class="mt-3">
                            <li><b>Category:</b> <?php echo $query->select('categories', 'category_name', 'WHERE id=' . $product['category_id'])[0]['category_name'] ?></li>
                            <li><b>Rating:</b>
                                <?php
                                $rating = (int)$product['rating'];
                                for ($i = 0; $i < $rating; $i++) {
                                    echo '<i class="fas fa-star rating-stars"></i>';
                                }
                                for ($i = $rating; $i < 5; $i++) {
                                    echo '<i class="far fa-star rating-stars"></i>'; // Empty star for remaining rating
                                }
                                ?>
                            </li>
                            <li><b>Sales:</b> <?= $query->executeQuery("SELECT SUM(number_of_products) AS total_sales FROM cart WHERE product_id = $product_id")->fetch_all()[0][0] ?? 0 ?></li>
                        </ul>
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

    <script>
        function changeQty(amount) {
            const qtyInput = document.getElementById('quantityInput');
            const currentQty = parseInt(qtyInput.value);
            const newQty = currentQty + amount;
            
            if (newQty >= 1) {
                qtyInput.value = newQty;
                updateRentalSummary();
            }
        }

        function updateRentalSummary() {
            const days = parseInt(document.getElementById('quantityInput').value);
            const pricePerDay = <?php echo $product['price_current']; ?>;
            const securityDeposit = <?php echo $product['security_deposit'] ?? 0; ?>;
            const totalPrice = days * pricePerDay;

            document.getElementById('totalDays').textContent = days;
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
        }

        // Initialize rental summary
        updateRentalSummary();

        document.getElementById('toggleDescription').addEventListener('click', function () {
            const desc = document.getElementById('productDescription');
            if (desc.classList.contains('collapsed')) {
                desc.style.maxHeight = 'none';
                desc.classList.remove('collapsed');
                this.textContent = 'View less';
            } else {
                desc.style.maxHeight = '100px';
                desc.classList.add('collapsed');
                this.textContent = 'View more';
            }
        });

        function addToCart(productId, quantity) {
            var xhr = new XMLHttpRequest();
            var url = 'add_to_cart.php?product_id=' + productId + '&quantity=' + quantity;
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
                        title: 'Added to wishlist!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            };
        }
    </script>
</body>

</html>