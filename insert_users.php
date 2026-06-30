<?php
include 'config.php';

// Delete existing users
mysqli_query($conn, "DELETE FROM register");

// Insert admin
$admin_pass = md5('admin123');
mysqli_query($conn, "INSERT INTO register (name, email, password, user_type) VALUES ('Admin User', 'admin@test.com', '$admin_pass', 'admin')");

// Insert user
$user_pass = md5('user123');
mysqli_query($conn, "INSERT INTO register (name, email, password, user_type) VALUES ('Test User', 'user@test.com', '$user_pass', 'user')");

echo "Users inserted successfully";
?>
