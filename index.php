<!DOCTYPE html>
<html>
<head>
    <title>Booking Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <form action="submit_booking.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <input type="submit" value="Book">
    </form>

    <?php
    // Check if there's a status message to display
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 'guest_created') {
            echo '<p style="color: green;">Guest Created</p>';
        }
        // Add more conditions for other status messages if needed
    }
    ?>
</body>
</html>
