<?php
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// submit add employee form
include '../config/database.php';
if($_SERVER["REQUEST_METHOD"] == 'POST') {
    $first_name     = $_POST['first_name'];
    $last_name      = $_POST['last_name'];
    $email          = $_POST['email'];
    $phone          = $_POST['phone'];
    $password       = $_POST['password'];

    $errors = [];
    $input_fields = ['first_name', 'last_name', 'email', 'phone', 'password'];

    foreach ($input_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = ucfirst(str_replace("_", " ", $field)) . " is required.";
        }
    }

    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    
    if(!empty($_POST['phone']) && !preg_match('/^[0-9]+$/', $_POST['phone'])) {
        $errors['phone'] = "Phone number should contain only digits.";
    } else if (!empty($_POST['phone']) && !preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
        $errors['phone'] = "Phone number must be 10 digits.";
    }
    
    if (!empty($_POST['password']) && strlen($_POST['password']) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    }

    if (!empty($_POST['first_name']) && strlen($_POST['first_name']) < 2) {
        $errors['first_name'] = "First name must be at least 2 characters long.";
    }

    if (!empty($_POST['last_name']) && strlen($_POST['last_name']) < 2) {
        $errors['last_name'] = "Last name must be at least 2 characters long.";
    }

    if(empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');

        $sql = "INSERT INTO users (first_name, last_name, email_id, phone, password, created_at) 
                VALUES ('$first_name', '$last_name', '$email', '$phone', '$password', '$created_at')";

        if (mysqli_query($conn, $sql)) {
            echo "New record inserted successfully";
            header('Location:employees.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: Add Employee ::</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />   
    <link rel="stylesheet" href="./assets/style.css" />
</head>
<body>
<div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h3 class="text-white">Admin Panel</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="employees.php"><i class="fas fa-user"></i> Create Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="content-area flex-grow-1">
            <h1 class="mb-3">Add Employee</h1>
            <hr>
            <div class="d-flex justify-content-center align-items-center vh-100">
                <div class="col-10 col-md-6 col-lg-4">
                    <div class="flex-column">
                        <form class="w-100" method="POST" name="login-form" action="">
                            <div class="mb-4">
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?php if(!empty($_POST['first_name'])) { echo $_POST['first_name']; } ?>">
                                <span class="text-danger"><?php if(isset($errors) && isset($errors['first_name'])) { echo $errors['first_name']; } ?></span>
                            </div>
                            <div class="mb-4">
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?php if(!empty($_POST['last_name'])) { echo $_POST['last_name']; } ?>">
                                <span class="text-danger"><?php if(isset($errors) && isset($errors['last_name'])) { echo $errors['last_name']; } ?></span>
                            </div>
                            <div class="mb-4">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
                                <span class="text-danger"><?php if(isset($errors) && isset($errors['email'])) { echo $errors['email']; } ?></span>
                            </div>
                            <div class="mb-4">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?php if(!empty($_POST['phone'])) { echo $_POST['phone']; } ?>">
                                <span class="text-danger"><?php if(isset($errors) && isset($errors['phone'])) { echo $errors['phone']; } ?></span>
                            </div>
                            <div class="mb-4">
                                <div class="position-relative password-icon2 d-flex align-items-center">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                    <i class="far fa-eye" id="togglePassword"></i>
                                    <button class="btn btn-secondary ms-2" style="font-size:12px;" id="autogeneratePassword">Autogenerate Password</button>
                                </div>
                                <span class="text-danger"><?php if(isset($errors) && isset($errors['password'])) { echo $errors['password']; } ?></span>
                            </div>
                            <button type="submit" name="add_emp_btn" id="add_emp_btn" class="btn btn-success">Add Employee</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function() {
        $('#autogeneratePassword').click(function(e) {
            event.preventDefault();
            const strongPassword = generateStrongPassword(6);
            $('#password').val(strongPassword);
        });

        $('#togglePassword').click(function(){
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                $('#togglePassword').removeClass("fa-eye");
                $('#togglePassword').addClass("fa-eye-slash");
            } else {
                passwordField.type = "password";
                $('#togglePassword').removeClass("fa-eye-slash");
                $('#togglePassword').addClass("fa-eye");
            }
        });
    });

    function generateStrongPassword(length) {
        const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        const shuffled = shuffleString(chars);
        return shuffled.substring(0, length);
    }

    function shuffleString(str) {
        const arr = str.split('');
        arr.sort(() => Math.random() - 0.5);
        return arr.join('');
    }
</script>