<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Reem+Kufi:wght@400..700&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$cartItems = $query->getCartItems($_SESSION['id']);
$total_price = array_reduce($cartItems, function ($total, $item) {
    return $total + $item['total_price'];
}, 0);

function countTable($table)
{
    global $query;
    $userId = $_SESSION['id'];
    $result = $query->executeQuery("SELECT COUNT(*) AS total_elements FROM $table WHERE user_id = $userId");
    $row = $result->fetch_assoc();
    return $row['total_elements'];
}
?>

<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    ...
</div>

<header class="header">
    <div class="header__top"></div>
    <div class="container hd rounded-pill my-3 nav-custom">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="header__logo px-4">
                    <h2>اجرلي</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu d-none d-lg-flex justify-content-center align-items-center">
                    <ul class="d-flex gap-4">
                        <li><a href="./" class="<?= ($currentPage == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                        <li><a href="about.php" class="<?= ($currentPage == 'about.php') ? 'active' : ''; ?>">About us</a></li>
                        <li><a href="contact.php" class="<?= ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart d-flex justify-content-end align-items-center gap-4">
                    <ul class="d-flex align-items-center m-0 p-0 gap-4 icon-list" style="list-style: none;">
                        <li><a href="./heart.php"><img src="./src/images/icons8-heart-50.png" class="icon-img"><span class="xd"><?= countTable('wishes'); ?></span></a></li>
                        <li><a href="./shoping-cart.php"><img src="./src/images/icons8-cart-30.png" class="icon-img"><span class="xd"><?= countTable('cart'); ?></span></a></li>
                        <?php if ($_SESSION['loggedin']): ?>
                            <li><a href="./profile.php"><img src="./src/images/profile.png" class="icon-img"></a></li>
                            <li><a href="#" onclick="logout()" class="logout-btn"><img src="./src/images/icons8-logout-50.png" class="icon-img" alt="Logout"></a></li>
                        <?php else: ?>
                            <li><a href="./login/"><i class="fa fa-user"></i>Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="humberger__open d-lg-none">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>

<section class="hero hero-normal" style="margin-bottom: -50px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all hd category-bg">
                        <i class="fa fa-bars x"></i>
                        <span class="x">Category</span>
                    </div>
                    <ul>
                        <?php
                        $categories = $query->select('categories', '*');
                        foreach ($categories as $category): ?>
                            <li><a href="category.php?category=<?= $category['id']; ?>"><?= $category['category_name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__phone d-flex align-items-center gap-2">
                        <div class="hero__search__phone__icon phone-icon-bg d-flex justify-content-center align-items-center">
                            <i class="fa fa-phone text-white"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>0225218456</h5>
                            <span>SUPPORT 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .x {
        color: #ffffff !important;
    }

    .nav-custom {
        background-color: #001f3f !important;
        z-index: 999;
        position: sticky;
        top: 0;
    }

    /* Rest of your existing styles */
    .category-bg {
        background-color: #001f3f !important;
        padding: 10px;
        border-radius: 12px;
    }

    .header__menu ul li a,
    .header__cart a,
    .header__top__right__auth a,
    .header__menu i {
        color: #ffffff !important;
        transition: 0.3s ease;
        position: relative;
    }

    .header__menu ul li a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        height: 2px;
        width: 0;
        background-color: #66b2ff;
        transition: width 0.3s ease;
    }

    .header__menu ul li a:hover::after,
    .header__menu ul li a.active::after {
        width: 100%;
    }

    .header__menu ul li a:hover,
    .header__cart a:hover,
    .header__top__right__auth a:hover,
    .header__menu i:hover {
        color: #66b2ff !important;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .header__menu ul li a.active {
        color: #66b2ff !important;
        font-weight: bold !important;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .xd {
        color: white !important;
        background-color: #ff4d6d !important;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        font-size: 11px;
        font-weight: bold;
        position: relative;
        top: -10px;
        left: -8px;
    }

    .header__logo h2 {
        font-family: "Space Mono", monospace;
        font-weight: 900;
        font-style: normal;
        color: #ffffff;
    }

    .hd {
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        border: 1px solid rgba(99, 117, 233, 0.19);
    }

    .logout-btn img {
        transition: 0.3s ease;
        padding: 4px;
        border-radius: 8px;
    }

    .logout-btn img:hover {
        background-color: rgba(255, 255, 255, 0.15);
        transform: scale(1.1);
        cursor: pointer;
    }

    .icon-img {
        width: 28px;
        height: 28px;
        object-fit: contain;
    }

    .icon-list li {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .phone-icon-bg {
        background-color: #001f3f;
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function logout() {
        Swal.fire({
            title: 'Are you sure you want to log out?',
            text: "You cannot undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './logout/';
            }
        });
    }

    // Profile sidebar functions
    function openProfile() {
        document.getElementById('profileSidebar').classList.add('active');
        document.getElementById('profileOverlay').style.display = 'block';
    }
    
    function closeProfile() {
        document.getElementById('profileSidebar').classList.remove('active');
        document.getElementById('profileOverlay').style.display = 'none';
    }
    
    // Close sidebar when clicking overlay
    document.getElementById('profileOverlay').addEventListener('click', closeProfile);
</script>