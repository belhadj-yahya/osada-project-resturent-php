<?php
include("db_contect.php");

/*
passwords 
1 : john
2 : Jane
3 : Bob
4 : Alice
5 : Charlie
THIS REST FROM HERE ARE IN THE HOME PC DONT FORGET THAT YAHYA
6 :
*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main_page.css">
    <link rel="stylesheet" href="styles/footer.css">
    <title>shope</title>
</head>

<body>
    <?php include("user_nav.php")?>
    <main>
        <h1 class="h1">Welcome to foodYA — Where Delicious Food Meets Perfect Moments!</h1>
        <section class="part1">
            <img src="user_images/imag_1.svg" class="img1" alt="">
            <div class="wrap1">
                <h1>Delicious Food, Delivered to You</h1>
                <p>Enjoy delicious food from your favorite restaurants, right at your doorstep. Fresh, fast, and always satisfying.</p>
            </div>
        </section>
        <h1 class="first_h1">Why Wait? Bring the Best to Your Table Today!</h1>
        <p class="first_p">From fresh ingredients to mouthwatering dishes, our food delivery service is designed to make your life easier and more delicious. Whether you're craving pizza, sushi, or burgers, we’ve got you covered. Order now and taste the difference!</p>
        <section class="part2">
            <img src="user_images/imag_2.svg" class="img2" alt="get it now">
            <div class="images">
                <img src="food_images/burger.webp" alt="">
                <img src="food_images/cake.jpg" alt="">
                <img src="food_images/cocktail.jpg" alt="">
                <img src="food_images/makarona.jpg" alt="">
                <img src="food_images/pizza.jpg" alt="">
                <img src="food_images/sushi2.jpg" alt="">
            </div>
        </section>
        <section class="part3">
            <div class="wrap2">
                <h1>Fresh Ingredients, Tasty Results</h1>
                <p>We use only the finest, fresh ingredients to bring you flavorful, healthy meals. Every dish is crafted with care to ensure you get the best taste and quality. Because good food starts with great ingredients!</p>
            </div>
            <img src="user_images/imag_4.svg" class="img3" alt="">
        </section>
    </main>
    <?php include("footer copy.php") ?>

</body>

</html>