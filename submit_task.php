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
if($_SERVER["REQUEST_METHOD"] == 'POST') {
    $user_session       = $_SESSION['user'];
    $user_id            = $user_session['id'];
    
    if(isset($_POST['submit_btn'])) {
        // insert tasks into database
        $start_time_arr     = $_POST['start_time'];
        $stop_time_arr      = $_POST['stop_time'];
        $notes_arr          = $_POST['notes'];
        $description_arr    = $_POST['description'];

        foreach ($start_time_arr as $key => $value) {
            $start_time     = date('Y-m-d H:i:s', strtotime($value));
            $stop_time      = date('Y-m-d H:i:s', strtotime($stop_time_arr[$key]));
            $notes          = $notes_arr[$key];
            $description    = $description_arr[$key];
            $created_at     = date('Y-m-d H:i:s');

            $query = "INSERT INTO user_tasks (user_id, start_time, stop_time, notes, description, created_at) 
                VALUES ('$user_id', '$start_time', '$stop_time', '$notes', '$description', '$created_at')";
            $result = mysqli_query($conn, $query);
        }
        
        echo "Task inserted successfully.";
        // redirect to the dashboard
        $file_name  = "dashboard.php";
        $host       = $_SERVER['HTTP_HOST'];
        $uri        = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
        header("location:http://$host$uri/$file_name"); 
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: User task submit ::</title>
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
            <h1>Submit Task</h1>
            <hr>
            <div class="col-12">
                <form class="w-100" method="POST" name="task-form" action="submit_task.php">
                    <div id="task-container">
                        <div class="task-entry mb-4 border p-3 rounded">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Start Time</label>
                                    <input type="datetime-local" name="start_time[]" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Stop Time</label>
                                    <input type="datetime-local" name="stop_time[]" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Notes</label>
                                <input type="text" name="notes[]" class="form-control" placeholder="Enter notes" required>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description[]" class="form-control" placeholder="Enter description" required></textarea>
                            </div>
                            <button type="button" class="btn btn-danger remove-task">Remove Task</button>
                        </div>
                    </div>
                    <button type="button" id="add-task" class="btn btn-primary">Add Task</button>
                    <button type="submit" name="submit_btn" class="btn btn-success">Submit Tasks</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function(){
        $('#add-task').on('click', function() {
            let newTask = $('.task-entry').first().clone();
            newTask.find('input, textarea').val('');
            $('#task-container').append(newTask);
        });

        $(document).on('click', '.remove-task', function() {
            if ($('.task-entry').length > 1) {
                $(this).closest('.task-entry').remove(); // Remove the closest parent .task-entry div
            }
        });
    });
</script>