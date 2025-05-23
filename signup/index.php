<?php
session_start();

include '../config.php';
$query = new Database();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/");
        exit;
    } else if ($_SESSION['role'] == 'seller') {
        header("Location: ../seller/");
    } else {
        header("Location: ../");
        exit;
    }
}

if (isset($_COOKIE['username']) && isset($_COOKIE['session_token'])) {
    if (session_id() !== $_COOKIE['session_token']) {
        session_write_close();
        session_id($_COOKIE['session_token']);
        session_start();
    }

    $username = $_COOKIE['username'];

    $result = $query->select('accounts', 'id, role', "WHERE username = '$username'");

    if (!empty($result)) {
        $user = $result[0];

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: ../admin/");
            exit;
        } else if ($user['role'] == 'seller') {
            header("Location: ../seller/");
        } else {
            header("Location: ../");
            exit;
        }
    }
}

$msg = [];

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $existingUser = $query->executeQuery("SELECT * FROM accounts WHERE username='$username' OR email='$email' OR number='$number'");

    if ($existingUser->num_rows > 0) {
        $msg = [
            "title" => "Error!",
            "text" => "Username, email, or phone number already exists."
        ];
    } else {
        $result = $query->registerUser($name, $number, $email, $username, $password, $role);
        $userData = $query->executeQuery("SELECT * FROM accounts WHERE username='$username'")->fetch_assoc();

        if (!empty($result) && !empty($userData) && isset($userData['id'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $userData['id'];
            $_SESSION['name'] = $name;
            $_SESSION['number'] = $number;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
            setcookie('session_token',  session_id(), time() + (86400 * 30), "/", "", true, true);

            $msg = [
                "title" => "Success!",
                "text" => "Registration completed!",
                "icon" => "success"
            ];

            if ($user[0]['role'] == 'admin') {
                header("Location: ../admin/");
                exit;
            } else if ($user[0]['role'] == 'seller') {
                header("Location: ../seller/");
            } else {
                header("Location: ../");
                exit;
            }
        } else {
            $msg = [
                "title" => "Error!",
                "text" => "An error occurred while saving the data."
            ];
        }
    }
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --deep-blue: #0B2545;
            --dark-blue: #134074;
            --medium-blue: #13315C;
            --light-blue: #8DA9C4;
            --off-white: #EEF4ED;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--deep-blue) 0%, var(--dark-blue) 100%);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            position: relative;
            overflow-y: auto;
            padding: 20px 0;
        }

        body::before {
            content: '';
            position: fixed;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(141, 169, 196, 0.2);
            filter: blur(100px);
            top: -100px;
            left: -100px;
            z-index: 1;
        }

        body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(19, 49, 92, 0.3);
            filter: blur(100px);
            bottom: -150px;
            right: -100px;
            z-index: 1;
        }

        .glass-card {
            position: relative;
            width: 100%;
            max-width: 600px;
            /* Increased max-width for wider card */
            background: #fff;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 2px solid var(--deep-blue);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
            /* Increased shadow intensity */
            padding: 40px;
            margin: 20px;
            z-index: 2;
            overflow: visible;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: none;
            pointer-events: none;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo-placeholder {
            width: 120px;
            /* Increased size of logo placeholder */
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            /*border: 2px solid var(--medium-blue);*/
            /* Optional border */
        }

        .logo-placeholder img {
            max-width: 100%;
            max-height: 100%;
            /* Object fit cover to maintain aspect ratio and fill container */
            object-fit: cover;
        }

        .signup-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .signup-header h1 {
            color: var(--deep-blue);
            font-size: 2.2rem;
            /* Increased font size */
            font-weight: 600;
            margin-bottom: 12px;
            /* Increased margin */
            letter-spacing: 1px;
        }

        .signup-header p {
            color: var(--medium-blue);
            font-size: 0.95rem;
            /* Slightly increased font size */
        }

        .form-group {
            margin-bottom: 25px;
            /* Increased margin */
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            /* Increased margin */
            color: var(--deep-blue);
            font-weight: 500;
            /* Medium font weight */
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            font-size: 16px;
            color: var(--deep-blue);
            transition: all 0.3s ease;
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1);
            /* Slightly stronger shadow */
        }

        .form-group input::placeholder,
        .form-group select option:first-child {
            color: rgba(11, 37, 69, 0.5);
        }

        .form-group input:focus,
        .form-group select:focus {
            background: rgba(255, 255, 255, 0.85);
            /* Slightly lighter background on focus */
            border-color: var(--light-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(141, 169, 196, 0.3);
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--medium-blue);
            cursor: pointer;
            font-size: 18px;
            /* Increased icon size */
            transition: all 0.3s;
        }

        .password-toggle:hover {
            color: var(--deep-blue);
        }

        .signup-btn {
            width: 100%;
            padding: 18px;
            /* Increased padding */
            background: linear-gradient(to right, #0B2545, #134074); /* Default navy blue */
            color: var(--off-white);
            border: none;
            border-radius: 10px;
            font-size: 18px;
            /* Increased font size */
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s;
            margin-top: 15px;
            /* Increased margin */
            letter-spacing: 1px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            /* Increased shadow */
        }

        .signup-btn:hover {
            background: linear-gradient(to right, #0B2545, #8DA9C4);  /* Gradient on hover */
            transform: translateY(-3px);
            box-shadow: 0 9px 25px rgba(0, 0, 0, 0.25);
            /* Increased shadow */
        }

        .signup-btn:active {
            transform: translateY(0);
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1);
            /* Smaller shadow on active */
        }

        .login-link {
            text-align: center;
            margin-top: 30px;
            /* Increased margin */
            color: var(--medium-blue);
            font-size: 14px;
        }

        .login-link a {
            color: #0000FF;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
        }

        .login-link a::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            /* Increased thickness */
            background: #0000FF;
            bottom: -4px;
            /* Increased distance from text */
            left: 0;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .login-link a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .error-message {
            color: #ff9e9e;
            font-size: 13px;
            margin-top: 8px;
            display: block;
            text-align: right;
        }

        .floating-circle {
            position: fixed;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            z-index: 0;
        }

        .circle-1 {
            width: 180px;
            /* Increased size */
            height: 180px;
            top: 10%;
            left: 10%;
            animation: float 8s ease-in-out infinite;
        }

        .circle-2 {
            width: 240px;
            /* Increased size */
            height: 240px;
            bottom: 15%;
            right: 10%;
            animation: float 10s ease-in-out infinite reverse;
        }

        .circle-3 {
            width: 120px;
            /* Increased size */
            height: 120px;
            top: 60%;
            left: 30%;
            animation: float 7s ease-in-out infinite 2s;
        }

        @keyframes float {
            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-25px) translateX(12px);
                /* Increased translation */
            }
        }

        @media (max-width: 768px) {
            .glass-card {
                padding: 30px;
                margin: 15px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .signup-header h1 {
                font-size: 2rem;
            }

            .form-group input,
            .form-group select {
                padding: 12px 15px;
            }

            .logo-placeholder {
                width: 100px;
                height: 100px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px 0;
                align-items: flex-start;
            }

            .glass-card {
                padding: 20px;
                margin: 10px;
                border-radius: 15px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .signup-header h1 {
                font-size: 1.7rem;
            }

            .form-group input,
            .form-group select {
                padding: 10px 12px;
                font-size: 14px;
            }

            .signup-btn {
                padding: 14px;
                font-size: 16px;
            }

            .login-link {
                margin-top: 20px;
                font-size: 12px;
            }

            .logo-placeholder {
                width: 80px;
                height: 80px;
            }
        }

        /* Added to align inputs horizontally */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            /* Space between items */
            margin-bottom: 25px;
            /* Consistent margin with other form groups */
        }

        .form-row .form-group {
            width: 48%;
            /* Adjust as needed, slightly less than 50% for spacing */
            margin-bottom: 0;
            /* Remove bottom margin, handled by .form-row */
        }

        /* Ensure labels are full width within their column */
        .form-row .form-group label {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            color: var(--deep-blue);
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        /* Adjust input widths to fill their container */
        .form-row .form-group input,
        .form-row .form-group select {
            width: 100%;
        }

        /* Responsive adjustments for very small screens */
        @media (max-width: 480px) {
            .form-row {
                flex-direction: column;
                /* Stack items vertically on small screens */
            }

            .form-row .form-group {
                width: 100%;
                /* Take full width on small screens */
                margin-bottom: 15px;
                /* Add bottom margin to stacked items */
            }
        }
    </style>
</head>

<body>
    <div class="floating-circle circle-1"></div>
    <div class="floating-circle circle-2"></div>
    <div class="floating-circle circle-3"></div>

    <div class="glass-card">
        <div class="logo-container">
            <div class="logo-placeholder">
                <img src="../src/images/agarlylogo.png" alt="Company Logo">
            </div>
        </div>


        <div class="signup-header">
            <h1>Create Account</h1>
            <p>Join us to get started</p>
        </div>

        <form method="post" action="" enctype="multipart/form-data" id="signup-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" placeholder="Full Name" required maxlength="30">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="number">Phone Number</label>
                    <input type="tel" name="number" placeholder="+998991234567" required maxlength="20">
                    <span class="error-message" id="number-error"></span>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="user">User</option>
                        <option value="seller">Seller</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" required maxlength="255">
                <span class="error-message" id="email-error"></span>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" required maxlength="255">
                <span class="error-message" id="username-error"></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Password" required maxlength="255">
                    <button type="button" id="toggle-password" class="password-toggle"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <button type="submit" name="submit" id="submit" class="signup-btn">SIGN UP</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="../login/">Log in</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($msg)) : ?>
                Swal.fire({
                    icon: '<?php echo $msg['icon'] ?? 'error'; ?>',
                    title: '<?php echo $msg['title']; ?>',
                    text: '<?php echo $msg['text']; ?>',
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

            $(document).ready(function() {
                $('input[name="number"]').on('input', function() {
                    var number = $(this).val();
                    if (number.length > 0 && !/^\+?\d+$/.test(number)) {
                        $('#number-error').text('Please enter a valid phone number');
                    } else {
                        $('#number-error').text('');
                    }
                });

                $('input[name="email"]').on('input', function() {
                    var email = $(this).val();
                    if (email.length > 0 && !/\S+@\S+\.\S+/.test(email)) {
                        $('#email-error').text('Invalid email format');
                    } else {
                        $('#email-error').text('');
                    }
                });

                var button_active = true;

                function isOne(value, callback) {
                    $.ajax({
                        url: 'check_username.php',
                        type: 'POST',
                        data: {
                            username: value
                        },
                        success: function(response) {
                            if (response === 'exists') {
                                callback(true);
                            } else {
                                callback(false);
                            }
                        }
                    });
                }

                function toggleSubmitButton() {
                    if (button_active) {
                        $('#submit').prop('disabled', false);
                    } else {
                        $('#submit').prop('disabled', true);
                    }
                }

                $('input[name="username"]').on('input', function() {
                    var username = $(this).val();
                    if (username.length > 0 && !/^[a-zA-Z0-9_]+$/.test(username)) {
                        $('#username-error').text('Only letters, numbers, and underscores allowed');
                        button_active = false;
                    } else {
                        $('#username-error').text('');
                        button_active = true;

                        if (username.length > 0) {
                            isOne(username, function(result) {
                                if (result) {
                                    $('#username-error').text('Username already taken');
                                    button_active = false;
                                } else {
                                    $('#username-error').text('');
                                    toggleSubmitButton();
                                }
                            });
                        } else {
                            toggleSubmitButton();
                        }
                    }

                    toggleSubmitButton();
                });
            });

            $(document).ready(function() {
                function isEmailExists(email, callback) {
                    $.ajax({
                        url: 'check_email.php',
                        type: 'POST',
                        data: {
                            email: email
                        },
                        success: function(response) {
                            if (response === 'exists') {
                                callback(true);
                            } else {
                                callback(false);
                            }
                        }
                    });
                }

                $('input[name="email"]').on('input', function() {
                    var email = $(this).val();
                    if (email.length > 0 && !isValidEmail(email)) {
                        $('#email-error').text('Invalid email format');
                    } else {
                        $('#email-error').text('');
                    }
                    if (email.length > 0) {
                        isEmailExists(email, function(result) {
                            if (result) {
                                $('#email-error').text('Email already registered');
                            } else {
                                $('#email-error').text('');
                            }
                        });
                    }
                });

                function isValidEmail(email) {
                    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                }
            });

            $(document).ready(function() {
                function isNumberExists(number, callback) {
                    $.ajax({
                        url: 'check_number.php',
                        type: 'POST',
                        data: {
                            number: number
                        },
                        success: function(response) {
                            if (response === 'exists') {
                                callback(true);
                            } else {
                                callback(false);
                            }
                        }
                    });
                }

                $('input[name="number"]').on('input', function() {
                    var number = $(this).val();
                    if (number.length > 0 && !/^\+?\d+$/.test(number)) {
                        $('#number-error').text('Invalid phone number');
                    } else {
                        $('#number-error').text('');
                    }
                    if (number.length > 0) {
                        isNumberExists(number, function(result) {
                            if (result) {
                                $('#number-error').text('Number already registered');
                            } else {
                                $('#number-error').text('');
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
