<?php

require_once("db.php");

$result;
$first_joke_id;
$first_joke_dateTime;
$errors = array();
try{
    $db = new PDO($attr, $db_user, $db_pwd, $options);

    $query = "SELECT Joke_Posts.joke_id, Joke_Posts.title, Joke_Posts.text, Joke_Posts.dateTime, Users_Info.username, Users_Info.avatar, AVG(User_Ratings.rating)AS Average_Rating FROM Joke_Posts
              LEFT JOIN User_Ratings ON (Joke_Posts.joke_id = User_Ratings.joke_id)
              LEFT JOIN Users_Info ON(Joke_Posts.user_id = Users_Info.user_id)
              GROUP BY Joke_Posts.joke_id
              ORDER BY Joke_Posts.dateTime DESC
              LIMIT 20";

    $result = $db->query($query);
}
catch(PDOException $e){
    throw new Exception($e -> getMessage(), (int)$e -> getCode());
}

if(!$result){
    $errors["QUERY ERROR"] = "There was an error in retrieving the joke list.";
}
else{
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>Joke Rating Site Homepage</title>
        <link rel = "stylesheet" type = "text/css" href="css/style.css" />

        <meta charset="utf-8" name = "author" content = "Foram_Patel"></meta>
    </head>

    <body>
        <div id = "homehead">
            <section>
                <img id = "headimage" src="images/Laugh.png" alt = "Laughing emoticon logo" ></img>
            <h1>Joke Rating Site Homepage</h1>
            </section>

            <aside>
                <form id = "searchbar" action = "" method = "post">
                    <input name = "search" type = "search" placeholder="type here to search.."></input>
                    <button type = "submit" value = "GO!">GO!</button>
                </form>
                <a href = "login.php" id = "homepagelogin">Login</a>
            </aside>
        </div>

        <div>
            <section id = "homepageheadinfo">
                <p>Following is the list of the joke that are posted by other users.
                    You can click on the name of the Joke to see the whole Joke and 
                    see the information of the poster as well, you can also rate the Joke in the same page. 
                    But you need to login to your user account to access all these features.
                </p>
                <div class = "home">
<?php
foreach($result as $row){
    $first_joke_id = $row["joke_id"];
    $first_joke_dateTime = $row["dateTime"];
    if($row["Average_Rating"]==""){
        $row["Average_Rating"] = "No Rating";
    }
        ?>
            <div>
                <Section>
                    <img class = "listimg" src = "<?=$row["avatar"]?>" />
                    <p><?=$row["username"]?></p>
                </section>
                <aside>
                    <h3><a href = "jokedetailpage.php?<?=$row['joke_id']?>"><?=$row["title"]?></a></h3>
                    <p><?=$row["text"]?></p>
                    <label id = "<?=$row['joke_id']?>"><strong>Average rating: </strong><?=$row["Average_Rating"]?></label><br />
                    <label id = "<?=$row['dateTime']?>"><strong>Date and Time of upload: </strong><?=$row["dateTime"]?></label>
                </aside>
            </div>
        <?php
        break;
    }
foreach($result as $row){
    if($row["Average_Rating"]==""){
        $row["Average_Rating"] = "No Rating";
    }
        ?>
            <div>
                <Section>
                    <img class = "listimg" src = "<?=$row["avatar"]?>" />
                    <p><?=$row["username"]?></p>
                </section>
                <aside>
                    <h3><a href = "jokedetailpage.php?<?=$row['joke_id']?>"><?=$row["title"]?></a></h3>
                    <p><?=$row["text"]?></p>
                    <label id = "<?=$row['joke_id']?>"><strong>Average rating: </strong><?=$row["Average_Rating"]?></label><br />
                    <label id = "<?=$row['dateTime']?>"><strong>Date and Time of upload: </strong><?=$row["dateTime"]?></label>
                </aside>
            </div>
        <?php
    }
}
?>
                </div>
                <div id = "empty">
                        <p>End of the List.</p>
                    </div>
            </section>

            <aside>

            </aside>
        </div>
        <label value = "<?=$first_joke_id?>" id = "last_joke_id"></label>
<label value = "<?=$first_joke_dateTime?>" id = "last_joke_dateTime"></label>

        <footer>
            <p>CS 215 * Assignments</p>
        </footer>
    </body>
    <script src = "js/validation.js"></script>
</html>