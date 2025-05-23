<?php
// Navigation buttons component
?>
<style>
    /* Navigation Buttons */
    .nav-buttons {
        position: fixed;
        bottom: 15px;
        right: 15px;
        display: flex;
        gap: 10px;
        z-index: 1000;
    }

    .nav-button {
        background-color: #001f3f;
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .nav-button:hover {
        background-color: #0043b0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .nav-button i {
        font-size: 20px;
    }

    /* Adjust main content padding to prevent overlap with nav buttons */
    .product.spad,
    .shop-details,
    .shoping-cart,
    .checkout,
    .category,
    .hero,
    .featured,
    .latest-product,
    .banner,
    .blog {
        padding-bottom: 70px;
    }

    /* Ensure buttons are visible on all backgrounds */
    .nav-button {
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
</style>

<div class="nav-buttons">
    <a href="javascript:history.back()" class="nav-button" title="Go Back">
        <i class="fa fa-arrow-left"></i>
    </a>
    <a href="/php-mysql-marketplace/index.php" class="nav-button" title="Go Home">
        <i class="fa fa-home"></i>
    </a>
</div> 