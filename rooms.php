  <html>
    <?php include('header.php'); ?>
   <body>
    
    <!-- ----------------- CONTENT ----------------- !-->
    <?php 
    include('models/room_model.php'); 
    ?>
    
    <!-- ----------------- FORM PROCESSING ----------------- !-->
    <?php

    if (isset($_POST["form_name"])) {
        if($_POST["form_name"] == "room"){
          /* ----------- PROCESSING ROOM CREATION FORM ----------- */
          create_room($_POST["room_name"], $_POST["room_type"], $_POST["nb_simple"], $_POST["nb_double"], $conn);
         
        }
        else if ($_POST["form_name"] == "room_type"){
          /* ----------- PROCESSING ROOM TYPE CREATION FORM ----------- */
          create_room_type($_POST["room_type_name"], $conn);

          
        }
    }

    ?>
    <!-- ----------------- CREATE ROOM ----------------- !-->
    <div class="row">
    <!-- OPEN FORM -->
    <form action="rooms.php" id="create_room_form" method="post">
    <div class="col s12 m6">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
        
          <span class="card-title">CREATE A ROOM</span>
          <!-- HIDDEN INPUT CONTAINING FORM NAME -->
          <input type="hidden" id="form_name" name="form_name" value="room">
          <!-- NAME INPUT -->
          <div class="input-field">
            <input type="text" id="room_name" name="room_name" class="validate" required>
            <label for="room_name">Name</label>
          </div>
          <!-- NUMBER OF SIMPLE BEDS INPUT -->
          <div class="input-field">
            <input type="number" id="nb_simple" name="nb_simple" class="validate" required>
            <label for="nb_simple">Number simple beds</label>
          </div>
          <!-- NUMBER OF DOUBLE BEDS INPUT -->
          <div class="input-field">
            <input type="number" id="nb_double" name="nb_double" class="validate" required>
            <label for="nb_double">Number double beds</label>
          </div>
          <!-- ROOM TYPE SELECT -->
          <div class="input-field">
            <select required name="room_type">
              <option value="" disabled selected>Choose a room</option>
              <?php
              //Display all the options gethered on the room types db

              foreach(get_all_room_types($conn) as $type){
                echo '<option value="'.$type[0].'">'.$type[1].'</option>';
              }
              ?>
            </select>
            <label>Materialize Select</label>
          </div>



        </div>
        <div class="card-action">
          <input type="submit" value="ADD" class="btn green">
        </div>
      </div>
    </div>
    <!-- CLOSE FORM -->
    </form>

    <!-- ----------------- CREATE ROOM TYPE ------------ !-->

    <!-- OPEN FORM -->
    <form action="rooms.php" id="create_room_type_form" method="post">
    <div class="col s12 m6">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <span class="card-title">CREATE A ROOM TYPE</span>
          <!-- HIDDEN INPUT CONTAINING FORM NAME -->
          <input type="hidden" id="form_name" name="form_name" value="room_type">
          <!-- NAME INPUT -->
          <div class="input-field">
            <input type="text" id="room_type_name" name="room_type_name" class="validate" required>
            <label for="room_type_name">Name</label>
          </div>
        </div>
        <div class="card-action">
          <input type="submit" value="ADD" class="btn green">
        </div>
      </div>
    </div>
    <!-- CLOSE FORM -->
    </form>

    <!-- Close the row -->
    </div>
    <!-- ----------------- DISPLAY ROOMS --------------- !-->
      
    <div class="row">
      <div class="col s12 m6">
      <table>
      <colgroup width="10%">
      <colgroup width="25%">
      <colgroup width="10%">
      <colgroup width="10%">
      <colgroup width="25%">
      <colgroup width="10%">
      <colgroup width="10%">

        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Simple</th>
          <th>Double</th>
          <th>Type</th>
          <th></th>
          <th></th>
        </tr>

        <?php 
          foreach(get_all_rooms($conn) as $rooms){
            echo '<tr style="background-color: #f2f2f2;">';
            //ID
            echo '<th>'.$rooms[0].'</th>';
            //Name
            echo '<td>'.$rooms[1].'</td>';
            //Simple
            echo '<td>'.$rooms[3].'</td>';
            //Double
            echo '<td>'.$rooms[4].'</td>';
            //Type
            echo '<td>'.$rooms[2].'</td>';


            //Edit
            echo '<td> <a class="btn blue"><i class="material-icons">create</i></a></td>';
            //Delete
            echo '<td> <a class="btn red" href="actions/delete_room.php?id='.$rooms[0].'"><i class="material-icons">delete</i></a></td>';
            echo '</tr>';
          }
        ?>
        </tr>
        
      </table>
    </div>


    <!-- ----------------- DISPLAY ROOM TYPES ---------- !-->

      <div class="col s12 m6">
      <table>
      <colgroup width="10%">
      <colgroup width="70%">
      <colgroup width="10%">
      <colgroup width="10%">
      <!-- FAIS UN TALBEAU GROS CON -->
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th></th>
          <th></th>
        </tr>
        <?php 
          foreach(get_all_room_types($conn) as $types){
            echo '<tr style="background-color: #f2f2f2;">';
            //ID
            echo '<th>'.$types[0].'</th>';
            //Name
            echo '<td>'.$types[1].'</td>';
            //Edit
            echo '<td> <a class="btn blue"><i class="material-icons">create</i></a></td>';
            //Delete
            echo '<td> <a class="btn red" href="actions/delete_room_type.php?id='.$types[0].'"><i class="material-icons">delete</i></a></td>';
            echo '</tr>';
          }
        ?>       


        
      </table>
    </div>
    </div>

   <?php include('footer.php'); ?>
   </body>
</html>