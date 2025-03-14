<?php
include("../db_contect.php");
$status_array = [["status" => "Pending", "color" => "orange"], ["status" => "Completed", "color" => "lightblue"], ["status" => "Shipped", "color" => "lightgreen"], ["status" => "Canceled", "color" => "red"]];
//this query is to show the orders cards only
$orders_sql = "SELECT orders.order_id,concat(users.first_name, ' ', users.last_name ) as full_name,orders.status,orders.order_date,date_format(orders.order_date,'%Y') as year, SUM((order_details.quantity * dishes.dish_price)) as total_price_for_dish from order_details JOIN dishes on order_details.dish_id = dishes.dish_id  JOIN orders on order_details.order_id = orders.order_id JOIN users on orders.user_id = users.user_id GROUP by orders.order_id";
//this query is to show the detailed orders
$ditiels_sql = "SELECT order_details.*,dishes.dish_name,dishes.dish_price,CONCAT(users.first_name, ' ', users.last_name) as full_name,users.email,users.phone_number,addresses.city,addresses.street,addresses.postal_code FROM order_details JOIN dishes on order_details.dish_id = dishes.dish_id JOIN orders on order_details.order_id = orders.order_id JOIN users on orders.user_id = users.user_id JOIN addresses on orders.address_id = addresses.address_id;";
$orders_list = applyQuery($con, $orders_sql, true);
$details_list = applyQuery($con, $ditiels_sql, true);
//this is here so that we can get the array that we will be using to create details cards to display
$final_list_array = turnIntoUsebleArray($details_list);
$uniqe_only_year = [];
foreach ($orders_list as $order) {
    if (!in_array($order["year"], $uniqe_only_year)) {
        $uniqe_only_year[] = $order["year"];
    }
}
// imagesx() you may need this for omages
$uniqe_only_status = [];
foreach ($orders_list as $order) {
    if (!in_array(strtolower(trim($order["status"])), $uniqe_only_status)) {
        $uniqe_only_status[] =  strtolower(trim($order["status"]));
    }
}
function turnIntoUsebleArray($array)
{
    $resultArray = [];
    foreach ($array as $item) {
        $orderId = $item['order_id'];

        if (!isset($resultArray[$orderId])) {

            $resultArray[$orderId] = [
                'order_details_id' => $item["order_item_id"],
                'order_id' => $orderId,
                'full_name' => $item['full_name'],
                'email' => $item['email'],
                'phone_number' => $item['phone_number'],
                'city' => $item['city'],
                'street' => $item['street'],
                'postal_code' => $item['postal_code'],

                'items' => [],
            ];
        }

        $resultArray[$orderId]['items'][] = [
            'quantity' => $item['quantity'],
            'dish_name' => $item['dish_name'],
            'dish_price' => $item['dish_price'],
        ];
    }
    return $resultArray;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/orders.css">
    <title>Document</title>
</head>

<body>
    <?php include("nav.php") ?>
    <main>
        <div class="settings">
            <div class="form1">
                <div class="div_form">
                    <form method="GET">
                        <input type="text" id="search_bar" placeholder="search by order ID">
                    </form>
                    <button class="search_btn">Search</button>
                </div>

                <form method="POST">
                    <select name="filter-by-date" class="filter-by-date" id="">
                        <option value="all">show all</option>
                        <?php
                        foreach ($uniqe_only_year as $order) {
                            echo "<option value='" . $order . "'>" . $order . "</option>";
                        }
                        ?>
                    </select>
                    <select name="filter-by-statue" class="filter-by-statue" id="">
                        <option value="all">show all</option>
                        <?php
                        foreach ($uniqe_only_status as $order) {
                            echo "<option value='" . $order . "'>" . $order . "</option>";
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>
        <div class="content">
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["delete"])) {
                    $order_id_to_delete = $_POST["order_id_to_delete"];
                    applyQuery($con, "DELETE from orders WHERE order_id = $order_id_to_delete", false);
                    $orders_list = applyQuery($con, $orders_sql, true);
                    $details_list = applyQuery($con, $ditiels_sql, true);
                    $final_list_array = turnIntoUsebleArray($details_list);
                    showContent($orders_list, $final_list_array, $status_array);
                } elseif (isset($_POST["change"])) {
                    $show = 0;
                    $order_id_to_change = $_POST["order_id_to_change"];
                    $new_status = $_POST["change_status"];
                    if($new_status != "Pending"){
                        $show = 1;
                    }
                    applyQuery($con, "UPDATE orders SET status = '$new_status' , notification = $show WHERE order_id = $order_id_to_change", false);
                    $orders_list = applyQuery($con, $orders_sql, true);
                    $details_list = applyQuery($con, $ditiels_sql, true);
                    $final_list_array = turnIntoUsebleArray($details_list);
                    showContent($orders_list, $final_list_array, $status_array);
                }
            } else {
                showContent($orders_list, $final_list_array, $status_array);
            }
            ?>
        </div>
    </main>
    <script src="../scripts/script.js"></script>
