<?php
include("../db_contect.php");
$mainSql = "SELECT dishes.dish_id, dishes.dish_name, dishes.dish_price, categories.category_name from dishes inner join categories on dishes.category_id = categories.category_id GROUP BY dish_id";
$optionsSql = "SELECT * FROM categories";
//getting array for both dishes that will be shown and categories that will be used whene adding or modifying
$mainList = apllayQuery($con, $mainSql, true);
$optionsList = apllayQuery($con, $optionsSql, true);
//they both working
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/dish_style.css">
    <title>Document</title>
</head>

<body>
    <?php include("nav.php") ?>
    <main>
        <div class="search_and_add">
            <form method="POST">
                <input type="text" name="search_bar" id="" placeholder="find">
                <input type="submit" name="find" value="search">
            </form>
            <button class="add">Add Dish</button>
        </div>
        <dialog class="add_new_dish">
            <div>
                <h2>Add new dish</h2>
                <form method="POST" enctype="multipart/form-data">
                    <label for="img">new dish image</label>
                    <input type="file" name="img" id="" accept="image/*">
                    <label for="dish_name">new dish name:</label>
                    <input type="text" name="dish_name" placeholder="Dish Name">
                    <label for="dish_price">new dish price:</label>
                    <input type="text" name="dish_price" placeholder="Dish Price">
                    <label for="category_id">new dish category</label>
                    <select name="category_id">
                        <?php
                        foreach ($optionsList as $option) {
                            echo "<option value='" . $option["category_id"] . "'>" . $option["category_name"] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="add_dish" name="add_dish">
                </form>
                <button class="hide_add_dish">Back</button>
            </div>

        </dialog>
        <div class="dishes">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["find"])) {
                    $search = $_POST["search_bar"];
                    showDishes($mainList, $search, $optionsList);
                } elseif (isset($_POST["delete_this_dish"])) {
                    $id = $_POST["did"];
                    apllayQuery($con, "DELETE FROM dishes WHERE dish_id = $id", false);
                    $mainList = apllayQuery($con, $mainSql, true);
                    showDishes($mainList, "", $optionsList);
                } elseif (isset($_POST["add_dish"])) {
                    $name = trim(strtolower(htmlspecialchars($_POST["dish_name"])));
                    $price = htmlspecialchars($_POST["dish_price"]);
                    $check_name = true;
                    $check_price = true;
                    $categoryId = $_POST["category_id"];
                    foreach ($mainList as $dish) {
                        if (trim(strtolower($dish["dish_name"])) == $name || $name === "") {
                            $check_name = false;
                            break;
                        } elseif ($price <= 0 || $price == "") {
                            $check_price = false;
                            break;
                        }
                    }
                    $fileName = $_FILES['img']['name'];
                    $destination = "C:\\xampp\\htdocs\\resturent\\food_images\\" . $fileName;
                   
                    if(!move_uploaded_file($_FILES['img']['tmp_name'],$destination)){
                        echo "<p class=''dish_error>file is not uploaded</p>";
                    }else{
                        echo "hello yahya";
                        $right_destination = "../food_images/" . $fileName;
                        if ($check_name && $check_price) {
                            apllayQuery($con, "INSERT INTO dishes(dish_name, dish_price, category_id,dish_img) VALUES ('$name', $price, $categoryId,'$right_destination')", false);
                            $mainList = apllayQuery($con, $mainSql, true);
                            showDishes($mainList, "", $optionsList);
                        } elseif ($check_name == false) {
                            echo "<p class='dish_error'>" . "Dish name allready exist or it's empty enter valid information!" . "</p>";
                            showDishes($mainList, "", $optionsList);
                        } elseif ($check_price == false) {
                            echo "<p class='dish_error'>" . "enter a valid price!" . "</p>";
                            showDishes($mainList, "", $optionsList);
                        }
                    }
                
                    
                } elseif (isset($_POST["send_changes"])) {
                    $new_dish_name = trim(strtolower(htmlspecialchars($_POST["new_dish_name"])));
                    $new_dish_price = trim(strtolower(htmlspecialchars($_POST["new_dish_price"])));
                    $new_dish_categoryId = $_POST["new_category_id"];
                    $check_new_name = true;
                    $check_new_price = true;
                    $id = $_POST["dish_id"];
                    foreach ($mainList as $dish) {
                        if (trim(strtolower($dish["dish_name"])) == $new_dish_name || $new_dish_name === "") {
                            $check_new_name = false;
                            break;
                        } elseif ($new_dish_price <= 0 || $new_dish_price == "") {
                            $check_new_price = false;
                            break;
                        }
                    }
                    $dish_new_name = $_FILES['new_img']['name'];
                    $destination = "C:\\xampp\\htdocs\\resturent\\food_images\\" . $dish_new_name;
                    if(!move_uploaded_file($_FILES['new_img']['tmp_name'],$destination)){
                        echo "<p class='new_dish_error'>there is a problem in the uploaded img</p>";
                    }else{
                        $right_destination = "../food_images/" . $dish_new_name;
                        if ($check_new_name && $check_new_price) {
                             apllayQuery($con, "UPDATE dishes SET dish_name = '$new_dish_name', dish_price = $new_dish_price, category_id = $new_dish_categoryId, dish_img = '$right_destination' where dish_id = $id", false);
                             $mainList = apllayQuery($con, $mainSql, true);
                             showDishes($mainList, "", $optionsList);
                            echo "we will stop here to see how this will work";
                        } elseif ($check_new_name == false) {
                            echo "<p class='new_dish_error'>" . "Dish name allready exist or dish new name is empty please enter valid information!" . "</p>";
                            showDishes($mainList, "", $optionsList);
                        } elseif ($check_new_price == false) {
                            echo "<p class='new_dish_error'>" . "you cant enter 0 or negateve numbers please enter valid information!" . "</p>";
                            showDishes($mainList, "", $optionsList);
                        }
                    }
                    
                }
            } else {
                showDishes($mainList, "", $optionsList);
            }
            ?>
        </div>

    </main>
    <script src="../scripts/script.js"></script>
