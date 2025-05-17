<?php
session_start(); // Start the session

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'partials/_dbconnect.php';

// Fetch events created by the logged-in user
$created_by = $_SESSION['username'];
$sql = "SELECT * FROM events WHERE created_by = '$created_by'";
$result = mysqli_query($conn, $sql);

// Check if the query returned any events
if ($result && mysqli_num_rows($result) > 0) {
    $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $events = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Events - Take Attendance</title>
    <link rel="stylesheet" href="CreateEventFormStyles.css">
</head>
<body>
    <div class="page-header">
        <h1>Your Created Events</h1>
        <p>Click "Take Attendance" for any event to mark attendance.</p>
    </div>

    <div class="form-box">
        <?php if (!empty($events)): ?>
            <ul class="event-list">
                <?php foreach ($events as $event): ?>
                    <li class="event-item">
                        <h3><?= htmlspecialchars($event['title']) ?></h3>
                        <p>Category: <?= htmlspecialchars($event['category']) ?></p>
                        <p>Venue: <?= htmlspecialchars($event['venue']) ?></p>
                        <a href="take_attendance.php?event_id=<?= $event['id'] ?>" class="btn btn-primary">Take Attendance</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No events found. Create an event first.</p>
        <?php endif; ?>
    </div>
</body>
</html>
