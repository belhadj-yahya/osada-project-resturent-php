<?php
session_start();
include("../db_contect.php");
$query = $con->prepare("SELECT * FROM addresses WHERE addresses.user_id = ?");
$query->execute([$_SESSION["user_id"]]);
$location = $query->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// print_r($location);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user_page_style/confirm.css">
    <title>conferm page</title>
</head>

<body>
    <form method="post">
        <input type="submit" name="back" value="Back">
    </form>
    <main>
        <div class="items">
            <?php
            foreach ($_SESSION["order_details"] as $order) {
                echo <<<HTML
              <div class="item">
                <form id="id_to_add" method="post">
                    <input type="hidden" name="dish_id" value="{$order['dish_id']}">
                </form>
                <p>name : {$order["dish_name"]}</p>
                <p>price : {$order["quentity"]}</p>
                <p>quentity : {$order["order_price"]}$</p>
              </div>
            HTML;
            }
            echo "<h3>" . "total price: " . $_SESSION["total_order_price"] . "$</h3>"
            ?>
        </div>
        <div class="information">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["back"])) {
                    header("Location: user_cart.php");
                }elseif(isset($_POST["end_order"])) {
                    $find_addrese = $con->prepare("SELECT address_id FROM addresses WHERE street = ? and city = ? and postal_code = ? and  user_id = ?");
                    $find_addrese->execute([$_POST["street"],$_POST["city"],$_POST["postal_code"],$_SESSION["user_id"]]);
                    $loc = $find_addrese->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($loc)){
                        $add_order = $con->prepare("INSERT INTO orders(order_date,status,user_id,address_id) VALUES(NOW(),'pending',?,?)");
                        $add_order->execute([$_SESSION["user_id"],$loc[0]["address_id"]]);
                        $order_id = $con->lastInsertId();
                        foreach($_SESSION["order_details"] as $order){
                            $get_order = $con->prepare("INSERT INTO order_details(quantity,dish_id,order_id) VALUES(?,?,?)");
                            $get_order->execute([$order["quentity"],$order['dish_id'],$order_id]);
                       }
                    }else{
                        $add_location = $con->prepare("INSERT INTO addresses(street,city,postal_code,user_id) VALUES(?,?,?,?)");
                        $add_location->execute([$_POST["street"],$_POST["city"],$_POST["postal_code"],$_SESSION["user_id"]]);
                        $new_addrese_id = $con->lastInsertId();
                        $add_order = $con->prepare("INSERT INTO orders(order_date,status,user_id,address_id) VALUES(NOW(),'pending',?,?)");
                        $add_order->execute([$_SESSION["user_id"],$new_addrese_id]);
                        $order_id = $con->lastInsertId();
                        foreach($_SESSION["order_details"] as $order){
                            $get_order = $con->prepare("INSERT INTO order_details(quantity,dish_id,order_id) VALUES(?,?,?)");
                            $get_order->execute([$order["quentity"],$order['dish_id'],$order_id]);
                       }

                    }

                }
            }
            ?>
            <h2>Select a location</h2>
            <form method="post">
                <select name="location" id="">
                    <?php
                    foreach ($location as $index => $loc) {
                        echo "<option value='$index'>" . "locion" . $index + 1 . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" name="shoosen_location" value="use">
            </form>
            <?php
    

            ?>
            <h2 class="H22">fill your addresse information please!</h2>
            <form method="post">
                <?php
                $index = 0;
                if (isset($_POST["location"])) {
                    $index = $_POST["location"];
                }
                echo <<<HTML
                     <input type="hidden" name="loction_id" value="{$location[$index]['address_id']}">
                    <input type="text" name="city" id="" placeholder="enter name of the city" value="{$location[$index]['city']}" required>
                    <input type="text" name="street" id="" placeholder="enter name of the street" value="{$location[$index]['street']}" required>
                    <input type="text" name="postal_code" placeholder="enter postal code number" value="{$location[$index]['postal_code']}" id="" required>
                    
                    <input type="submit"  name="end_order" value="send order">
                HTML;
                ?>
            </form>
        </div>
    </main>
</body>

</html>