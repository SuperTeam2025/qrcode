<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Attendance System</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="instascan.min.js"></script>
    <script src="vue.min.js"></script>
    <script src="adapter.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">QR Code Attendance System</h3>

    <div class="text-right mb-3">
        <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <video id="preview" style="width: 100%; height: 300px; border: 1px solid black;"></video>
        </div>

        <div class="col-md-6">
            <form action="insert1.php" method="POST">
                <label>QR Code Data:</label>
                <input type="text" name="text" id="text" class="form-control" readonly>
                <br>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>

    <br>
    <h4>Attendance Logs</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Time In</th>
            <th>Time Out</th>
        </tr>
        </thead>
        <tbody>
        <?php
        include 'db.php';
        $result = $conn->query("SELECT * FROM table_attendance");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['time_in']}</td>
                    <td>{$row['time_out']}</td>
                </tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="export.php" class="btn btn-warning">Export to Excel</a>
</div>

<script>
    let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
    scanner.addListener('scan', function(content) {
        document.getElementById("text").value = content;
        document.forms[0].submit();
    });

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert("No Cameras Found");
        }
    }).catch(function(e) {
        console.error(e);
    });
</script>
</body>
</html>
