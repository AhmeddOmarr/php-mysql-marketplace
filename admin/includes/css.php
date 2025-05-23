<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../src/css/bootstrap.min.css">

<!-- Icon -->
<link rel="icon" type="image/png" href="../src/images/agarlylogo.png">

<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="../src/css/adminlte.min.css">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<!-- Table -->
<link rel="stylesheet" href="../src/css/dataTables.bootstrap4.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="../src/css/sweetalert2-theme-bootstrap-4.css">

<!-- Toastr -->
<link rel="stylesheet" href="../src/css/toastr.min.css">

<!-- Custom styles -->
<style>
    /* Layout fixes */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .wrapper {
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    .main-header {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1030;
        background-color: #fff;
        border-bottom: 1px solid #dee2e6;
        height: 57px;
    }

    .main-sidebar {
        position: fixed;
        top: 57px;
        left: 0;
        min-height: calc(100vh - 57px);
        z-index: 1029;
        width: 250px;
        background-color: #343a40;
        color: #fff;
        transition: margin-left 0.3s ease-in-out;
    }

    .content-wrapper {
        min-height: calc(100vh - 57px);
        padding-top: 57px;
        margin-left: 250px;
        transition: margin-left 0.3s ease-in-out;
        background-color: #f4f6f9;
    }

    .content {
        padding: 1.5rem;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1rem;
    }

    .product-item {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 1rem;
        background: #fff;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-color: #007bff;
    }

    .product-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #212529;
        transition: color 0.3s ease;
    }

    .product-item:hover .product-title {
        color: #007bff;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: 600;
        color: #28a745;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .product-item:hover .product-price {
        color: #218838;
    }

    /* Headers */
    h1, h2, h3, h4, h5, h6 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-weight: 500;
        line-height: 1.2;
        color: #212529;
    }

    h1 { font-size: 2.5rem; }
    h2 { font-size: 2rem; }
    h3 { font-size: 1.75rem; }
    h4 { font-size: 1.5rem; }
    h5 { font-size: 1.25rem; }
    h6 { font-size: 1rem; }

    /* Links */
    a {
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    a:hover {
        color: #0056b3;
        text-decoration: none;
    }

    /* Buttons */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Responsive fixes */
    @media (max-width: 991.98px) {
        .main-sidebar {
            margin-left: -250px;
        }

        .content-wrapper {
            margin-left: 0;
        }

        .sidebar-open .main-sidebar {
            margin-left: 0;
        }

        .sidebar-open .content-wrapper {
            margin-left: 250px;
        }
    }
</style>