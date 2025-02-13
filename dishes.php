<?php
 include("db_contect.php");
 $mostUseSql = "SELECT dishes.dish_id, dishes.dish_name, dishes.dish_price, categories.category_name from dishes JOIN order_details on dishes.dish_id = order_details.dish_id JOIN categories on dishes.category_id = categories.category_id GROUP BY order_details.dish_id";
 $result = useQuery($con, $mostUseSql, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<aside>
        <nav>
            <li><a href="#dash">dashBord</a></li>
            <li><a href="#categories">categories</a></li>
            <li><a href="#dishes">dishes</a></li>
            <li><a href="#orders">orders</a></li>
        </nav>
    </aside>
        <div class="content">
        <div id="dishes">
            <div class="settinges">
            <form method="POST" class="firstForm">
                <div class="form1">
                    <input type="text" name="categorey" id="">
                    <input type="submit" value="search" name="findcat">
                </div>
            </form>
            <button>Add New Dish</button>
            </div>
            
            <div class="dish">
                <?php
                function useQuery($con, $query, $sheck)
                {
                    if ($sheck) {
                        $result = $con->query($query);
                        $result = $result->fetchAll(PDO::FETCH_ASSOC);
                        return $result;
                    } else {
                        $con->exec($query);
                    }
                }

                function showCategorys($result, $niddel)
                {
                    foreach ($result as $dish) {
                        $id = $dish["dish_id"];
                        if (str_contains(trim(strtolower($dish["dish_name"])), trim(strtolower($niddel)))) {
                            $output = <<<HTML
                            <div class='dishes'>
                                <p>Dish: {$dish["dish_name"]}</p>
                                <p>Dish Price: {$dish["dish_price"]}</p>
                                <p>Category: {$dish["category_name"]}</p>

                                <div class='settings'>
                                    <button class='remove'>DELETE</button>
                                    <button class='changeTo'>MODIFY</button>
                                </div>
                            </div>
                            <dialog class='deleteDailog'>
                                <h2>Are you sure you want to delete?</h2>
                                <form class='re' method='POST'>
                                    <input type='hidden' name='did' value='$id'>
                                    <input type='submit' name='delete' value='YES'>
                                </form>
                                <button class='close'>NO</button>
                            </dialog>
                            <dialog class='updated'>
                                <div class='dailogCont'>
                                    <h2>Update category</h2>
                                    <form method='POST'>
                                        <input type='hidden' name='id' value='$id'>
                                        <input type='text' name='newName'>
                                        <input type='submit' name='update' value='Update'>
                                    </form>
                                    <button class='no'>Back</button>
                                </div>
                            </dialog>
                            HTML;
                            echo $output; 
                        }
                    }
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["findcat"])) {
                        showCategorys($result, $_POST["categorey"]);
                    } elseif (isset($_POST["delete"])) {
                        $id = $_POST["did"];
                        useQuery($con, "DELETE FROM categories where category_id = $id;", false);
                        $result = useQuery($con, $mostUseQuery, true);
                        showCategorys($result, "");
                    } elseif (isset($_POST["addCategory"])) {
                        $valueToAdd = $_POST["add"];
                        useQuery($con, "INSERT INTO categories(category_name) VALUES ('$valueToAdd')", false);
                        $res  = useQuery($con, $mostUseQuery, TRUE);
                        showCategorys($res, "");
                    } elseif (isset($_POST["update"])) {
                        $newName = $_POST["newName"];
                        $id = $_POST["id"];
                        useQuery($con, "UPDATE categories SET category_name = '$newName' WHERE category_id = $id", false);
                        $res = useQuery($con, $mostUseQuery, true);
                        showCategorys($res, "");
                    }
                } else {
                    showCategorys($result, "");
                }
                ?>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