</body>

</html>
<?php
// a function that ether use query without returning nothing like update and delete and insert or to return an array like select 
function apllayQuery($con, $query, $state)
{
    if ($state) {
        $result = $con->query($query);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } else {
        $con->exec($query);
    }
}
//array that displays results of an array and ticks 3 arguments $array  the array that we will use $niddel what we are looking for in search bar $categorys categorys to display 
function showDishes($array, $niddel, $categorys)
{
    foreach ($array as $dish) {
        if (str_contains(trim(strtolower($dish["dish_name"])), trim(strtolower($niddel)))) {

            echo <<<HTML
            <div class="dishe">
                    <p>Dish: {$dish["dish_name"]}</p>
                    <p>Dish Price: {$dish["dish_price"]}$</p>
                    <p>Dish Category:  {$dish["category_name"]}</p>
                    <div class="settings">
                        <button class="delete">DELETE</button>
                        <button class="modify">MODIFY</button>
                    </div>
            </div>
            <dialog class="deleteDailog">
                <div>
                <h2>Are you sure you want to delete?</h2>
                <form action="" method="post">
                <input type="hidden" name="did" value="{$dish['dish_id']}">
                <input type="submit" value="YES" name="delete_this_dish">
                </form>
                <button class="cancel-delete">NO</button>
                </div>
            </dialog>
            <dialog class="modifyDailog">
                <div>
                    <h2>Modify Dish</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="dish_id" value="{$dish['dish_id']}">
                    <label for="new_img">new dish img</label>
                    <input type="file" name="new_img" id="" accept="image/*">
                    <label for="new_dish_name">New dish name : </label>
                    <input type="text" name="new_dish_name" id="">
                    <label for="new_dish_price">New dish price : </label>
                    <input type="text" name="new_dish_price" id="">
                    <label for="new_category_id">New dish category :</label>
                    <select name="new_category_id" id="">
            HTML;
            foreach ($categorys as $category) {
                echo "<option value='" . $category["category_id"] . "'>" . $category["category_name"] . "</option>";
            }
            echo <<<HTML
                 </select>
                 <input type="submit" name="send_changes" value="aplly">
                 </form>
                 <button class="cancel_modify">CANCEL</button>
                 </div>
                 </dialog>
             HTML;
        }
    }
}

?>