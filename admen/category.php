<?php
include("../db_contect.php");
// mail("yahya.belhadj.pro@fmail.com","test","this is working");

$mostUseQuery = "SELECT  categories.category_id, categories.category_name, COUNT(dishes.category_id) AS dishes FROM categories LEFT JOIN dishes ON categories.category_id = dishes.category_id GROUP BY  categories.category_id, categories.category_name ORDER BY dishes DESC";
$result = useQuery($con, $mostUseQuery, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/category.css">
    <title>Document</title>
</head>

<body>
    <?php include("nav.php") ?>
    <div id="categories">
        <div class="forms">
            <form method="POST" class="firstForm">
                <div class="form1">
                    <input type="text" name="categorey" id="">
                    <input type="submit" value="search" name="findcat">
                </div>
            </form>
            <form method="post">
                <div class="form2">
                    <input type="text" name="add" id="">
                    <input type="submit" name="more" value="add category">
                </div>
            </form>
        </div>
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
            foreach ($result as $catigory) {
                $id = $catigory["category_id"];
                if (str_contains(trim(strtolower($catigory["category_name"])), trim(strtolower($niddel)))) {
                    $output = <<<HTML
                            <div class='item'>
                                <p>category: {$catigory["category_name"]}</p>
                                <p>Dishes: {$catigory["dishes"]}</p>
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
            } elseif (isset($_POST["more"])) {
                $valueToAdd = strtolower(trim(htmlspecialchars($_POST["add"])));
                $check = true;
                foreach ($result as $category) {
                    if (strtolower(trim(htmlspecialchars($category["category_name"]))) == $valueToAdd || $valueToAdd == "") {
                        $check = false;
                        break;
                    }
                }
                if ($check) {
                    useQuery($con, "INSERT INTO categories(category_name) VALUES ('$valueToAdd')", false);
                    $res  = useQuery($con, $mostUseQuery, TRUE);
                    showCategorys($res, "");
                } else {
                    echo "<p class='error'>" . "you have this category already or its not valid please enter valid information" . "</p>";
                    showCategorys($result, "");
                }
            } elseif (isset($_POST["update"])) {
                $newName = strtolower(trim(htmlspecialchars($_POST["newName"])));
                $id = $_POST["id"];
                $check_new_name = true;
                foreach ($result as $category) {
                    if (strtolower(trim(htmlspecialchars($category["category_name"]))) == $newName || $newName == "") {
                        $check_new_name = false;
                        break;
                    }
                }
                if ($check_new_name) {
                    echo "heres the query will work";
                    useQuery($con, "UPDATE categories SET category_name = '$newName' WHERE category_id = $id", false);
                    $res = useQuery($con, $mostUseQuery, true);
                    showCategorys($res, "");
                } else {
                    echo "<p class='error'>" . "this category name allready ticken or its not valid please enter valid information" . "</p>";
                    showCategorys($result, "");
                }
            }
        } else {
            showCategorys($result, "");
        }
        ?>
    </div>

    <script src="../scripts/script.js"></script>
</body>

</html>