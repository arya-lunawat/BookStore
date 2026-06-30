<?php
include 'config.php';

$result = mysqli_query($conn, "SELECT id, name, email, password, user_type FROM register");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row['id'] . " Name: " . $row['name'] . " Email: " . $row['email'] . " Password: " . $row['password'] . " Type: " . $row['user_type'] . "\n";
    }
} else {
    echo "No data or error: " . mysqli_error($conn);
}
?>
