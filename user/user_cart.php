<?php
session_start();
include("../db_contect.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user_page_style/cart.css">
    <title>Document</title>
</head>

<body>
    <?php include_once("log_in_nav.php") ?>
    <main>
        <div class="intro">
            <img src="../user_images/undraw_empty-cart_574u.svg" alt="shoping cart">
            <h1>"Track and manage your food orders easily enjoy seamless delivery right to your door!"</h1>
        </div>
        <h1 class="h1">Order :</h1>
        <div class="orders">

            <?php
            if (empty($_SESSION["dishes_to_cart"])) {
                echo "<p class='error'>No dishes in the cart yet!</p>";
            }
            ?>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["delete"])) {
                    unset($_SESSION["dishes_to_cart"][$_POST["index"]]);
                    if (count($_SESSION["dishes_to_cart"]) > 0) {
                        showCart($_SESSION["dishes_to_cart"]);
                    } else {
                        echo "<p class='error'>No dishes in the cart yet!</p>";
                    }
                } elseif (isset($_POST["send_order"])) {
                    header("location: confirm_order.php");
                    showCart($_SESSION["dishes_to_cart"]);
                    $_SESSION["order_details"] = [];
                    for ($i = 0; $i < count($_POST["order_price"]); $i++) {
                        $_SESSION["order_details"][] = [
                            "dish_id" => $_POST["dish_id"][$i],
                            "dish_name" => $_POST["order_name"][$i],
                            "quentity" => $_POST["quentity"][$i],
                            "order_price" => $_POST["order_price"][$i]
                        ];
                    }
                    $_SESSION["total_order_price"] = $_POST["total"];
                   
                    exit();
                    
                }
            } else {
                if (count($_SESSION["dishes_to_cart"]) > 0) {
                    showCart($_SESSION["dishes_to_cart"]);
                }
            }

            ?>
        </div>
    </main>


    <?php include_once("../footer.php") ?>
    <script src="../user_scripts/script.js"></script>
</body>


</html>
<?php
function showCart($array)
{
    echo <<<HTML
            <div class="order">
                <form method="post">
        HTML;
        foreach ($array as $key => $dish_info) {
        echo <<<HTML
              <div class="hold">
                    <img src="{$dish_info['dish_img']}" class="dumy_img"  alt="imag">
                    <input type="hidden" name="index" value="$key">
                    <input type="hidden" name="dish_id[]" value="{$dish_info['dish_id']}" readonly>
                    <div>
                        <label for="order_name">Dish:</label>
                        <input type="text" name="order_name[]" value="{$dish_info['dish_name']}" readonly>
                    </div>
                    <div>
                        <label for="order_quentity">Quantity:</label>
                        <input type="number" value="1" name="quentity[]" class="quen" min="1" id="" >
                    </div>
                    <div>
                        <label for="order_price">Price:</label>
                        <input type="text" name="order_price[]" class="price" value="{$dish_info['dish_price']}" readonly>
                    </div>
                    <input type="submit" name="delete" value="Remove">
                </div>
            HTML;
        if ($dish_info == end($array)) {
            echo <<<HTML
                 <div class="last_step">
                    <p>Total: </p>
                    <p class="total"></p>
                    <input type="hidden" name="total" class="total_to_use">
                    <input type="submit" name="send_order" value="Submit order">
                </div>
             HTML;
        }
        }
    echo <<<HTML
                 </form>
            </div>
    HTML;
}
?>