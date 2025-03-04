<?php session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<div class="container">
    <h3>Welcome, <?php echo $_SESSION['username']; ?>!</h3>
    <button onclick="window.location.href='index.php';" class="btn btn-success">Go to Attendance System</button>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>