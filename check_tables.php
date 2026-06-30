<?php
include 'config.php';

echo "<h2>Database Tables:</h2>";
$result = mysqli_query($conn, "SHOW TABLES");
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        echo $row[0] . "<br>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

echo "<h2>TBR List Table Structure:</h2>";
$result = mysqli_query($conn, "DESCRIBE tbr_list");
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        echo $row['Field'] . " " . $row['Type'] . " " . $row['Null'] . " " . $row['Key'] . " " . $row['Default'] . " " . $row['Extra'] . "<br>";
    }
} else {
    echo "Table tbr_list does not exist or error: " . mysqli_error($conn);
}

echo "<h2>Cart Table Structure (if exists):</h2>";
$result = mysqli_query($conn, "DESCRIBE cart");
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        echo $row['Field'] . " " . $row['Type'] . " " . $row['Null'] . " " . $row['Key'] . " " . $row['Default'] . " " . $row['Extra'] . "<br>";
    }
} else {
    echo "Table cart does not exist or error: " . mysqli_error($conn);
}
?>
