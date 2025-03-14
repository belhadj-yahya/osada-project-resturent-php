<?php
include("db_contect.php");
session_start();

if (isset($_COOKIE["admen_email"]) && isset($_COOKIE["admen_password"])) {
    header("location: admen/index.php");
    exit();
}

if (isset($_COOKIE["email"]) && isset($_COOKIE["password"])) {
    $sql = "SELECT * from users where email ='" . $_COOKIE["email"] . "'";
    $user = $con->query($sql);
    $user = $user->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["user_id"] = $user[0]["user_id"];
    $_SESSION["user_name"] = $user[0]["first_name"];
    $_SESSION["user_last_name"] = $user[0]["last_name"];
    header("location: user/this_will_be_main.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user_page_style/log_in.css">
    <title>log in</title>
</head>

<body>
    <main class="log_in">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["login"])) {
                $email = trim(htmlentities($_POST["email"]));
                $password = trim(htmlentities($_POST["password"]));
                if ($password != "" && $email != "") {
                    $get_admen = $con->prepare("SELECT * FROM admen_gmail WHERE admen_gmail = ?");
                    $get_admen->execute([$email]);
                    $admen = $get_admen->fetch(PDO::FETCH_ASSOC);
                    if (!empty($admen)) {
                        if (password_verify($password, $admen["admen_password"])) {
                            $_SESSION["admin_id"] = $admen["admin_id"];
                            $_SESSION["admin_name"] = $admen["first_name"];
                            $_SESSION["admin_last_name"] = $admen["last_name"];
                            setcookie("admen_email", $email, strtotime("+1 year"), "/resturent");
                            setcookie("admen_password", $password, strtotime("+1 year"), "/resturent");
                            header("location: admen/index.php");
                        }
                    }
                    $message = true;
                    $get_user = $con->prepare("SELECT * FROM users WHERE email = ?");
                    $get_user->execute([$email]);
                    $user = $get_user->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($user)) {
                        if (password_verify($password, $user[0]["password"])) {
                            $_SESSION["user_id"] = $user[0]["user_id"];
                            $_SESSION["user_name"] = $user[0]["first_name"];
                            $_SESSION["user_last_name"] = $user[0]["last_name"];
                            setcookie("email", $email, strtotime("+1 year"),"/resturent");
                            setcookie("password", $password, strtotime("+1 year"), "/resturent");
                            header("location: user/this_will_be_main.php");
                            $message = false;
                        }
                    }
                    if ($message) {
                        echo "<p class='error'>no user with this information was found</p>";
                    }
                } else {
                    echo "<p class='error'>invalid email or password number</p>";
                }
            }
        }
        ?>
        <h1>Log in</h1>
        <form method="post">
            <div>
                <label for="email">Email: </label>
                <input type="email" name="email" placeholder="enter your email" required>
            </div>
            <div>
                <label for="password">Password: </label>
                <input type="password" name="password" placeholder="enter your password" required>
            </div>
            <div>

            </div>
            <div class="settings">
                <label for="see">show password</label>
                <input type="checkbox" name="see" id="show_password">
            </div>
            <input type="submit" name="login" value="Login">
        </form>
        <div class="help">
            <p>dont have an acount? <a href="sign_in.php">Sign in</a></p>
            <p>Forgote your password? <a href="support.php">support</a></p>
        </div>

    </main>
    <script src="user_scripts/script.js"></script>
</body>

</html>