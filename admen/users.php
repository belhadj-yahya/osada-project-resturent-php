<?php
include("../db_contect.php");
$all_users_info_query = "SELECT user_id, first_name, last_name, email,phone_number FROM users";
$main_array_of_users = useQeury($con, $all_users_info_query, true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/users.css">
    <title>Document</title>
</head>

<body>
    <?php include("nav.php") ?>
    <main>

        <table class="users_table_body">
            <thead>
                <th>User ID</th>
                <th>User full name</th>
                <th>Email</th>
                <th>Phone number</th>
                <th>Settings</th>
            </thead>
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["change"])) {
                    $check = true;
                    $user_new_phone = htmlspecialchars($_POST["phone_number"]);
                    $match = "/\d{3}-\d{3}-\d{4}/";
                    $user_new_phone = preg_match($match, $user_new_phone) ? $user_new_phone : null;
                    $user_new_name = trim(strtolower(htmlspecialchars($_POST["name"])));
                    $user_new_last_name = trim(strtolower(htmlspecialchars($_POST["last_name"])));;
                    $user_new_email = trim(htmlspecialchars($_POST["email"]));
                    $user_id = $_POST['id'];
                    foreach ($main_array_of_users as $user) {
                        if ($_POST["original_email"] == $user_new_email) {
                            if ($user_new_name == "" || $user_new_last_name == "" || $user_new_phone == null) {
                                $check = false;
                                break;
                            }
                        } elseif ($user_new_email === $user["email"]) {
                            echo "<p class='error'>This gmail/email is allready ticken</p>" . "<br>";
                            $check = false;
                            break;
                        }
                        if ($_POST["original_phone"] == $user_new_phone) {
                            if ($user_new_name == "" || $user_new_last_name == "" || $user_new_phone == null) {
                                $check = false;
                                break;
                            }
                        } elseif ($user_new_phone == $user["phone_number"]) {
                            $check = false;
                            break;
                        }
                    }
                    if ($check) {
                        useQeury($con, "UPDATE users set first_name = '$user_new_name', last_name = '$user_new_last_name', email = '$user_new_email', phone_number = '$user_new_phone' where user_id = $user_id", false);
                        $list = useQeury($con, $all_users_info_query, true);
                        showTable($list);
                    } else {
                        echo "we didnt enter check = true";
                    }
                } elseif (isset($_POST["delete_it"])) {
                    $user_id = $_POST["user_id"];
                    useQeury($con, "DELETE FROM users WHERE user_id = $user_id", false);
                    $list = useQeury($con, $all_users_info_query, true);
                    showTable($list);
                }
            } else {
                showTable($main_array_of_users);
            }

            ?>

        </table>
    </main>
    <script src="scripts/script.js"></script>
</body>

</html>


<?php
function useQeury($con, $query, $status)
{
    if ($status) {
        $result = $con->query($query);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } else {
        $con->exec($query);
    }
}
function showTable($array)
{
    foreach ($array as $user) {
        $user_id = $user["user_id"];
        $user_name = $user["first_name"];
        $user_last_name = $user["last_name"];
        $user_email = $user["email"];
        $phone_number = $user["phone_number"];
        echo <<<HTML
        <tr>
        <td>{$user["user_id"]}</td>
        <td>{$user["first_name"]} {$user["last_name"]}</td>
        <td>{$user["email"]}</td>
        <td>{$user["phone_number"]}</td>
        <td>
           <button class="change">Change</button>
            <dialog class="change_user_dialog">
                <div>
                    <h2>change user information</h2>
                    <form method="POST">
                        <input type="hidden" name="id" value="{$user['user_id']}">
                        <input type="hidden" name="original_email" value="{$user['email']}">
                        <input type="hidden" name="original_phone" value="{$user['phone_number']}">
                        <input type="text" value="{$user['first_name']}" name="name" placeholder="enter new name" required>
                        <input type="text" value="{$user['last_name']}" name="last_name" placeholder="enter new last name" required>
                        <input type="email" value="{$user['email']}" name="email" placeholder="enter your email" required>
                        <input type="text" value="{$user['phone_number']}" name="phone_number" placeholder="enter your phone number" required>
                        <input type="submit" name="change" value="Add">
                    </form>
                    <button class="dont_change_it">Cancel</button>
                </div>
            </dialog>
            <button class="delete">Delete</button>
            <dialog class="delete_user_dialog">
                    <div>
                        <h2>are you sure you want to delete this user</h2>
                        <form  method="post">
                                <input type="hidden" name="user_id" value="{$user['user_id']}">
                                <input type="submit" name="delete_it" value="DELETE">
                        </form>
                                <button class="dont-delete_it">CANCEL</button>
                    </div>
            </dialog>

        </td>
        </tr>
        HTML;
    }
}
?>