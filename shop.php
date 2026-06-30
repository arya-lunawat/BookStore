<?php
include 'config.php';
session_start();

$user_id=$_SESSION['user_id'];

if(!isset($user_id)){
  header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="style1.css">

  <link rel="stylesheet" href="home1.css">

  <style>
    .book-title a {
  text-decoration: none;
  color: rgb(241, 170, 16);
  transition: transform 0.3s ease, color 0.3s ease;
  display: inline-block;
}

.book-title a:hover {
  transform: scale(1.1);
  color:rgb(252, 216, 158);
}

  </style>

</head>
<body>
  
<?php
include 'user_header.php';
?>

<section class="products_cont">
    <div class="pro_box_cont">
      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');

      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {

      ?>
          <div class="pro_box">
            <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <h3 class="book-title">
  <a href="book_details.php?id=<?php echo $fetch_products['id']; ?>">
    <?php echo $fetch_products['name']; ?><br><span style="color: white; font-size: smaller;"><?php echo $fetch_products['author_name']; ?></span><br><span style="color: white; font-size: smaller;">Rs. <?php echo $fetch_products['price']; ?>/-</span>
  </a>
</h3>
            <p>Rating: <?php echo $fetch_products['ratings']; ?>/5</p>

            <a href="reader.php?sample=1&id=<?php echo $fetch_products['id']; ?>" class="product_btn">Read Sample</a>

          </div>

      <?php
        }
      } else {
        echo '<p class="empty">No Products Added Yet !</p>';
      }
      ?>
    </div>
  </section>

<?php
include 'footer.php';
?>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

<script src="script.js"></script>

</body>
</html>