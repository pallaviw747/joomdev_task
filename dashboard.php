<?php
session_start();

if (!isset($_SESSION['user'])) {
    $file_name  = "login.php";
    $host       = $_SERVER['HTTP_HOST'];
    $uri        = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
    header("location:http://$host$uri/$file_name"); 
    exit();
}

include './config/database.php';

$user_session   = $_SESSION['user'];
$user_id        = $user_session['id'];

$sql = "SELECT * FROM user_tasks WHERE user_id = '$user_id' AND status = 1";
$sql = mysqli_query($conn, $sql);
$result = []; 
while ($row = mysqli_fetch_assoc($sql)) {
    $result[] = $row; 
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: User Dashboard ::</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />   
    <link rel="stylesheet" href="./style.css" />
</head>
<body>
<div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h3 class="text-white">User</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="submit_task.php"><i class="fas fa-user"></i> Submit Task</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="content-area flex-grow-1">
            <div class="container">
                <h1>Dashboard</h1>
                <table class="table w-100" id="example1">
                    <thead class="table-info">
                        <tr>
                            <th>Sr. no</th>
                            <th>Start Time</th>
                            <th>Stop Time</th>
                            <th>Notes</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($result)) {
                            $i = 1;
                            foreach($result as $value) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value['start_time']; ?></td>
                                <td><?php echo $value['stop_time']; ?></td>
                                <td><?php echo $value['notes']; ?></td>
                                <td><?php echo $value['description']; ?></td>
                            </tr>
                        <?php $i++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>