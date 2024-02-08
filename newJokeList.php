<?php

require_once("db.php");

$last_joke_id = $_GET["joke_id"];
$last_joke_date = $_GET["joke_date"];
$jsonArray = array();
$newJokeListCount = 0;

try{
    $db = new PDO($attr, $db_user, $db_pwd, $options);

    $query = "SELECT Joke_Posts.joke_id, Joke_Posts.title, Joke_Posts.text, Joke_Posts.dateTime, Users_Info.username, Users_Info.avatar, AVG(User_Ratings.rating)AS Average_Rating FROM Joke_Posts
              LEFT JOIN User_Ratings ON (Joke_Posts.joke_id = User_Ratings.joke_id)
              LEFT JOIN Users_Info ON(Joke_Posts.user_id = Users_Info.user_id)
              GROUP BY Joke_Posts.joke_id
              ORDER BY Joke_Posts.dateTime DESC
              LIMIT 20";
    $result = $db -> query($query);

    foreach($result as $row){
        if($row["joke_id"] == $last_joke_id){
            break;
        }
        if($row["Average_Rating"] == ""){
            $row["Average_Rating"] = "No Rating";
        }
        $jsonArray[] = $row;
        $newJokeListCount++;
    }

    echo json_encode($jsonArray);

    $db = null;
    $query = null;
    $result = null;
}
catch(PDOException $e){
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>