</body>

</html>
<?php
function applyQuery($con, $query, $state)
{
    if ($state) {
        $result = $con->query($query);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } else {
        $con->exec($query);
    }
}
function showContent($array, $array2, $status)
{
    reset($array2);
    $dumy_array = current($array2);
    foreach ($array as  $order) {
        $total_amount = 0;
        foreach ($status as $state) {
            if (strtolower($order["status"]) === strtolower($state["status"])) {
                echo "<div class='order {$state['color']}'>";
                break;
            }
        }
        echo <<<HTML
                        <p class="id">Order ID : {$order["order_id"]}</p>
                        <p>User name : {$order["full_name"]}</p>
                        <p class="status">Order status : {$order["status"]}</p>
                        <p class="date">Order date : {$order["order_date"]}</p>
                        <p>Total Amount : {$order["total_price_for_dish"]}$</p>
                        <button class="delete">Delete</button>
                        <button class="show_details">Show Details</button>     
                        <button class="change">change status</button>
                        <form  method="post">
                            <input type="hidden" name="year" class="year" value="{$order['year']}">
                        </form>    
                    </div>
                    <dialog class="state_change_dialog">
                        <div>
                            <h3>change order status</h3>
                            <form method="post">
                            <input type="hidden" name="order_id_to_change" value="{$order['order_id']}">
                            <select name="change_status" id="">
            HTML;
        foreach ($status as $state) {
            echo "<option value='" . $state["status"] . "'>" . $state["status"] . "</option>";
        }
        echo <<<HTML
                                </select>
                                <input type="submit" value="change" name="change">
                            </form>
                            <button class="change_close">Cancel</button>
                        </div>
                    </dialog>
                    <dialog class="delete_dialog">
                      <div>
                                <h2>are you sure you want to delete this order!</h2>
                                <form  method="POST">
                                <input type="submit" name="delete" value="YES">
                                    <input type="hidden" name="order_id_to_delete" value="{$order['order_id']}">
                                </form>
                                <button class="cancel_delete">No</button>
                        </div>
                    </dialog>
                    <dialog class="details_Dailog">
                        <div>
                        <p>Order ID : {$dumy_array["order_id"]}</p>
                        <p>User name : {$dumy_array["full_name"]}</p>
                        <p>User email : {$dumy_array["email"]}</p>
                        <p>User City : {$dumy_array["city"]}</p>
                        <p>User street: {$dumy_array["street"]}</p>
                        <p>User postal_code : {$dumy_array["postal_code"]}</p>
                        <p>dishes purches : </p>
            HTML;
        foreach ($dumy_array["items"] as $item) {
            $total_price =  number_format($item["quantity"] * $item["dish_price"], 2);
            $total_amount += $total_price;
            echo <<<HTML
                    <p>{$item["quantity"]} - {$item["dish_name"]} - {$item["dish_price"]}$ : {$total_price}$</p>
                    HTML;
        }
        echo <<<HTML
                        <p>Total Amount : {$total_amount}$</p>
                        <button class="back">Back</button>
                        </div>
                </dialog>
            
            HTML;
        next($array2);
        $dumy_array = current($array2);
    }
}
?>