<?php

session_start();

require_once("db.php");

$errors = array();
if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit();
}
else{
    try{
        $rate = 0;
        $uid = $_SESSION["user_id"];
        $joke_id = $_GET["joke_id"];
        $_SESSION["joke_id"] = $joke_id;

        $db = new PDO($attr, $db_user, $db_pwd, $options);
        $query = "SELECT COUNT(*) FROM User_Ratings WHERE user_id = '$uid' AND joke_id = '$joke_id'";
        $result = $db -> query($query);

        //if there is already an user who entered the joke first than result will be loaded otherwise creating a rating of 0 points for the given user.
        //it is being assumed that if the user does not rate the joke than he does not like it and has given the rating of 0.
        
        if($result -> fetchColumn(0)){
            $query = "SELECT rating FROM User_Ratings WHERE user_id = '$uid' AND joke_id = '$joke_id'";
            $result = $db -> query($query);

            $rate = $result -> fetchColumn(0);
        }
        else{
            $query = "INSERT INTO User_Ratings(user_id, joke_id, rating)
                      VALUES('$uid', '$joke_id', '$rate')";
            $result = $db -> exec($query);
    
            if(!$result){
                $errors["DATABASE ERROR"] = "Not able to insert the rating of the Joke given by the user";
            }
        }
        
        /*if($_SERVER["REQUEST_METHOD"] == "POST"){
            //if submit the rating button is clicked than rating of the given joke for the given user will be changed to the new one.
            $rate = $_POST["ratingjoke"];
    
                $query = "SELECT COUNT(*) FROM User_Ratings WHERE user_id = '$uid' AND joke_id = '$joke_id'";
                $result = $db -> query($query);
        
                if($result -> fetchColumn(0)){
                    $query = "UPDATE User_Ratings SET rating = '$rate' WHERE user_id = '$uid' AND joke_id = '$joke_id'";
                    $result = $db -> exec($query);
    
                    if(!$result){
                        $errors["DATABASE ERROR"] = "Not able to update the rating of the Joke given by the user";
                    }
                }
                else{
                    $query = "INSERT INTO User_Ratings(user_id, joke_id, rating)
                              VALUES('$uid', '$joke_id', '$rate')";
                    $result = $db -> exec($query);
    
                    if(!$result){
                        $errors["DATABASE ERROR"] = "Not able to insert the rating of the Joke given by the user";
                    }
                }
    
                $db = null;
                $query = null;
                $result = null;
        }*/
    }
    catch(PDOException $e){
        throw new Exception($e->getMessage(), (int)$e->getCode());
    }
}
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>Joke Detail Page</title>
        <link rel = "stylesheet" type = "text/css" href="css/style.css"></link>
        <meta charset="utf-8" name="author" content="Foram_Patel"/>
    </head>

    <body>
        <div id = "detailpagehead">
            <section>
                <img id = "headimage" src="images/Laugh.png" alt = "Laughing emoticon logo" />
                <h1>Joke Detail Page</h1>
            </section>

<?php
try{
    $db = new PDO($attr, $db_user, $db_pwd, $options);

    $query = "SELECT Joke_Posts.joke_id, Joke_Posts.title, Joke_Posts.text, Joke_Posts.dateTime, Users_Info.username, Users_Info.first_name, Users_Info.last_name, Users_Info.avatar, Users_Info.dob, AVG(User_Ratings.rating)AS Average_Rating FROM Joke_Posts 
              LEFT JOIN User_Ratings ON (Joke_Posts.joke_id = User_Ratings.joke_id) 
              LEFT JOIN Users_Info ON (Joke_Posts.user_id = Users_Info.user_id) 
              WHERE Joke_Posts.joke_id = '$joke_id'
              GROUP BY Joke_Posts.joke_id 
              ORDER BY Joke_Posts.dateTime";
    
    $result = $db -> query($query);

    if(!$result){
        $errors["JOKE DETAIL ERROR"] = "There was an error while retrieving the joke details.";
    }
    $row = $result->fetch();
    $title = $row["title"];
    $text = $row["text"];
    $first_name = $row["first_name"];
    $last_name = $row["last_name"];
    $avatar = $row["avatar"];
    $username = $row["username"];
    $avg_rating = $row["Average_Rating"];
    $dob = $row["dob"];

    $db = null;
    $query = null;
    $result = null;
    $row = null;


}
catch(PDOException $e){
    throw new Exception($e -> getMessage(), (int)$e->getCode());
}
?>
            <aside id = "detailpageheadaside">
                <p id = "detailpageusername"><?=$_SESSION["username"]?></p>
                <a href = "logout.php" id = "logouthomepage">Log Out</a>
                <a href = "homepage1.php" id = "back_homepage">Back to Homepage</a>
            </aside>
        </div>

        <div id = "display">
            <div id = "image">
                <img id = "userimage" src = "<?=$avatar?>" alt = "user avatar" />
            </div>

            <div id = "userinfo">
                <p>Following is the information of the individual who has posted the joke.</p>
                <p><strong>Username:</strong><?=$username?></p>
                <p><strong>First Name:</strong><?=$first_name?></p>
                <p><strong>Last Name:</strong><?=$last_name?></p>
                <p><strong>Date of Birth:</strong><?=$dob?></p>
            </div>

            <div id = "jokedetail">
                <p>Full Joke is displayed below.</p>
                <p><?=$text?></p>
            </div>

            <div id = "rate">
                <p>Please rate the joke here:</p>
                <p id = "avgRating">Current Rating of this joke is: <?=$avg_rating?> </p>
                <form id = "rateform" action = "" method = "post">
                    <label name = "ratinglabel">Give the Rating:</label><br />
                    <button name = "decrease" type = "button">Decrease</button>
                    <input name = "ratingjoke" type = "number" min = "0" max = "5" value = "<?=$rate?>"/>
                    <button name = "increase" type = "button">Increase</button> <br />
                    <button type = "submit" name = "submitrating" value = "submit_the_rating">Submit the rating</button>
                </form>
            </div>
        </div>

        <footer>
            <p>CS 215 * Assignments</p>
        </footer>

        <script src="js/validation.js"></script>
        <script src="js/eventRegistrationDetailPage.js"></script>
    </body>
</html>