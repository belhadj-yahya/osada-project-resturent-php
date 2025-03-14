<?php
include("../db_contect.php");

// $result = $con->query("SELECT status, COUNT(status) as status_count FROM orders GROUP by status");
session_start();
$year = $_SESSION["date2"];

$result = $con->query("SELECT DATE_FORMAT(orders.order_date, '%Y') AS year,dishes.dish_name,COUNT(order_details.dish_id) AS number_of_dish  FROM dishes  JOIN order_details ON dishes.dish_id = order_details.dish_id  JOIN orders ON order_details.order_id = orders.order_id GROUP BY dishes.dish_name, year HAVING year = $year");

$data = $result->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($data);
