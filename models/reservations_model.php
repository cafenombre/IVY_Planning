    <?php
require_once ROOT_PATH.'/planning/config/db.php';


//Check if there is modifications and update/add in the Database
function checkAndUpdate($json, $conn){
    //Transform into a JSON object
    $values = json_decode($json);  

    //Get all the values from DB and compare with the API ones
    $changed_values = compare_db_and_api(get_all_reservations($conn), $values, $conn);

    
    //should return the number of values updates/added:deleted
}

//Take two arrays, one from the DB and one from the API and check if an update is needed
function compare_db_and_api($db, $api, $conn){
    //Create the array that will contain the changed values
    $changed_values = array();

    //Sort the array so the keys = the ID and date format match with DB
    $api = sortArray($api);
    $db = sortArray($db);

    /* ---- DELETE ---- */
    $delete = substract_array($db, $api);
    //Delete the reservations needed to the Database
    delete_several_reservations($delete, $conn);

    /* ---- ADD ---- */
    $add = substract_array($api, $db);
    //Add the reservations needed to the Database
    add_several_reservations($add, $conn);


    //Reajust the tables 
    $api = substract_array($api, $add);
    $db = substract_array($db, $delete);

    //echo("API VALUES :".count($api)." DB VALUES ".count($db));

    //now check if there is the same amout or rows
    if(count($api) != count($db)){ return -1; }

    /* ---- UPDATE ---- */
    //Now check if there is updates by comparing $db and $api
    foreach($api as $row){
        $index = $row[0];
        $diff = (array_diff_assoc($row, $db[$index]));
        if (!empty($diff)) { 
            array_push($changed_values, $api[$index]);
        }
    }
    //Update the reservations in the Database
    update_several_reservations($changed_values, $conn);

    //Display for debug
    /*echo("DELETED VALUES  ");
    print_r($delete);
    echo("ADDED VALUES  ");
    print_r($add);
    echo("UPDATED VALUES   ");
    print_r($changed_values);
    */

    return $changed_values; //return string displaying number of values updated:deleted:added
}

//Sort an array
function sortArray($array){
    $sorted_array = array();
    //Sort the array so the keys = the ID and date format match with DB
    for($i = 0; $i<sizeof($array); $i++){
        $array[$i][2] = (new DateTime($array[$i][2]))->format('Y-m-d'); //We can also do it with a substr
        $array[$i][3] = (new DateTime($array[$i][3]))->format('Y-m-d');
        $sorted_array[$array[$i][0]] = $array[$i];
    }

    return $sorted_array;
}


//Substract an array to another
function substract_array($source, $substract){
    //create the return array
    $substracted = array();
    //substract the keys 
    $diffs = array_diff(array_keys($source), array_keys($substract));
    //Fill the return array with the remaining keys
    foreach($diffs as $diff){
      $substracted[$diff] = $source[$diff];
    }
    return $substracted;
}

// ------------------- DATABASE ACTIONS ------------------------

//Delete a reservation by id
function delete_reservation($id, $conn){
    $sql = "DELETE FROM `reservations` WHERE `id` = ".$id.";";
    $result = $conn->query($sql);

    return 0;
}

//Delete several reservations with an array of reservations
function delete_several_reservations($array, $conn){
    foreach($array as $value){
        delete_reservation($value[0], $conn);
    }
}

//Add several reservations with an array of reservations
function add_several_reservations($array, $conn){
    foreach($array as $value){
        add_reservation($value[0],$value[1],$value[2],$value[3],$value[4], $conn);
    }
}

//Update a reservation
function update_reservation($id, $name, $start, $end,  $type, $conn){
    $sql = "UPDATE `reservations` SET `name` = '".$name."', `start_date` = '".$start."', `end_date`= '".$end."', `type`= '".$type."'WHERE `id` = ".$id.";";
    $result = $conn->query($sql);

    return 0;
}

//Update several reservations with an array of reservations
function update_several_reservations($array, $conn){
    foreach($array as $value){
        update_reservation($value[0],$value[1],$value[2],$value[3],$value[4], $conn);
    }
}
//Add a reservation to the DB 
function add_reservation($id, $name, $start, $end,  $type, $conn){
    $sql = "INSERT INTO `reservations` (`id`,`name`, `start_date`, `end_date`, `type`)
    VALUES ('".$id."', '".$name."', '".$start."', '".$end."', '".$type."');";
    $result = $conn->query($sql);

    return 0;
}

//Return all the reservations from DB (without the is_split bool)
function get_all_reservations($conn){
    //Initialize empty array
    $DBValues = array();

    //Set SQL Query
    $sql = "SELECT `id`,`name`, `start_date`, `end_date`, `type` FROM `reservations`";
    //Call the database
    $result = $conn->query($sql); 
    //$array = mysqli_fetch_array($result);

    $row = $result->fetch_all();

    return $row; //Return as a sorted array
}

?>