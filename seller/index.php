<?php
include 'check.php';

$seller_id = $_SESSION['id'];
$products = $query->select('products', "*", "WHERE seller_id = '$seller_id' ORDER BY added_to_site DESC");
$products_count = count($products);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" href="../favicon.ico">
    
    <?php include 'includes/css.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3498db;
            --danger: #e74c3c;
            --light: #f8f9fa;
            --dark: #343a40;
            --navy: #001f3f;
        }

        body {
            background-color: #f5f7fa;
        }

        .products-header {
            background: var(--navy);
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .products-count {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin: 20px 0;
        }

        .empty-state img {
            max-width: 200px;
            margin-bottom: 25px;
            opacity: 0.8;
        }

        .empty-state h3 {
            color: var(--dark);
            margin-bottom: 15px;
        }

        .add-product-btn {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 500;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-image: linear-gradient(to bottom right, #003366, #001f3f);
            border: none;
        }

        .add-product-btn:hover {
            background-image: linear-gradient(to bottom right, #004080, #002a4d);
        }

        .product-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .product-image-container {
            height: 220px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f3f5;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .no-image {
            color: #adb5bd;
            font-size: 1rem;
        }

        .product-body {
            padding: 20px;
        }

        .product-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: var(--dark);
            font-weight: 600;
        }

        .product-meta {
            color: #6c757d;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .product-price {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--primary);
            margin: 15px 0;
        }

        .old-price {
            text-decoration: line-through;
            color: #adb5bd;
            font-size: 1rem;
            margin-left: 8px;
        }

        .product-description {
            color: #495057;
            margin: 15px 0;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .product-footer {
            padding: 15px 20px;
            background: var(--light);
            border-top: 1px solid #e9ecef;
            display: flex; /* Added for button alignment */
            justify-content: center; /* Centers the button horizontally */
        }

        .content-wrapper {
            background-color: #f5f7fa;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/aside.php';
        active('product', 'products'); ?>

        <div class="content-wrapper">
            <?php
            $arr = array(
                ["title" => "Home", "url" => "/"],
                ["title" => "Product", "url" => "/"],
                ["title" => "My Products", "url" => "#"],
            );
            pagePath('My Products', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <?php if (!empty($products)) : ?>
                        <div class="products-header" style="background-color: #001f3f;">
                            <div class="products-count" style="color: white;">
                                My Products (<?php echo $products_count; ?>)
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <?php if (empty($products)) : ?>
                            <div class="col-12">
                                <div class="empty-state">
                                    
                                    <h3>Your Product Collection is Empty</h3>
                                    <p class="text-muted">Start by adding your first product to the marketplace</p>
                                    <a href="addproduct.php" class="btn btn-primary add-product-btn">
                                        <i class="fas fa-plus mr-2"></i> Add Product
                                    </a>
                                </div>
                            </div>
                        <?php else :
                            foreach ($products as $product) :
                                $productImages = $query->select('product_images', 'image_url', 'WHERE product_id=' . $product['id']);
                                $category_name = $query->select('categories', 'category_name', 'WHERE id=' . $product['category_id'])[0]['category_name'];
                        ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card product-card">
                                        <div class="product-image-container">
                                            <?php if (!empty($productImages[0]['image_url'])) : ?>
                                                <img src="../src/images/products/<?php echo $productImages[0]['image_url']; ?>" class="product-image" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                            <?php else : ?>
                                                <div class="no-image">No Image Available</div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="product-body">
                                            <h4 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h4>

                                            <div class="product-meta">
                                                <span><i class="fas fa-tag mr-1"></i> <?php echo htmlspecialchars($category_name); ?></span>
                                                <span class="float-right"><i class="far fa-calendar-alt mr-1"></i> <?php echo date('M d, Y', strtotime($product['added_to_site'])); ?></span>
                                            </div>

                                            <div class="product-price">
                                                EGP <?php echo number_format($product['price_current'], 2); ?>
                                                <?php if ($product['price_old'] > 0) : ?>
                                                    <span class="old-price">EGP <?php echo number_format($product['price_old'], 2); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <p class="product-description">
                                                <?php echo htmlspecialchars($product['description'] ?? 'No description provided'); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </section>
        </div>

        
    </div>

    <script src="../src/js/jquery.min.js"></script>
    <script src="../src/js/adminlte.js"></script>
    <script src="../src/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    </script>
</body>

</html>
