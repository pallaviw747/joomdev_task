<?php
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

include '../config/database.php';
if (isset($_GET['user_id'])) {
    $user_id = base64_decode($_GET['user_id']);

    $sql = "SELECT start_time, stop_time, notes, description FROM user_tasks WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="user_report.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Start Time', 'Stop Time', 'Notes', 'Description']);

        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }

        fclose($output);
    } else {
        echo "No data found for this user.";
    }
} else {
    echo "User ID not provided.";
}
?>
