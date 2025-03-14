<?php
include("db_contect.php");
session_start();
$check = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user_page_style//last_step.css">
    <title>last_step</title>
</head>

<body>
    <main>
        <H1>Enter the password that was send to you in your Email</H1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["temporary"])) {
                $temporary_password = $_SESSION["temporary"];
                $user_temporary_password = htmlspecialchars($_POST["temporary_password"]);
                if ($temporary_password == $user_temporary_password) {
                    $check = true;
                } else {
                    echo "Passwords do not match!";
                }
            } elseif (isset($_POST["change_password"])) {
                $new_password = htmlspecialchars($_POST["new_password"]);
                $confirm_password = htmlspecialchars($_POST["confirm_password"]);
                if ($new_password == $confirm_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_password = $con->prepare("UPDATE users SET password = '$hashed_password' WHERE user_id = ? AND first_name = ? AND last_name = ? AND email = ?");
                    $update_password->execute([$_SESSION["user_id"], $_SESSION["user_name"], $_SESSION["user_last_name"], $_SESSION["user_email"]]);
                    setcookie("email", $_SESSION["user_email"], strtotime("+1 year"));
                    setcookie("password", $new_password, strtotime("+1 year"));
                    header("Location: log_in.php");
                    exit();
                }
            }
        }
        ?>
        <?php if ($check == false) { ?>
            <form method="post">
                <div>
                    <label for="temporary">Enter Password:</label>
                    <input type="text" name="temporary_password" id="">
                </div>
                <input type="submit" name="temporary" value="Submit">
            </form>
        <?php } ?>
        <?php if ($check == true) { ?>
            <form action="" method="post">
                <div>
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" id="">
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="">
                </div>
                <input type="submit" name="change_password" value="Change Password">
            </form>
        <?php } ?>
    </main>
</body>

</html>