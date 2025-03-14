<?php
if (!isset($_SESSION["cart_items"])) {
    $_SESSION["cart_items"] = 0;
}
$_SESSION["cart_items"] = count($_SESSION["dishes_to_cart"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["sign_out"])) {
        setcookie("email", "", strtotime("-1 second"), "/resturent");
        setcookie("password", "", strtotime("-1 second"), "/resturent");
        setcookie("admen_email", "", strtotime("-1 second"), "/resturent");
        setcookie("admen_password", "", strtotime("-1 second"), "/resturent");
        header("location: ../");
    }
}
?>

<head>
    <link rel="stylesheet" href="../user_page_style/log_in_nav.css">
</head>
<header>
    <h2>food<span>YA</span></h2>
    <nav>
        <a href="this_will_be_main.php"><img src="../icons/user_home_page.svg" class="im" alt="">Home</a>
        <a href="user_cart.php"><img src="../icons/user_cart.svg" alt="" class="im">Cart <?php echo $_SESSION["cart_items"]  ?></a>
        <a href="history_user.php"><img src="../icons/clock-rotate-left-solid.svg" alt="" class="im">Orders</a>
        <form method="post"><input type="submit" name="sign_out" value="Sign Out"></form>
    </nav>
</header>