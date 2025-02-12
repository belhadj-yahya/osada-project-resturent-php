<?php
 include("db_contect.php");
  $sql = "SELECT  categories.category_id, categories.category_name, COUNT(dishes.category_id) AS dishes FROM categories right JOIN dishes ON categories.category_id = dishes.category_id GROUP BY dishes.category_id;";
  $result = $con->query($sql); 
  $result = $result->fetchAll(PDO::FETCH_ASSOC);
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
        <div id="dash"></div>
        <div id="categories">
            <form method="POST">
                <input type="text" name="categorey" id="">
                <input type="submit" value="search" name="findcat">
                <input type="text" name="add" id="">
                <input type="submit" value="add Category" name="addCategory">
            </form>
                <div class="category">
                    <?php
                    function showCategorys($result,$niddel){
                        echo "array show start here ";
                        echo "<pre>";
                            print_r($result);
                            echo "</pre>";
                        foreach($result as $catigory){ 
                            $name = $catigory["category_id"]; 
                              if(str_contains(trim(strtolower($catigory["category_name"])), trim(strtolower($niddel)))){
                                echo "<div class='item'>";
                                   echo  "<p>"."category: " . $catigory["category_name"] ."</p>"; 
                                   echo  "<p>"."Dishes: " . $catigory["dishes"] ."</p>";
                                   echo "<div class='settings'>";
                                      echo "<button class='remove'>DELETE</button>"; 
                                      echo  "<button>MODIFY</button>";
                                   echo "</div>";
                                echo "</div>";
                                echo "<dialog class='deleteDailog'>";
                                   echo "<p>are you sure you want to delete </p>";
                                   echo "<form method='POST'>";
                                   echo "<input type='hidden' name='did' value='$name'>";
                                   echo "<input type='submit' name='delete' value='sure'>";
                                   echo "</form>";
                                   echo "<button class='close'>stop</button>";
                                echo "</dialog>";
                              }
                          }
                    }
                      
                      if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if(isset($_POST["findcat"])){
                            showCategorys($result,$_POST["categorey"]);
                        }elseif(isset($_POST["delete"])){
                            echo "we are here baby" . "<br>";
                            $id = $_POST["did"];
                            $sql = "DELETE FROM categories where category_id = $id";
                            $result = $con->query($sql); 
                            $result = $result->fetchAll(PDO::FETCH_ASSOC);
                            showCategorys($result,"");
                        }elseif(isset($_POST["addCategory"])){
                            $valueToAdd = $_POST["add"];
                            $sql = "INSERT INTO categories(category_name) VALUES ('$valueToAdd')";
                            $result = $con->query($sql); 
                            $sql = "SELECT  categories.category_id, categories.category_name, COUNT(dishes.category_id) AS dishes FROM categories  JOIN dishes ON categories.category_id = dishes.category_id GROUP BY dishes.category_id";
                            $result = $con->query($sql); 
                            $res  = $result->fetchAll(PDO::FETCH_ASSOC);
                            showCategorys($res,"");
                            echo "before we see the array" . "<br>";

                        }
                    }else{
                        showCategorys($result,"");
                    }
                    ?>
                </div>
            
        </div>
        <div id="dishes"></div>
        <div id="orders"></div>
    </div>
 <script src="script.js"></script>
</body>
</html>