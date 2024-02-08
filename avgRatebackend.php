<?php

require_once("db.php");

$last_joke_id = $_GET["joke_id"];
$last_joke_dateTime = $_GET["date"];
$avgRate_array = array();

$last_joke_check = $last_joke_id - 19;

if($last_joke_check <= 0){
    $last_joke_check = 1;
}

try{
    $db = new PDO($attr, $db_user, $db_pwd, $options);

    for($i = $last_joke_id ; $i >=$last_joke_check ; $i--){
        $query = "SELECT AVG(User_Ratings.rating) AS Average_Rating FROM User_Ratings LEFT JOIN Joke_Posts ON (User_Ratings.joke_id = Joke_Posts.joke_id) WHERE Joke_Posts.joke_id = '$last_joke_id' GROUP BY Joke_Posts.joke_id";
        $result = $db -> query($query);

        $avg = $result -> fetchColumn(0);
        if($avg == ""){
            $avg = "No Rating";
        }
        $avgRate_array[] = $avg;
        $last_joke_id--;
    }

    echo json_encode($avgRate_array);

    $db = null;
    $query = null;
    $result = null;
}
catch(PDOException $e){
    throw new PDOException($e -> getMessage(), (int) $e -> getCode());
    
}
?>