<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$conn = new mysqli("localhost", "root", "", "nogen");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$branches = ["COM" => "1", "EXTC" => "2", "IT" => "3", "MECH" => "6", "ECS" => "7", "AIDS" => "8", "AIML" => "9", "IOT" => "X"];

foreach ($branches as $branch => $branch_code) {
    foreach (["FE", "DSE"] as $sem) {
        $sql = "SELECT * FROM rollno WHERE branch='$branch' AND sem='$sem' ORDER BY ad_year, srno";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $srno = 1;
            while($row = $result->fetch_assoc()) {
                $year = substr($row['ad_year'], -2);
                $first_digit = $sem == "FE" ? "1" : "2";
                $rollno = $first_digit . $year . "A" . $branch_code . str_pad($srno, 3, "0", STR_PAD_LEFT);
                $srno++;

                $update_sql = "UPDATE rollno SET rollno='$rollno' WHERE id=" . $row['id'];
                $conn->query($update_sql);
            }
        }
    }
}

echo json_encode($update_sql);

$conn->close();
?>
