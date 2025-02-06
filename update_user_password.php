<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: User Update Password ::</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />   
    <link rel="stylesheet" href="style.css" />
</head>
<?php 
    session_start();
    include './config/database.php';
    if($_SERVER["REQUEST_METHOD"] == 'POST') {
        $user_session       = $_SESSION['user'];
        $user_id            = $user_session['id'];
        $current_password   = $user_session['password'];
        $new_password       = $_POST['new_password'];
        $confirm_password   = $_POST['confirm_password'];

        $errors = [];
        $input_fields = ['new_password', 'confirm_password'];

        foreach ($input_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = ucfirst(str_replace("_", " ", $field)) . " is required.";
            }
        }
        
        if($new_password != $confirm_password) {
            $errors['confirm_password'] = "Confirm password does not match with new password";
        }
        if(password_verify($new_password, $current_password)) {
            $errors['new_password'] = "New password can not be same as current password";
        }
        if (!empty($_POST['new_password']) && strlen($_POST['new_password']) < 6) {
            $errors['new_password'] = "Password must be at least 6 characters long.";
        }

        
        if(empty($errors)) {
            // update last_login and last_password_change date in database
            $last_login           = date('Y-m-d H:i:s');
            $last_password_change = date('Y-m-d H:i:s');
            $password             = password_hash($new_password, PASSWORD_DEFAULT);

            $condition = "id = $user_id AND status = 1 AND role = 'user'";
            $query = "UPDATE users SET last_login = '$last_login' , last_password_change = '$last_password_change', password = '$password' WHERE $condition";
            $result = mysqli_query($conn, $query);
            if($result) {
                $sql = "SELECT * FROM users WHERE id = '" . $user_id . "' AND status = 1 AND role = 'user'";
                $sql = mysqli_query($conn, $sql);
                $user_data = $sql->fetch_assoc();
                if(!empty($user_data)) {
                    $user = array (
                        'id'        => $user_data['id'],
                        'email'     => $user_data['email_id'],
                        'password'  => $user_data['password'],
                        'user'      => "user"
                    );
                    $_SESSION['user'] = $user;
                    // redirect to the dashboard
                    $file_name  = "dashboard.php";
                    $host       = $_SERVER['HTTP_HOST'];
                    $uri        = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                    header("location:http://$host$uri/$file_name"); 
                    exit();
                }
            }
        }
    }
    
?>
<body class="">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="col-10 col-md-6 col-lg-4">
                <div class="flex-column">
                    <h1 class="text-center">Update Password</h1>
                    <form class="w-100" method="POST" name="update-password-form" action="">
                        <div class="mb-4 position-relative password-icon">
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password">
                            <i class="far fa-eye" id="togglePassword"></i>
                            <span class="text-danger"><?php if(isset($errors) && isset($errors['new_password'])) { echo $errors['new_password']; } ?></span>
                        </div>
                        <div class="mb-4 position-relative password-icon">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                            <i class="far fa-eye" id="togglePassword1"></i>
                            <span class="text-danger"><?php if(isset($errors) && isset($errors['confirm_password'])) { echo $errors['confirm_password']; } ?></span>
                        </div>
                        <button type="submit" name="update_btn" id="update_btn" class="btn btn-outline-dark w-100">Update Password</button>
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
            var passwordField = document.getElementById("new_password");
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

        $('#togglePassword1').click(function(){
            var passwordField = document.getElementById("confirm_password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                $('#togglePassword1').removeClass("fa-eye");
                $('#togglePassword1').addClass("fa-eye-slash");
            } else {
                passwordField.type = "password";
                $('#togglePassword1').removeClass("fa-eye-slash");
                $('#togglePassword1').addClass("fa-eye");
            }
        });
    });
</script>