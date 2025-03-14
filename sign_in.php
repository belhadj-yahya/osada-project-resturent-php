<?php
include("db_contect.php");
session_start();
$users_query = "SELECT * FROM users";
$result = $con->query($users_query);
$result = $result->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user_page_style/sign_in.css">
    <title>Sign in</title>
</head>

<body>
    <main>
        <h1>Sign in</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["sign_in"])) {
                $check = true;
                $go_to_loop = true;
                $pattern = "/\d{3}-\d{3}-\d{4}/";
                $name = trim(htmlspecialchars($_POST["first_name"]));
                $last_name = trim(htmlspecialchars($_POST["last_name"]));
                $city = trim(htmlspecialchars($_POST["city"]));
                $street = trim(htmlspecialchars($_POST["street"]));
                $postal_code = trim(htmlspecialchars($_POST["postel_code"]));
                $phone_number = trim(htmlspecialchars($_POST["phone_number"]));
                $email = trim(htmlspecialchars($_POST["email"]));
                $password = trim(htmlspecialchars($_POST["password"]));
                $check_password = trim(htmlspecialchars($_POST["check_password"]));
                if ($name != "" && $last_name != "" && $city != "" && $street != "" && $postal_code != "" && $email != "" && $password != "" && $check_password != "" && preg_match($pattern, $phone_number)) {
                    if ($password !== $check_password) {
                        echo "<p class='error'>the passwordes does not match</p>";
                        $check = false;
                        $go_to_loop = false;
                    }
                    if ($go_to_loop) {
                        foreach ($result as $user) {
                            if ($email == $user["email"]) {
                                echo "<p class='error'>This email is allready ticken</p>";
                                $check = false;
                                break;
                            }
                        }
                    }
                    if ($check) {
                        echo "we entred the if check";
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $con->prepare("INSERT INTO users(first_name,last_name,email,password,phone_number) values(?,?,?,?,?)");
                        $stmt->execute([$name, $last_name, $email, $password, $phone_number]);
                        $get_user = $con->prepare("SELECT * FROM users WHERE email = ?");
                        $get_user->execute([$email]);
                        $user = $get_user->fetch(PDO::FETCH_ASSOC);
                        $_SESSION["user_id"] = $user["user_id"];
                        $_SESSION["user_name"] = $user["first_name"];
                        $_SESSION["user_last_name"] = $user["last_name"];
                        $stmt2 = $con->prepare("INSERT INTO addresses(street,city,postal_code,user_id) values(?,?,?,?)");
                        $stmt2->execute([$street, $city, $postal_code, $_SESSION["user_id"]]);
                        header("location: user/this_will_be_main.php");
                    }
                }
            }
        }
        ?>
        <form method="post" id="sign">
            <div>
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" required>
            </div>
            <div>
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" required>
            </div>
            <div class="why">
                <label for="city">City:</label>
                <input type="text" name="city" id="city">
            </div>
            <div>
                <label for="street">Street:</label>
                <input type="text" name="street" id="street" required>
            </div>
            <div>
                <label for="postel_code">Postal Code:</label>
                <input type="text" name="postel_code" id="postel_code" required>
            </div>
            <div>
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" placeholder="xxx-xxx-xxxx" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="password">varifai Password:</label>
                <input type="password" name="check_password" id="password" required>
            </div>
        </form>
        <form method="post">
            <input type="submit" form="sign" name="sign_in" value="sign in">
        </form>
        <p>Already have an account?<a href="log_in.php">Log in</a></p>
    </main>
</body>

</html>