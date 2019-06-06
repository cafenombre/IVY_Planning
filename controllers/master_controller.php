<?php

//File that uses the 3 models to gather all the informations needed for the timeline

include '../models/room_model.php';
include '../models/attribution_model.php';
include '../models/reservations_model.php';

// ------------------- AJAX RESPONSES ------------

if(isset($_POST['day']) && !empty($_POST['day'])) {
    $var = substr($_POST['day'], 1, 10);
    $res = concat_attributions_datas($var, $conn);
    echo($res);
}


if(isset($_POST['json']) && !empty($_POST['json'])) {
    $json = $_POST['json'];
    //Check and update the database
    checkAndUpdate($json, $conn);
    //Return all the needed datas
    echo(concat_all_datas($conn));
}

//echo concat_attributions_datas('2018-11-14', $conn);

/* ------------------- METHODS ----------------------- */

function create_bed_array($rooms){
    $result = array();
    foreach($rooms as $room){
        $result[$room[0]] = array("name"=> $room[1], "beds"=> array());
        $s_b = $room[3];
        $d_b = $room[4];
    
        for($s_bed = 0; $s_bed < $s_b; $s_bed ++){
            array_push($result[$room[0]]["beds"], ($s_bed+1));
        }
        for($d_bed = 0; $d_bed < ($d_b*2); $d_bed ++){
            array_push($result[$room[0]]["beds"], ($s_bed+$d_bed+1));
        }
    }
    return $result;
    
}

function remove_unavailable_beds($rooms, $taken, $blocked){

    foreach($rooms as $key => $room){
        //The key is the ID

        //Remove the taken beds
        foreach ($taken as $value) {
           if($key == $value[0]){
               unset($rooms[$key]["beds"][($value[1]-1)]);
           }
        }
        //Remove the blocked beds
        foreach ($blocked as $value) {
            if($key == $value[0]){
                unset($rooms[$key]["beds"][($value[1]-1)]);
            }
         }
    }
    return $rooms;
}

function concat_attributions_datas($day, $conn){


    $rooms = get_all_rooms($conn);
    $rooms_sorted = create_bed_array($rooms);

    $final_concat = array();

    //All non allocated reservations for the day
    $res = get_all_unassinged_res_by_day($day, $conn);

    foreach($res as $resa){
        //echo $resa[2]." - ".$resa[3]." <br />";
        // 0 - id / 1 - Nom / 2 -Start / 3 - End / 4 -Type / 5 - isSplit
        //Do the bed part for EACH reservation non allocated
        $rooms_n_beds = $rooms_sorted;
        // [id - bed]
        $taken_beds = get_all_taken_beds_for_period($resa[2], $resa[3], $conn); //Per period
        // [id - bed - name]
        $blocked_beds = get_all_blocked_beds_by_period($resa[2], $resa[3], $conn); //Per period

        $clear_rooms = remove_unavailable_beds($rooms_n_beds, $taken_beds, $blocked_beds);

        $concat = array("unassigned_res" => $resa, "infos" => array("rooms" => $clear_rooms, "blocked_beds" => $blocked_beds));

        $final_concat[$resa[0]] = $concat ;

        }    


    return json_encode($final_concat); 
}


function concat_all_datas($conn){
    //Return all rooms, days of non attributed res, attributed reservations in on JSON string and blocked beds
    $rooms = array();
    $blocked_beds = array();
    $res_attr = array();
    $days = array();

    //Get all the rooms and number of beds [room_model]
    $rooms = get_all_rooms($conn);

    //Get all blocked beds [room_model]
    $blocked_beds = get_all_blocked_beds($conn);

    //Get all the reservations allocated to a room & bed [attribution_model]
    $res_attr = get_all_res_room($conn);

    //Get all days and numbers of non-allocated reservations for those dates [attribution_model]
    $days = count_non_assigned_days($conn);

    //Concat the 3 arrays into one JSON
    $concat = json_encode(array("rooms" => $rooms, "blocked_beds" => $blocked_beds, "days" => $days, "res_attr" => $res_attr));

    //Return the JSON
    return $concat;
}

?>
