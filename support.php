<?php
include_once("db_contect.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer; // use for sending emails 
// use PHPMailer\PHPMailer\SMTP;  // use for handling specific functinos
use PHPMailer\PHPMailer\Exception; // use for handling errors
require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user_page_style//support.css">
    <title>Support</title>
</head>
<body>
    <main>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["help"])) {
                $name = trim(htmlspecialchars($_POST["name"]));
                $last_name = trim(htmlspecialchars($_POST["last_name"]));
                $email = trim(htmlspecialchars($_POST["email"]));
                $search = $con->prepare("SELECT * FROM users WHERE first_name = ? AND last_name = ? AND email = ?");
                $search->execute([$name, $last_name, $email]);
                $user = $search->fetch(PDO::FETCH_ASSOC);
                if ($name == "" || $last_name == "" || $email == "") {
                    echo "<p>All fields are required</p>";
                } else {
                    if (!empty($user)) {
                        $keys = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", "*", "#"];
                        $_SESSION["user_id"] = $user["user_id"];
                        $_SESSION["user_name"] = $user["first_name"];
                        $_SESSION["user_last_name"] = $user["last_name"];
                        $_SESSION["user_email"] = $user["email"];
                        $temporery = "";
                        for ($i = 0; $i < 10; $i++) {
                            $index = mt_rand(0, count($keys) - 1);
                            $temporery .= $keys[$index];
                        }
                        $_SESSION["temporary"] = $temporery;
                        $mail = new PHPMailer(true); // this true or false is used for catching errors if it false and an error acurs its will fail sialntly wich is soo bad
                        try {
                            $mail->isSMTP();                                      // Set mailer to use SMTP
                            $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers like gmail yahoo and a lot more and you can use even your domain
                            $mail->SMTPAuth = true;                               // Enable SMTP authentication in other words if it true you have to gave Username and Password to send stuff if false you can just send it but most servers wont allow it for spam
                            $mail->Username = 'bitiljusgamer@gmail.com';           // SMTP username gmail that will be used to send
                            $mail->Password = 'vfdk xmuk wugk swbq';                    // SMTP password or app password you can create yourself in google and its not hard to use
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption this one is the best dont use the LLS with port of 465 there is aother port also but this one is the best
                            $mail->Port =  587;                                    // TCP port to connect to
                            //sender and resever
                            $mail->setFrom('bitiljusgamer@gmail.com', 'yahya'); // sender
                            $mail->addAddress($user["email"]);     // resever
                            // email content that will be send 
                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = 'Changing your password';
                            $mail->Body    = "temporary password : <h1>$temporery</h1>.";
                            $mail->AltBody = 'use this to confirm that you own this acount.';
                            // Send the email
                            $mail->send();
                            //stuff i can add 
                            //adding a file and changing its name by using addAttachment
                            // $mail->addAttachment('/path/to/file.pdf');  // Attach a file
                            // $mail->addAttachment('/path/to/image.jpg', 'newname.jpg'); // Rename attachment
                            // adding another email use case like you have to send a message to some that you reseved from someone else use this to show it to
                            // $mail->addCC('manager@example.com');
                            //same but its secure from others
                            // $mail->addBCC('bcc@example.com')

                            //adding an image and send it as will
                            // $mail->addEmbeddedImage('path/to/logo.png', 'logo_cid');
                            // $mail->Body = '<h1>Welcome!</h1><img src="cid:logo_cid">';


                            //this one is really importent if you send a email to some one and he tryed to replay you can change the deruction of that replay
                            // $mail->addReplyTo('support@example.com', 'Customer Support');
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                        header("Location: last_step.php");
                    } else {
                        echo "<p>No user was found with this information</p>";
                    }
                }
            }
        }
        ?>
        <h1>Support</h1>
        <p>enter your name and last name and your email to make send you the new password</p>
        <form method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="name">Last name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <input type="submit" name="help" value="Submit">
        </form>
    </main>
</body>

</html>