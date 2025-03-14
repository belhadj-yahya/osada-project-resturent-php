<head>
    <link rel="stylesheet" href="../styles/nav.css">
</head>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["sign_out"])) {
        setcookie("email", "", strtotime("-1 second"), "/resturent");
        setcookie("password", "", strtotime("-1 second"), "/resturent");
        setcookie("admen_email", "", strtotime("-1 second"), "/resturent");
        setcookie("admen_password", "", strtotime("-1 second"), "/resturent");
        header("location: ../index.php");
        exit();
    }
}

?>
<aside>
    <nav>
        <div class="link">
            <img src="../icons/pie-chart-outline.svg" class="icon" alt="">
            <a href="index.php" class="to">dashBord</a>
        </div>
        <div class="link">
            <img src="../icons/category-2-svgrepo-com.svg" class="icon" alt="">
            <a href="category.php" class="to">categories</a>
        </div>
        <div class="link">
            <img src="../icons/dish-svgrepo-com.svg" class="icon" alt="">
            <a href="dishes.php" class="to">dishes</a>
        </div>
        <div class="link">
            <img src="../icons/order-svgrepo-com.svg" class="icon" alt="">
            <a href="order.php" class="to">orders</a>
        </div>
        <div class="link">
            <img src="../icons/users-svgrepo-com.svg" class="icon" alt="">
            <a href="users.php" class="to">Users</a>
        </div>
        <div class="link">
            <form method="POST">
                <input type="submit" name="sign_out" value="Sign Out">
            </form>
        </div>
    </nav>
</aside>