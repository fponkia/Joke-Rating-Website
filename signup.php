<?php

require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

$errors = array();
$firstName = "";
$lastName = "";
$username = "";
$password = "";
$cpassword = "";
$dob = "";
$email = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $firstName = test_input($_POST["fname"]);
    $lastName = test_input($_POST["lname"]);
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["pass"]);
    $dob = test_input($_POST["birth"]);
    $email = test_input($_POST["email"]);
    $cpassword = test_input($_POST["confirmpass"]);

    $nameRegex = "/^[a-zA-Z]+$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^[\w]+[^A-Za-z0-9 ]$/";
    $dobRegex = "/^\d{4}[-]\d{2}[-]\d{2}$/";
    $emailRegex = "/^[\w.-]+@[\w-]+\.[\w]{2,}$/";

    $dataOK = TRUE;

    if (!preg_match($nameRegex, $firstName)) {
        $errors["fname"] = "Invalid First Name";
        $dataOK = FALSE;
    }
    if (!preg_match($nameRegex, $lastName)) {
        $errors["lname"] = "Invalid Last Name";
        $dataOK = FALSE;
    }
    if (!preg_match($unameRegex, $username)) {
        $errors["username"] = "Invalid Username";
        $dataOK = FALSE;
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors["pass"] = "Invalid Password";
        $dataOK = FALSE;
    }
    if (!preg_match($dobRegex, $dob)) {
        $errors["birth"] = "Invalid DOB";
        $dataOK = FALSE;
    }
    if(!preg_match($emailRegex, $email)){
        $errors["email"] = "Invalid Email address";
        $dataOK = FALSE;
    }
    if($password != $cpassword){
        $errors["confirmpass"] = "Password does not match.";
        $dataOK = FALSE;
    }

    $target_file = "";
    if($dataOK){
        try{
            $db = new PDO($attr, $db_user, $db_pwd, $options);

            $query = "SELECT COUNT(*) FROM Users_Info WHERE username LIKE '$username'";
            $match = ($db ->query($query)) -> fetchColumn(0);
            
            if($match == 0){
                $query = "INSERT INTO Users_Info(username, first_name, last_name, email, dob, password, avatar)
                          VALUES('$username', '$firstName', '$lastName', '$email', '$dob', '$password', 'sample.jpg')";

                $result = $db->exec($query);

                if($result){
                    $target_dir = "uploads/";
                    $uploadOk = TRUE;

                    $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"],PATHINFO_EXTENSION));

                    $uid = $db -> lastInsertId();

                    $target_file = $target_dir.$uid.".".$imageFileType;

                    if(file_exists($target_file)){
                        $errors["avatar"] = "File already exists.";
                        $uploadOk = FALSE;
                    }

                    if($_FILES["profilephoto"]["size"] > 1000000){
                        $errors["avatar"] = "File size is greater than 1MB.";
                        $uploadOk = FALSE;
                    }

                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
                        $errors["avatar"] = "File type is not jpg, jpeg, png, or gif.";
                        $uploadOk = FALSE;
                    }

                    if($uploadOk){
                        $fileStatus = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
        
                        if(!($fileStatus)){
                            $errors["Server Error"] = "File was not moved to destination. There was an error while uploading.";

                            $query = "DELETE FROM Users_Info WHERE user_id = '$uid'";
                            $result = $db ->exec($query);
                            if (!$result) {
                                $errors["Database Error"] = "could not delete user when avatar upload failed";
                            }

                            $db = null;
                        }
                        else{
                            $query =  "UPDATE Users_Info SET avatar = '$target_file'
                                       WHERE user_id = '$uid'";
                            $result = $db -> exec($query);
                            if (!$result) {
                                $errors["Database Error:"] = "could not update avatar_url";
                            } else {
                                $db = null;
                                $query = null;
                                $result = null;
                                header("Location:login.php");
                                exit();
                            }
                        }
                    }
                    
                }
                else{
                    $errors["Database Error:"] = "Failed to insert user";
                }

            }
            else {
                // The email address was found in the Users table 
                $errors["Account Taken"] = "A user with that username already exists.";
            }
        }
        
        catch(PDOException $e){
            throw new Exception($e -> getMessage(), (int)$e -> getCode());
            
        }
    }
    
    if(empty($errors)) {
    } else {
        foreach($errors as $error)
        {
            echo $error . "\n<br />";
        }
    }

}
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>Sign-Up page</title>
        <link rel = "stylesheet" type = "text/css" href = "css/style.css"/>

        <meta charset="utf-8" name = "author" content = "Foram_Patel"></meta>
    </head>

    <body>
        <h1 class = "header">Joke Rating Site Sign-Up Page</h1>

        <div class = "signup">
            <aside>
                <img src = "images/Laugh.png" alt = "Laughing emoticon logo"/>
            </aside>

            <section class = "form1">
                <p class = "info">Please Provide the details for the following information to Create an Account.</p>
                <p class = "info"><strong>Required Fields are marked up with (*).</strong></p>
                
                <form action = "" method="post" id = "signup_form" enctype="multipart/form-data">
                    <p>
                        <label for = "fname">First name*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "fname" type = "text" placeholder="" />
                        <p name = "fname_error"></p>
                    </p>
                    <p>
                        <label for = "lname">Last name*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "lname" type = "text" placeholder="" />
                        <p name = "lname_error"></p>
                    </p>
                    <p>
                        <label for = "email">Email Address*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "email" type = "text" placeholder="abc@example.com" />
                        <p name = "email_error"></p>
                    </p>

                    <p>
                        <label for = "username">Usename*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "username" type = "text" placeholder="abc" />
                        <p name = "username_error"></p>
                    </p>

                    <p>
                        <label for = "birth">Date of Birth*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "birth" type = "date" />
                        <p name = "birth_error"></p>
                    </p>

                    <p>
                        <label for = "pass">Password*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "pass" type = "password" placeholder="" />
                        <p name = "pass_error"></p>
                    </p>

                    <p>
                        <label for = "confirmpass">Confirm Password*&nbsp;</label>
                        <input name = "confirmpass" type = "password" placeholder="" />
                        <p name = "confirmpass_error"></p>
                    </p>

                    <p>
                        <label for = "avatar">User Avatar*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input name = "avatar" type = "file" accept="image/*" />
                        <p name = "avatar_error"></p>
                    </p>

                    <p>
                        <button name = "sign" type ="submit" value = "Sign-Up_and_Proceed_to_Login_Page">Sign-Up and Proceed to Login Page</button>
                    </p>

                    <p>Click <a name = "back" href = "homepage.php">here</a> to go back to homepage and cancel the sign-up.</p>

                </form>
                <p class = "bottom">This message cant be seen</p>
                <p class = "bottom">This message cant be seen</p>
            </section>
        </div>

        <footer>
            <p>CS 215 * Assignments</p>
        </footer>

        <script src  = "js/validation.js"></script>
        <script src = "js/eventRegistrationSignUp.js"></script>
    </body>
</html>