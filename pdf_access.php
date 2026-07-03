<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!isset($user_id)) {
    header('location: login.php');
    exit;
}

$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sample = isset($_GET['sample']) ? 1 : 0;

if ($sample) {
    // Serve sample PDF
    $select = mysqli_query($conn, "SELECT sample_pdf FROM products WHERE id='$book_id'") or die('query failed');
    if (mysqli_num_rows($select) > 0) {
        $book = mysqli_fetch_assoc($select);
        $file_path = './uploaded_samples/' . $book['sample_pdf'];
    } else {
        die('Sample not available');
    }
} else {
    // Check ownership and serve full PDF
    $owned = mysqli_query($conn, "SELECT p.pdf_file FROM purchased_books pb JOIN products p ON pb.product_id = p.id WHERE pb.user_id='$user_id' AND pb.product_id='$book_id'") or die('query failed');
    if (mysqli_num_rows($owned) > 0) {
        $book = mysqli_fetch_assoc($owned);
        $file_path = './uploaded_pdf/' . $book['pdf_file'];
    } else {
        die('Access denied');
    }
}

if (file_exists($file_path)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
    exit;
} else {
    die('File not found');
}
?>
