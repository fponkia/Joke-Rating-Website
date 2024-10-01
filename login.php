<?php

require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}


// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $errors = array();
    $dataOK = TRUE;

    $email = test_input($_POST["email"]);
    $password = test_input($_POST["pass"]);

    $emailRegex = "/^[\w.-]+@[\w-]+\.[\w]{2,}$/";
    $passwordRegex = "/^[\w]+[^A-Za-z0-9 ]$/";

    if(!preg_match($emailRegex, $email)){
        $errors["Email"] = "Invalid email address";
        $dataOK = FALSE;
    }
    if(!preg_match($passwordRegex, $password)){
        $errors[] = "Invalid Passowrd";
        $dataOK = FALSE;
    }

    if($dataOK){
        try{
            $db = new PDO($attr, $db_user, $db_pwd, $options);

            $query = "SELECT first_name, last_name, user_id, email, dob, username, avatar FROM Users_Info WHERE email LIKE '$email' AND password LIKE '$password'";
            $result = $db -> query($query);

            if (!$result) {
                $errors["Database Error"] = "Could not retrieve user information";
            } elseif ($row = $result->fetch()) {

                session_start();

                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["last_name"] = $row["last_name"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["avatar"] = $row["avatar"];
                $_SESSION["dob"] = $row["dob"];

                $db = null;
                $query = null;
                $result = null;

                $_COOKIE("user_id", $row["user_id"], time() + 7200, "/");

                header("Location: homepage1.php");
                exit();

            }
            else{
                $errors["Login Failed"] = "That username/password combination does not exist.";
            }
        }
        catch(PDOException $e){
            throw new Exception($e -> getMessage(), (int)$e->getCode());
        }
    }
    if(!empty($errors)){
        foreach($errors as $message) {
            echo $message . "<br />\n";
        }
    }
}
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>Login Page</title>
        <link rel = "stylesheet" type = "text/css" href = "css/style.css" />

        <meta charset="utf-8" name = "author" content = "Foram_Patel"></meta>

    </head>

    <body>
        <h1 class = "header">Joke Rating Site Login Page</h1>
        <div class = "login">
            <aside>
                <img src="images/Laugh.png" alt = "Laughing emoticon logo" />
            </aside>

            <section class = "form1">
                <form id = "login_form" action = "" method="post">
                    <p class = "info">To login you need to provide the username and password.</p>
                    <p class = "info"><strong> Required fields are marked with (*).</strong></p>
                    
                    <p>
                        <label for = "email">Email Address*</label>
                        <input name = "email" type = "text" placeholder="ex. abc@example.com"></input>
                        <p name = "email_error"></p>
                    </p>

                    <p>
                        <label for = "pass">Password*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "pass" type ="password" placeholder=""></input>
                        <p name = "pass_error"></p>
                    </p>

                    <p>If you do not have the account. Please click <a href="signup.php">here</a> for Sign-up.</p>

                    <button type = "submit"> Login</button>
                </form>
            </section>
        </div>

        <footer>
            <p>CS 215 * Assignments</p>
        </footer>

        <script src="js/validation.js"></script>
        <script src = "js/eventRegistrationLogin.js"></script>
    </body>
</html>