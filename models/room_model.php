<?php
require_once(ROOT_PATH.'/planning/config/db.php');

$conn = $conn;

// ------------------- TESTS -------------

//echo "test ";

$name = "CHAMBRE UNE";
$name2 = "CHAMBRE MODIFIEE";
$type = 1 ;
$nb_simple = 2;
$nb_double = 1;
$id = 1;
$room = 2;
$start = '2018-11-14';
$end = '2018-11-15';
$bed = 1;
$beds = array(1,2,3,4,6);
//print_r(get_all_taken_beds_for_day($start, $conn));
//print_r(get_all_taken_beds_for_period($start, $end, $conn));
//print_r(get_all_blocked_beds_by_day($start, $conn));
//print_r(get_all_blocked_beds_by_period($start, $end, $conn));
//block_bed($room, $start, $end, $bed, $conn);
//block_beds($room, $start, $end, $beds, $conn);
//print_r(is_blocked($room, $start, $end, $bed, $conn));
//remove_block($room, $start, $end, $bed, $conn);
//create_room($name, $type, $nb_simple, $nb_double, $conn);
//update_room($id, $name2, $type, $nb_simple, $nb_double, $conn);
//delete_room($id, $conn);

//create_room_type($name, $conn);
//update_room_type($id, $name2, $conn);
//delete_room_type($id, $conn);

//print_r(get_all_rooms($conn));
//print_r(get_all_room_types($conn));

// ------------------- METHODS ------------------------

// BLOCK SECOND BED FOR DOUBLE BEDS.

// ------------------- DATABASE ACTIONS ------------------------


/* --- ROOMS --- */
//Add a room 
function create_room($name, $type, $nb_simple, $nb_double, $conn){
    $sql = "INSERT INTO `room` (`name`, `type`, `nb_simple_beds`, `nb_double_beds`)
    VALUES ('".$name."', '".$type."', '".$nb_simple."', '".$nb_double."');";
    $result = $conn->query($sql);

    return 0;
}

//Update a room   
function update_room($id, $name, $type, $nb_simple, $nb_double, $conn){
    $sql = "UPDATE `room` SET `name` = '".$name."', `type` = '".$type."', `nb_simple_beds` = '".$nb_simple."', `nb_double_beds` = '".$nb_double."'
    WHERE `id` = ".$id.";";
    $result = $conn->query($sql);

    return 0;
}

//Delete a room   -/-
function delete_room($id, $conn){
    $sql = "DELETE FROM `room` WHERE `id` = ".$id.";";
    $result = $conn->query($sql);

    return 0;
}

/* --- ROOM TYPES --- */

//Create a room type 
function create_room_type($name, $conn){
    $sql = "INSERT INTO `room_types` (`name`)
    VALUES ('".$name."');";
    $result = $conn->query($sql);

    return 0;
}

//Update a room type   -/-
function update_room_type($id, $name, $conn){
    $sql = "UPDATE `room_types` SET `name` = '".$name."' 
    WHERE `id` = ".$id.";";
    $result = $conn->query($sql);

    return 0;
}

//delete a room type    -/-
function delete_room_type($id, $conn){
    $sql = "DELETE FROM `room_types` WHERE `id` = ".$id." ;";
    $result = $conn->query($sql);

    return 0;
}

/* --- BLOCKED BEDS --- */

//Block a bed 
function block_bed($room, $start, $end, $bed, $conn){
    $sql = "INSERT INTO `blocking` (`start_date`, `end_date`, `id_room`, `bed`)
    VALUES ('".$start."', '".$end."', '".$room."', '".$bed."');";
    $result = $conn->query($sql);

    return 0;
}

//Block several beds
function block_beds($room, $start, $end, $beds, $conn){
    foreach($beds as $bed){
        echo $bed;
        block_bed($room, $start, $end, $bed, $conn);
    }
}

//remove blocking from a bed
function remove_block($room, $start, $end, $bed, $conn){
    $sql = "DELETE FROM `blocking` WHERE `start_date` = '".$start."' AND `end_date` = '".$end."' AND `id_room` = '".$room."' AND `bed` = '".$bed."';";
    $result = $conn->query($sql);

    return 0;
}

// ------------------ GETTERS -----------------

//Return all the rooms   
function get_all_rooms($conn){
    //Set SQL Query
    $sql = "SELECT * FROM `room`";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

//Return all taken beds for a day
function get_all_taken_beds_for_day($day, $conn){
    //Set SQL Query
    $sql = "SELECT `room`.id, `res_room`.bed FROM `room`, `res_room` 
    WHERE `room`.id = `res_room`.id_room
    AND `res_room`.end_date >= '".$day."' AND `res_room`.start_date  <= '".$day."'";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

//Return all taken beds for a period a-b (if start<a<end OR start<b<end)
function get_all_taken_beds_for_period($start, $end, $conn){
    //Set SQL Query
    $sql = "SELECT `room`.id, `res_room`.bed FROM `room`, `res_room` 
    WHERE `room`.id = `res_room`.id_room
    AND (`res_room`.end_date >= '".$start."' AND `res_room`.start_date  <= '".$start."' OR  `res_room`.end_date >= '".$end."' AND `res_room`.start_date  <= '".$end."')";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

//Return all the reservations assigned to a room    
function get_all_room_types($conn){
    //Set SQL Query
    $sql = "SELECT * FROM `room_types`";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

//Return true if the bed is blocked
function is_blocked($room, $start, $end, $bed, $conn){
    $sql = "SELECT * FROM  `blocking` WHERE `start_date` = '".$start."' AND `end_date` = '".$end."' AND `id_room` = '".$room."' AND `bed` = '".$bed."';";
    //Call the database
    $result = $conn->query($sql); 

    return !empty($result->fetch_all()); 
}

//Return all blocked beds   
function get_all_blocked_beds($conn){
    //Set SQL Query
    $sql = "SELECT * FROM `blocking`";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

//Return all blocked beds for one day
function get_all_blocked_beds_by_day($day, $conn){
    //Set SQL Query
    $sql = "SELECT * FROM `blocking` WHERE end_date >= '".$day."' AND start_date  <= '".$day."'";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}
 
//Return all blocked beds for a period a-b (if start<a<end OR start<b<end)
function get_all_blocked_beds_by_period($start, $end, $conn){
    //Set SQL Query
    $sql = "SELECT * FROM `blocking` WHERE end_date >= '".$start."' AND start_date  <= '".$end."' OR end_date >= '".$end."' AND start_date  <= '".$end."'";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

//Return all blocked beds for one day and the room name
function get_all_blocked_beds_by_day_n_infos($day, $conn){
    //Set SQL Query
    $sql = "SELECT id_room, bed, name FROM `blocking`, `room` WHERE `blocking`.id_room = `room`.id AND end_date >= '".$day."' AND start_date  <= '".$day."'";
    //Call the database
    $result = $conn->query($sql); 

    return $result->fetch_all(); //Return as an array
}

?>