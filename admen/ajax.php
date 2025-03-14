<?php
include("../db_contect.php");
session_start();

$year = $_SESSION["date"];

$result = $con->query("SELECT DATE_FORMAT(order_date, '%Y') as year,status,COUNT(status) as status_count FROM orders GROUP by status,year HAVING year = $year");

$data = $result->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($data);
