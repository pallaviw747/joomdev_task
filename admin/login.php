<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: Admin Login ::</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />   
    <link rel="stylesheet" href="./assets/style.css" />
</head>
<?php 
    session_start();
    include '../config/database.php';
    if($_SERVER["REQUEST_METHOD"] == 'POST') {
        $email = $_POST['email'];
        $input_password = $_POST['password'];
        $email_error = $password_error = '';
        if($email === '') {
            $email_error = "Email is required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Enter valid email";
        }
        
        if($input_password === '') {
            $password_error = "Password is required";
        }
        
        if($email_error === '' && $password_error === '') {
            $email = mysqli_real_escape_string($conn, $email);
            $sql = "SELECT * FROM users WHERE email_id = '" . $email . "' AND status = 1 and role='admin'";
            $sql = mysqli_query($conn, $sql);
            $result = $sql->fetch_assoc();
            if(!empty($result)) {
                $password = $result['password'];
                if (strlen($password) == 32) {
                    if (md5($input_password) === $password) {
                        $admin_user = array (
                            'id' => $result['id'],
                            'email' => $result['email_id'],
                            'user' => "admin"
                        );
                        $_SESSION['admin_login'] = $admin_user;
                        $file_name  = "dashboard.php";
                        $host       = $_SERVER['HTTP_HOST'];
                        $uri        = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                        header("location:http://$host$uri/$file_name");
                        exit();
                    } else {
                        $password_error = "Invalid Password";
                    }
                } else {
                    if(password_verify($input_password, $password)) {
                        $admin_user = array (
                            'id' => $result['id'],
                            'email' => $result['email_id'],
                            'user' => "admin"
                        );
                        $_SESSION['admin_login'] = $admin_user;
                        $file_name  = "dashboard.php";
                        $host       = $_SERVER['HTTP_HOST'];
                        $uri        = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                        header("location:http://$host$uri/$file_name");
                        exit();
                    } else {
                        $password_error = "Invalid Password";
                    }
                }
            } else {
                echo "Invalid email or user not found!";
                $file_name  = "login.php";
                $host       = $_SERVER['HTTP_HOST'];
                $uri        = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                header("location:http://$host$uri/$file_name");
            }
        } else {
            echo "Invalid Credentials";
            $file_name  = "login.php";
            $host       = $_SERVER['HTTP_HOST'];
            $uri        = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
            header("location:http://$host$uri/$file_name");
        }
    }
    
?>
<body class="">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="col-10 col-md-6 col-lg-4">
                <div class="flex-column">
                    <h1 class="text-center">Admin Login</h1>
                    <form class="w-100" method="POST" name="login-form" action="">
                        <div class="mb-4">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
                            <span class="text-danger"><?php if(isset($email_error)) { echo $email_error; } ?></span>
                        </div>
                        <div class="mb-4 position-relative password-icon">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            <i class="far fa-eye" id="togglePassword"></i>
                            <span class="text-danger"><?php if(isset($password_error)) { echo $password_error; } ?></span>
                        </div>
                        <button type="submit" name="login_btn" id="login_btn" class="btn btn-outline-dark w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function() {
        // code to toggle password field
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
</script>