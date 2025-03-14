<?php
session_start();

include("../db_contect.php");

//the second char date here
$most_sell_dishes_query = "SELECT DATE_FORMAT(orders.order_date, '%Y') AS year,dishes.dish_name,COUNT(order_details.dish_id) AS number_of_dish  FROM dishes JOIN order_details ON dishes.dish_id = order_details.dish_id  JOIN orders ON order_details.order_id = orders.order_id GROUP BY dishes.dish_name, year ORDER BY year";
//number of status in order table
$orders_that_have_status  = "SELECT status,COUNT(status) as status_count FROM orders GROUP by status";
//all orders date from oldes to older
$orders_dates_query = "SELECT date_format(order_date, '%Y') AS dates FROM orders GROUP BY dates";
//revenu per month and total
$revenue_query = "SELECT date_format(orders.order_date, '%Y') as year,SUM(order_details.quantity * dishes.dish_price) as total_revenue FROM order_details JOIN dishes ON order_details.dish_id = dishes.dish_id join orders ON order_details.order_id = orders.order_id GROUP by year WITH ROLLUP";



$status_in_orders = useQuery($con, $orders_that_have_status, true);
$orders_date = useQuery($con, $orders_dates_query, true); //
$most_sell_dishes = useQuery($con, $most_sell_dishes_query, true);
$revenue = useQuery($con, $revenue_query, true);

$dish_array = [];
foreach ($most_sell_dishes as $dish) {
    $year = $dish["year"];

    if (!isset($dish_array[$year])) {
        $dish_array[$year] = [];
    }
    $dish_array[$year][] = ["dish name" => $dish["dish_name"],  "dish selles" => $dish["number_of_dish"]];
}
// this is how we are going to create the select form the year
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../styles/dashbord.css">
    <title>Document</title>
</head>

<body>
    <?php include("nav.php") ?>
    <div class="content">
        <?php
        $_SESSION["date"] = $orders_date[0]["dates"];
        $_SESSION["date2"] = array_keys($dish_array)[0];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["date_search"])) {
                $_SESSION["date"] = $_POST["date"];
            } elseif (isset($_POST["date_search2"])) {
                $_SESSION["date2"] = $_POST["date2"];
            }
        } else {
            $_SESSION["date"] = $orders_date[0]["dates"];
        }
        ?>
        <div class="right_said">
            <div class="canver can1">
                <h3>Orders status per year</h3>
                <form method="post">
                    <select name="date" id="">
                        <?php
                        foreach ($orders_date as $date) {
                            echo "<option value='" . $date["dates"] . "'>" . $date["dates"] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" name="date_search" value="search">
                </form>
                <div class="canves_div">
                    <canvas id="myPieChart" width="100" height="100"></canvas>
                </div>
            </div>
            <DIV class="canver can2">
                <h3>Ordered dishes per year</h3>
                <form method="post">
                    <select name="date2" id="">
                        <?php
                        foreach ($dish_array as $key => $date) {
                            echo "<option value='" . $key . "'>" . $key . "</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" name="date_search2" value="search">
                </form>
                <div class="canves_div">
                    <canvas id="myChart" width="100" height="100"></canvas>
                </div>

            </DIV>
        </div>
        <div class="left_side">
            <div class="orders_per_mounth">
                <h3>Number of orders per months</h3>
                <table>
                    <tr>
                        <th>Month</th>
                        <th>Number of orders</th>
                    </tr>
                    <?php
                    $month_orders_query = "SELECT DATE_FORMAT(order_date, '%Y-%M') AS month, COUNT(order_id) AS number_of_orders FROM orders GROUP BY YEAR(order_date),MONTH(order_date) ORDER BY YEAR(order_date) ASC";
                    $month_orders = useQuery($con, $month_orders_query, true);
                    foreach ($month_orders as $order) {
                        echo <<<HTML
                        <tr>
                            <td>{$order["month"]}</td>
                            <td>{$order["number_of_orders"]}</td>
                        </tr>
                    HTML;
                    }
                    ?>
                </table>
            </div>
            <div class="ravenu_per_mounth">
                <h3>revenue per year</h3>
                <table>
                    <tr>
                        <th>year</th>
                        <th>revenue</th>
                    </tr>
                    <?php

                    foreach ($revenue as $year) {
                        if ($year["year"] != null) {
                            echo <<<HTML
                            <tr> 
                                <td>{$year["year"]}</td>
                                <td>{$year["total_revenue"]}$</td>
                            </tr>
                            HTML;
                        }
                    }
                    ?>
                </table>
            </div>
            <div class="total">
                <h3>total revenue</h3>
                <p><?php
                    $last = count($revenue) - 1;
                    echo $revenue[$last]["total_revenue"] . "$";
                    ?></p>
            </div>
        </div>
    </div>

    <script src="../scripts/script.js"></script>
</body>

</html>
<?php

function useQuery($con, $query, $staute)
{
    if ($staute) {
        $result = $con->query($query);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } else {
        $con->exec($query);
    }
}
?>