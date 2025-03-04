<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qrcodedb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT ID, STUDENTID, TIMEIN, TIMEOUT, LOGDATE, STATUS FROM table_attendance";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$filename = "attendance_export.csv";
$file = fopen($filename, "w");

if ($file === false) {
    die("Error opening file for writing.");
}

$headers = array("ID", "STUDENT ID", "TIME IN", "TIME OUT", "LOG DATE", "STATUS");
fputcsv($file, $headers);

while ($row = $result->fetch_assoc()) {
    $id = isset($row['ID']) ? $row['ID'] : '';
    $studentid = isset($row['STUDENTID']) ? $row['STUDENTID'] : '';
    $timein = isset($row['TIMEIN']) && $row['TIMEIN'] != "0000-00-00 00:00:00" ? $row['TIMEIN'] : 'Not yet timed in';
    $timeout = isset($row['TIMEOUT']) && $row['TIMEOUT'] != NULL ? $row['TIMEOUT'] : 'Not yet timed out';
    $logdate = isset($row['LOGDATE']) ? $row['LOGDATE'] : '';
    $status = isset($row['STATUS']) ? ($row['STATUS'] == 1 ? "Timed Out" : "Timed In") : '';

    fputcsv($file, array($id, $studentid, $timein, $timeout, $logdate, $status));
}

fclose($file);
$conn->close();

header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: application/csv");

readfile($filename);
unlink($filename);
exit();
?>
