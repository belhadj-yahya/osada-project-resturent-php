<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("../db_contect.php");
$user_orders_query = "SELECT  u.user_id,o.order_id, o.status,o.order_date, d.dish_name,d.dish_price, od.quantity FROM order_details od JOIN orders o ON od.order_id = o.order_id JOIN dishes d ON od.dish_id = d.dish_id JOIN users u ON o.user_id = u.user_id WHERE u.user_id =" . $_SESSION["user_id"];

$years_of_user_orders_query = "SELECT date_format(order_date, '%Y') as year from orders where user_id =" . $_SESSION["user_id"] . " GROUP by year "; //for selecting all order dates of the same user that wil enter
$result_array = useQuery($con, "", $user_orders_query, false);

$date_array = useQuery($con, "", $years_of_user_orders_query, false);
$user_id = $_SESSION['user_id'];
$orders_query = "SELECT * FROM orders WHERE user_id = '$user_id' AND notification = 1";
$orders = $con->query($orders_query);
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);






$modify_array = [];

foreach ($result_array as $array) {
    $id = $array["order_id"];
    if (!isset($modify_array[$id])) {
        $modify_array[$id] = [
            "order_id" => $array["order_id"],
            "status" => $array["status"],
            "order_date" => $array["order_date"],
            "plates" => []
        ];
    }
    $modify_array[$id]["plates"][] = [
        "dish_name" => $array["dish_name"],
        "dish_price" => $array["dish_price"],
        "quantity" => $array["quantity"]
    ];
}


?>
<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user_page_style/history_style.css">
    <title>history</title>
</head>
<body>
    <?php include_once("log_in_nav.php") ?>
 <?php if(!empty($orders)){?>
    <div class="notifation">
        <?php
        foreach($orders as $order){
          if($order["notification"] === 1){
            echo <<<HTML
                <div class="not">
                    <div class="text">
                        <p>the order with the ID of {$order["order_id"]}</p>
                        <p>statu has changed to <span>{$order["status"]}</span></p>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="{$order['order_id']}">
                        <input type="submit" name="ok" value="X">
                    </form>
                </div>
            HTML;
          }
        }
        ?>
    </div>
<?php } ?>

    <main>
        <section class="test">
            <img src="../user_images/undraw_taking-notes_4si1.svg" alt="">
            <p>See all your Old and New orders in one plaice</p>
        </section>
        <div class="importent">
            <div class="settings">
                <form method="post">
                    <select name="year" id="">
                        <option value="">Select Year</option>
                        <?php
                        foreach ($date_array as $date) {
                            echo "<option value='" . $date["year"] . "'>" . $date["year"] . "</option>";
                        }
                        ?>
                    </select>
                </form>
                <button class="Show_history">search</button>
            </div>
            <div class="history">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["cancel"])) {
                        $id = $_POST["order_id"];
                        $con->exec("UPDATE orders SET status = 'canceled' WHERE order_id = $id");
                        showHistory($modify_array);
                    }elseif(isset($_POST["ok"])){
                        $order_id = $_POST["order_id"];
                         $con->exec("UPDATE orders SET notification = 0 WHERE order_id = $order_id");
                         header("Location: history_user.php");
                    }
                } else {
                    showHistory($modify_array);
                }

                ?>
            </div>
        </div>
    </main>



    <?php include_once("../footer.php") ?>
    <script src="../user_scripts//script.js"></script>
</body>
</html>
<?php
function useQuery($con, $query, $main_query, $status)
{
    if ($status) {
        $con->exec($query);
    }
    $result = $con->query($main_query);
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function showHistory($order)
{
    foreach ($order as $order_item) {
        if ($order_item["status"] != "canceled") {
            $total = 0;
            echo <<<HTML
                <div class="order">
                    <p class="date">Date: {$order_item["order_date"]}</p>
                    <p>Status: {$order_item["status"]}</p>
            HTML;
            foreach ($order_item["plates"] as $dish) {
                $amount = $dish["quantity"] * $dish["dish_price"];
                $total += $amount;
                echo "<p>{$dish["quantity"]} - {$dish["dish_name"]} - {$dish["dish_price"]}$ : {$amount}$</p>";
            }
            echo <<<HTML
                    <p>Total Amount: {$total}$</p>
                    <form method="post">
                        <input type="hidden" name="order_id" value="{$order_item['order_id']}">
                        <input type="submit" name="cancel" value="cancel">
                    </form>
                </div>
            HTML;
        }
    }
}
?>