<?php
require_once 'D:/DEV/xampp/htdocs/planning/config/db.php';



// ------------------- TESTS ---------------------

//echo "test ";
$id_room = 2;
$id_res = 4;
$bed = 1;
$start = '2018-11-02';
$end = '2018-11-11';
$day = '2018-11-14';

//assign_reservation($id_room, $id_res, $bed, $start, $end, $conn);
//update_res_room($id_room, $id_res, $bed, $start, $end, $conn);
//unassign_res($id_room, $id_res, $conn);
//print_r(get_all_res_room($conn));
//print_r(get_all_unassinged_res_by_day($day, $conn));
//echo(count(get_all_unassinged_res($conn)));
/*foreach(get_all_unassinged_res($conn) as $res){
    echo "<br />";
    print_r($res);
}*/
//print_r(count_non_assigned_days($conn));

// ------------------- METHODS ------------------------

function count_non_assigned_days($conn){
    $values = get_all_unassinged_res($conn);
    $days = array();

    foreach($values as $value){
        $start = strtotime($value[1]);
        $end = strtotime($value[2]);
        while($start < $end){
            $days[date("c", $start)] = (isset($days[date("c", $start)])) ? $days[date("c", $start)] +1 : 1 ;
            $start = strtotime("+1 day", $start); //Incrementation
        }
    }

    return $days; //array to json - json to string
} 



// ------------------- DATABASE ACTIONS ------------------------

//Assign reservation to room    
function assign_reservation($id_room, $id_res, $bed, $start, $end, $conn){
    $sql = "INSERT INTO `res_room` (`id_room`, `id_res`, `bed`, `start_date`, `end_date`)
    VALUES ('".$id_room."', '".$id_res."', '".$bed."', '".$start."', '".$end."');";
    $result = $conn->query($sql);

    return 0;
}

//Update a reservation assignment   
function update_res_room($id_room, $id_res, $bed, $start, $end, $conn){
    $sql = "UPDATE `res_room` SET `bed` = '".$bed."', `start_date` = '".$start."', `end_date` = '".$end."' 
    WHERE `res_room`.`id_res` = ".$id_res." AND `res_room`.`id_room` = ".$id_room." ;";
    $result = $conn->query($sql);

    return 0;
}

//Unassign a reservation    
function unassign_res($id_room, $id_res, $conn){
    $sql = "DELETE FROM `res_room` WHERE `id_room` = ".$id_room." AND `id_res` = ".$id_res."  ;";
    $result = $conn->query($sql);

    return 0;
}




//Return all the reservations assigned to a room    
function get_all_res_room($conn){
    //Set SQL Query
    $sql = "SELECT * FROM `res_room`";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

//Return all the reservations assigned to a room for a date  
function get_all_unassinged_res_by_day($day, $conn){
    //Set SQL Query
    $sql = "SELECT * FROM `reservations` 
    WHERE `start_date` <= '".$day."' AND `end_date` > '".$day."'
     AND id NOT IN (SELECT id_res from res_room WHERE `start_date` <= '".$day."' AND `end_date` > '".$day."');";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

//Return id, start_date, end_date of all reservations non-assigned
function get_all_unassinged_res($conn){
    //Set SQL Query
    //TEST NEEDED BY ADDING RES OUT OF DATE AND IN DATE (with a room)  Splits ? HAAAAAAAAAAAAAAAAAAAAAA
    $sql = "SELECT id, start_date, end_date FROM `reservations` WHERE (id, start_date, end_date) NOT IN (SELECT id_res, start_date, end_date from res_room)"; //Wrong not in
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

?>