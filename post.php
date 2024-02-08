<?php

session_start();

require_once("db.php");

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = array();
$title = "";
$text = "";

// Check whether the user has logged in or not.
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
else
{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $title = test_input($_POST["title"]);
        $text = test_input($_POST["textarea"]);

        $title_Regex = "/^[\w., ]{1,50}$/";
        $textarea_Regex = "/^.{1,}$/";

        $dataOK = TRUE;

        if(!preg_match($title_Regex, $title)){
            $errors[]="Invalid title length";
            $dataOK = FALSE;
        }
        if(!preg_match($textarea_Regex, $text)){
            $errors[] = "Invalid textarea length";
            $dataOK = FALSE;
        }
        

        if($dataOK){
            try{
                $db = new PDO($attr, $db_user, $db_pwd, $options);

                $uid = $_SESSION["user_id"];
                //$uid = 1;

                $query = "INSERT INTO Joke_Posts (user_id, title, text, dateTime)
                        VALUES('$uid', '$title', '$text', NOW())";

                $result = $db -> exec($query);

                if(!$result){
                    $errors["SERVER ERRORS"] = "Error while inserting the joke to database server";
                }

                $db = null;
                $query = null;
                $result = null;

                header("Location: homepage1.php");
                exit();
            }
            catch(PDOException $e){
                throw new Exception($e -> getMessage(), (int)$e -> getCode());
            }
        }
        else{
            foreach($errors as $error){
                print($error . "\n<br />");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Joke Posting Page</title>
        <link rel = "stylesheet" type = "text/css" href = "css/style.css" />

        <meta charset="utf-8" name = "author" content = "Foram_Patel"></meta>
    </head>

    <body>
        <div id = "header">
            <h1>Joke Rating Site Posting Page</h1>
        </div>

        <div id = "logout">
            <p id = "username1"><u><?=$_SESSION["username"]?></u></p>
            <a href = "logout.php">Log Out</a>
        </div>

        <div class = "postdiv">
            <aside>
                <img src = "images/Laugh.png" alt = "Laughing emoticon"/>
            </aside>
            <section id = "post">
                <form action = "" method = "post" id = "post_form">
                    <p>Please Enter the title and content of the joke to post. <br />
                    All the Required Fields are marked with (*).</p>
                        
                        <label for = "title">Title of the Joke:*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "title" type = "text" /> <br />
                        <p name = "character_count"></p>
                        <p name = "title_error"></p>

                        <label for = "textarea">Write your Joke overhere:*</label>
                        <textarea name = "textarea" rows="10" cols="20"></textarea>
                        <p name = "textarea_error"></p>
                    
                    <button type = "submit" name = "Postbutton" value = "PosttheJoke">Post the Joke</button>
                </form>

                <p class = "bottom">This cant be seen</p>
                <p class = "bottom">This cant be seen</p>
            </section>
        </div>

        <footer>
            <p>CS 215 * Assignments</p>
        </footer>

        <script src="js/validation.js"></script>
        <script src="js/eventRegistrationPost.js"></script>
    </body>
</html>