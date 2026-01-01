<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $select = mysqli_query($conn, "SELECT * FROM products WHERE id='$book_id'") or die('query failed');
    if (mysqli_num_rows($select) > 0) {
        $book = mysqli_fetch_assoc($select);
    } else {
        header('location:home.php');
    }
} else {
    header('location:home.php');
}

if (isset($_POST['add_to_cart'])) {
    $pro_name = $_POST['product_name'];
    $pro_price = $_POST['product_price'];
    $pro_quantity = $_POST['product_quantity'];
    $pro_image = $_POST['product_image'];

    $check = mysqli_query($conn, "SELECT * FROM cart WHERE name='$pro_name' AND user_id='$user_id'") or die('query failed');

    if (mysqli_num_rows($check) > 0) {
        $message[] = 'Already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id, name, price, quantity, image) VALUES ('$user_id', '$pro_name', '$pro_price', '$pro_quantity', '$pro_image')") or die('query2 failed');
        $message[] = 'Product added to cart!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Details</title>
  <link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" href="home1.css">
  <style>
    .popup-container {
      max-width: 800px;
      margin: 3rem auto;
      background: rgba(88, 58, 1, 0.89);
      padding: 2rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      border-radius: 12px;
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      align-items: center;
      animation: fadeIn 0.5s ease;
    }

    .popup-image {
      flex: 1 1 40%;
    }

    .popup-image img {
      width: 100%;
      border-radius: 10px;
    }

    .popup-details {
      flex: 1 1 55%;
    }

    .popup-details h2 {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .popup-details .author {
      color:rgb(243, 220, 159);
      margin-bottom: 1rem;
    }

    .stars {
      color: #f7b500;
      font-size: 1.4rem;
      letter-spacing: 1px;
      margin-bottom: 1rem;
    }

    .popup-details p.price {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }

    .popup-details form {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .popup-details input[type="number"] {
      width: 60px;
      padding: 0.3rem;
    }

    .product_btn {
        background-color:rgb(172, 118, 2);
        color: #111;
        border: none;
        padding: 0.6rem 1rem;
        cursor: pointer;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    .product_btn:hover {
        background-color: #rgb(129, 88, 1);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<?php include 'user_header.php'; ?>

<div class="popup-container">
  <div class="popup-image">
      <img src="./uploaded_img/<?php echo $book['image']; ?>" alt="">
  </div>
  <div class="popup-details">
      <h2><?php echo $book['name']; ?></h2>
      <div class="author"><strong>Author:</strong> <?php echo $book['author_name']; ?></div>
    <div class="stars" style="font-family: 'Poppins', sans-serif; font-size: 1.2rem;">
  <?php
    $rating = $book['ratings'];
    $rounded = round($rating);
    for ($i = 1; $i <= 5; $i++) {
        echo ($i <= $rounded) ? '★' : '☆';
    }
    echo " <span style='font-size: 1rem; color: white ;'>($rating)</span>";
  ?>
    </div>


      <p class="price">Rs. <?php echo $book['price']; ?>/-</p>
      <p style="margin-bottom: 1rem; color: #fff;"><?php echo $book['description']; ?></p>
      <form action="" method="post">
          <input type="hidden" name="product_name" value="<?php echo $book['name']; ?>">
          <input type="hidden" name="product_price" value="<?php echo $book['price']; ?>">
          <input type="hidden" name="product_image" value="<?php echo $book['image']; ?>">
          <label>Quantity: </label>
          <input type="number" name="product_quantity" value="1" min="1">
          <input type="submit" name="add_to_cart" value="Add to Cart" class="product_btn">
      </form>
  </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
