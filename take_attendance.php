<?php
session_start();

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'partials/_dbconnect.php';

// Fetch the event ID from the query parameter
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
} else {
    header("Location: user_created_event.php"); // Redirect if no event_id is provided
    exit();
}

// Fetch registered users for the event
$sql = "SELECT u.username, u.id AS user_id, a.attendance_status FROM users u
        LEFT JOIN attendance a ON u.id = a.user_id AND a.event_id = $event_id";
$result = mysqli_query($conn, $sql);

// Check if the query returned any users
if ($result && mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = [];
}

// Handle form submission to update attendance
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['attendance'] as $user_id => $status) {
        $status = ($status === '1') ? 1 : 0; // Convert checkbox value to boolean (1/0)
        $sql_update = "INSERT INTO attendance (event_id, user_id, attendance_status)
                       VALUES ($event_id, $user_id, $status)
                       ON DUPLICATE KEY UPDATE attendance_status = $status";
        mysqli_query($conn, $sql_update);
    }
    header("Location: attendance.php"); // Redirect back after updating
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - <?= htmlspecialchars($event_id) ?></title>
    <link rel="stylesheet" href="CreateEventFormStyles.css">
</head>
<body>
    <div class="page-header">
        <h1>Take Attendance for Event: <?= htmlspecialchars($event_id) ?></h1>
    </div>

    <form method="POST" action="">
        <div class="form-box">
            <?php if (!empty($users)): ?>
                <ul class="user-list">
                    <?php foreach ($users as $user): ?>
                        <li class="user-item">
                            <p><?= htmlspecialchars($user['username']) ?></p>
                            <label>
                                <input type="checkbox" name="attendance[<?= $user['user_id'] ?>]" value="1" 
                                    <?= $user['attendance_status'] == 1 ? 'checked' : '' ?> class="attendance-checkbox">
                                <span class="checkmark <?= $user['attendance_status'] == 1 ? 'green' : 'red' ?>"></span> Present
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button type="submit" class="btn btn-primary">Submit Attendance</button>
            <?php else: ?>
                <p>No users registered for this event.</p>
            <?php endif; ?>
        </div>
    </form>
</body>
</html>
