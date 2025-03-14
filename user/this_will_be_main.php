<?php

session_start();


if (!isset($_SESSION["dishes_to_cart"])) {
    $_SESSION["dishes_to_cart"] = [];
}
include("../db_contect.php");

$dishs_query = "SELECT dishes.*,categories.category_name FROM  dishes JOIN categories ON dishes.category_id = categories.category_id";
$categories_query = "SELECT category_name FROM categories";

$categories = $con->query($categories_query);
$categories_array = $categories->fetchAll(PDO::FETCH_ASSOC);
$array = $con->query($dishs_query);
$array = $array->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user_page_style/main_page.css">
    <title>main page</title>
</head>

<body class="main">
    <?php include("log_in_nav.php") ?>
    <h1 class="welcoming">Hello <?php echo $_SESSION["user_name"] . " " . $_SESSION["user_last_name"] ?></h1>
    <section class="logo_like">
        <img src="../user_images/undraw_donut-love_5r3x.svg" class="img1" alt="">
        <h1>Everything you crave, delivered.</h1>
    </section>
    <h1 class="space">dishes : </h1>
    <main>
        <div class="settings">
            <div class="first_form">
                <form class="search_bar" method="post">
                    <input type="text" name="search_bar" value="" id="" placeholder="Search...">
                </form>
                <button class="search_bar_button">search</button>
            </div>
            <div class="second_form">
                <form class="select_search">
                    <select name="categories" id="">
                        <option value="">All Categories</option>
                        <?php foreach ($categories_array as $category) { ?>
                            <option value="<?php echo $category['category_name']; ?>"><?php echo $category['category_name']; ?></option>
                        <?php } ?>
                    </select>
                </form>
            </div>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["add"])) {
                $check = true;
                foreach ($_SESSION["dishes_to_cart"] as $item) {
                    if (in_array($_POST["dish_id"], $item)) {
                        $check = false;
                        echo "<p class='error'>item is allready in the cart</p>";
                        break;
                    }
                }
                if ($check) {
                    echo "<p class='valid'>item is added to the cart<p>";
                    $_SESSION["dishes_to_cart"][] = [
                        "dish_img" =>  $_POST["dish_img"],
                        "dish_id" => $_POST["dish_id"],
                        "dish_name" => $_POST["dish_name"],
                        "dish_price" => $_POST["dish_price"]
                    ];
                }
                
            }
        }
        ?>
        <div class="dishes">
            <?php
            foreach ($array as $dish) {
                //dont forget to add images
                echo <<<HTML
                <div class="dish">
                    <img src="{$dish['dish_img']}" class="img"  alt="imag">
                    <p class="name">{$dish["dish_name"]}</p>
                    <p>{$dish["dish_price"]}$</p>
                    <form class="parametars_to_use" method="POST">
                        <input type="submit" class="add_to_cart" name="add" value="Add to cart">
                        <input type="hidden" name="dish_img" value="{$dish['dish_img']}">
                        <input type="hidden" name="dish_id" value="{$dish['dish_id']}">
                        <input type="hidden" name="dish_name" value="{$dish['dish_name']}">
                        <input type="hidden" name="dish_price" value="{$dish['dish_price']}">
                        <input type="hidden" name="dish_category" value="{$dish['category_name']}">
                    </form>
                </div>
                HTML;
            }
            ?>
        </div>
    </main>
    <section class="fianl_section">
        <img src="../user_images/undraw_office-snack_7o81.svg" alt="">
        <h1>Need a boost while you work? Get delicious food delivered right to you,so you can keep powering through your day without skipping a beat.</h1>
    </section>
    <?php include("../footer.php") ?>
    <script src="../user_scripts/script.js"></script>
</body>

</html>