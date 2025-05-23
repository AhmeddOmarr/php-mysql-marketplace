<?php
session_start();
include '../config.php';
$query = new Database();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: ../admin/");
            exit;
        case 'seller':
            header("Location: ../seller/");
            exit;
        default:
            header("Location: ../");
            exit;
    }
}

if (isset($_COOKIE['username'], $_COOKIE['session_token'])) {
    if (session_id() !== $_COOKIE['session_token']) {
        session_write_close();
        session_id($_COOKIE['session_token']);
        session_start();
    }

    $username = $_COOKIE['username'];
    $result = $query->select('accounts', 'id, role', "WHERE username = :username", [':username' => $username]);

    if (!empty($result)) {
        $user = $result[0];
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        switch ($user['role']) {
            case 'admin':
                header("Location: ../admin/");
                exit;
            case 'seller':
                header("Location: ../seller/");
                exit;
            default:
                header("Location: ../");
                exit;
        }
    }
}

$error = '';

if (isset($_POST['submit'])) {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username && $password) {
        $user = $query->authenticate($username, $password, 'accounts');

        if ($user) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user[0]['id'] ?? null;
            $_SESSION['name'] = $user[0]['name'] ?? null;
            $_SESSION['number'] = $user[0]['number'] ?? null;
            $_SESSION['email'] = $user[0]['email'] ?? null;
            $_SESSION['username'] = $user[0]['username'] ?? null;
            $_SESSION['role'] = $user[0]['role'] ?? 'user';

            setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
            setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);

            switch ($user[0]['role']) {
                case 'admin':
                    header("Location: ../admin/");
                    exit;
                case 'seller':
                    header("Location: ../seller/");
                    exit;
                default:
                    header("Location: ../");
                    exit;
            }
        } else {
            $error = "The login or password is incorrect.";
        }
    } else {
        $error = "Please fill in all the fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="icon" href="../favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes float {
            0% {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) scale(1.5);
                opacity: 0;
            }
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            background-color: #1e2a47;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .background-circles {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            bottom: -150px;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 20s linear infinite;
        }

        .circle:nth-child(1) {
            left: 10%;
            width: 80px;
            height: 80px;
            animation-duration: 18s;
        }

        .circle:nth-child(2) {
            left: 25%;
            width: 50px;
            height: 50px;
            animation-duration: 22s;
        }

        .circle:nth-child(3) {
            left: 40%;
            width: 100px;
            height: 100px;
            animation-duration: 20s;
        }

        .circle:nth-child(4) {
            left: 60%;
            width: 60px;
            height: 60px;
            animation-duration: 24s;
        }

        .circle:nth-child(5) {
            left: 80%;
            width: 90px;
            height: 90px;
            animation-duration: 19s;
        }

        .main-wrapper {
            display: flex;
            width: 90%;
            max-width: 1000px;
            height: 600px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
            border-radius: 12px;
            overflow: hidden;
            background-color: #ffffff;
            position: relative;
            z-index: 1;
        }

        .left-image {
            flex: 1;
            background-color: #1e2a47;
        }

        .left-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .separator {
            width: 2px;
            background-color: #1e2a47;
            margin: 0 30px;
        }

        .login-container {
            flex: 1;
            padding: 60px 50px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #1e2a47;
        }

        .login-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .login-header p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: none;
            border-bottom: 2px solid #ccc;
            font-size: 16px;
            color: #1e2a47;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: transparent;
        }

        .form-group label {
            position: absolute;
            top: -20px;
            left: 0;
            font-size: 14px;
            color: #888;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group input:not(:placeholder-shown) {
            border-color: #007bff;
            outline: none;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            color: #007bff;
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #888;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .password-toggle:hover {
            color: #007bff;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: #001f3f;
            color: #ffffff;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0px 5px 12px rgba(0, 31, 63, 0.3);
        }

        .login-btn:hover {
            background: linear-gradient(90deg, #0062cc, #0052a3);
            box-shadow: 0px 8px 18px rgba(0, 31, 63, 0.5);
            transform: translateY(-2px);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }

        .signup-link a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="background-circles">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="main-wrapper">
        <div class="left-image">
            <img src="../src/images/login.png" alt="Login Image" />
        </div>

        <div class="separator"></div>

        <div class="login-container">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to access your account</p>
            </div>

            <form method="post" action="">
                <div class="form-group">
                    <input type="text" id="username" name="username" required maxlength="255" placeholder="Enter your username or email">
                    <label for="username">Username or Email Address</label>
                </div>

                <div class="form-group">
                    <div class="password-container">
                        <input type="password" id="password" name="password" required maxlength="255" placeholder="Enter your password">
                        <label for="password">Password</label>
                        <button type="button" id="toggle-password" class="password-toggle"><i class="fas fa-eye"></i></button>
                    </div>
                </div>

                <button type="submit" name="submit" class="login-btn">LOGIN</button>
            </form>

            <div class="signup-link">
                <p>Don't have an account? <a href="../signup/">Sign Up</a></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($error): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo $error; ?>',
                    position: 'top-end',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000,
                    background: 'rgba(11, 37, 69, 0.9)',
                    color: '#EEF4ED',
                    backdrop: 'blur(5px)'
                });
            <?php endif; ?>

            document.getElementById('toggle-password').addEventListener('click', function() {
                const passwordField = document.getElementById('password');
                const toggleIcon = this.querySelector('i');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
    </script>
</body>

</html>
