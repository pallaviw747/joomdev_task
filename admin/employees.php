<?php
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

include '../config/database.php';
$sql = "SELECT *, COALESCE((SELECT count(*) FROM user_tasks WHERE user_tasks.user_id = users.id), 0) AS submitted_task FROM users WHERE role = 'user' AND status = 1 GROUP BY id;";

$sql = mysqli_query($conn, $sql);
$emp_result = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $emp_result[] = $row;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: Admin Dashboard ::</title>
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
            <h1 class="mb-3">Employees List</h1>
            <hr>
            <a href="add_employees.php"><button type="button" id="addEmployee" class="btn btn-primary mb-3">Add Employee</button></a>

            <table class="table w-100" id="example1">
                <thead class="table-info">
                    <tr>
                        <th>Sr. no</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($emp_result)) {
                        $i = 1;
                        foreach($emp_result as $value) {
                        $download_report_link = "download_report.php?user_id=". base64_encode($value['id']); ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value['first_name']; ?></td>
                            <td><?php echo $value['last_name']; ?></td>
                            <td><?php echo $value['email_id']; ?></td>
                            <td><?php echo $value['phone']; ?></td>
                            <td><?php echo ($value['submitted_task'] > 0) ? '<a href="' . $download_report_link . '">Download Report</a>' : ''; ?></td>
                        </tr>
                    <?php $i++; } } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>