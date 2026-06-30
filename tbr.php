<?php
include 'config.php';
session_start();

$user_id=$_SESSION['user_id'];

if(!isset($user_id)){
  header('location:login.php');
}



if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];
  mysqli_query($conn,"DELETE FROM `tbr_list` WHERE id='$delete_id'") or die('query failed');
  header('location:tbr.php');
}

if(isset($_GET['delete_all'])){
  mysqli_query($conn, "DELETE FROM `tbr_list` WHERE user_id = '$user_id'") or die('query failed');
  header('location:tbr.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TBR List</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" href="home1.css">


</head>
<body>
  
<?php
include 'user_header.php';
?>

<section class="shopping_cart">
  <h1>TBR List</h1>

  <div class="cart_box_cont">
    <?php
    $grand_total=0;
    $select_cart=mysqli_query($conn, "SELECT * FROM `tbr_list` where user_id='$user_id'") or die('query failed');

    if(mysqli_num_rows($select_cart)>0){
      while($fetch_cart=mysqli_fetch_assoc(($select_cart))){


    ?>
    <div class="cart_box">
      <a href="tbr.php?delete=<?php echo $fetch_cart['id'];?>" class="fas fa-times" onclick="return confirm('Are you sure you want to delete this book from TBR list');"></a>
      <img src="./uploaded_img/<?php echo $fetch_cart['image'];?>" alt="">
      <h3><?php echo $fetch_cart['name']; ?></h3>
      <p>Rs. <?php echo $fetch_cart['price']; ?>/-</p>
      <p>Digital Book</p>
      <p>Total : <span>$<?php echo $sub_total = $fetch_cart['price']; ?>/-</span></p>
    </div>
    <?php
    $grand_total+=$sub_total;
      }
    }else{
      echo '<p class="empty">Your TBR List is Empty!</p>';
    }
    ?>
  </div>

  <div class="cart_total">
    <h2>Total TBR Price : <span>$ <?php echo $grand_total;?>/-</span></h2>
    <div class="btns_cart">
    <a href="tbr.php?delete_all" class="product_btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Are you sure you want to delete all books from TBR list?');">Delete All from TBR</a>
      <a href="shop.php" class="product_btn">Continue Shopping</a>
      <a href="checkout.php" class="product_btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Checkout</a>
    </div>
  </div>
    
</section>

<?php
include 'footer.php';
?>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

<script src="script.js"></script>

</body>
</html>