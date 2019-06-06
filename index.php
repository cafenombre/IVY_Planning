  <html>
  <?php include('header.php'); //Version 0.3.1 ?>
   <body>
      <div id="wrapper">
        <?php
          include 'D:/DEV/xampp/htdocs/planning/models/reservations_model.php'; //Fuck that I can't include a relative path
        ?>
   
        <ul class="collection" id="ulValues">
        </ul>
        
      <div id="subBtns">
         <button id="signin-button" class="btn purple" onclick="handleSignInClick()">Sign in</button>
         <button id="signout-button" class="btn pink" onclick="handleSignOutClick()">Sign out</button>
         <button id="popValues" class="btn red" onclick="ShowValues()">Show values</button>
      </div>

      <!-- Attribution part -->
      <div id="attr_card">
        <div class="row">  
            <div class="col s12">
              <div class="card blue-grey darken-1">
                <div class="card-content grey lighten-4">
                  <span class="card-title">Attribution</span>
                  <table id="allocation_table">

                  <!-- FAIS UN TALBEAU GROS CON -->
                    <tr>
                      <th></th>
                      <th>Name</th>
                      <th>Arrival</th>
                      <th>Departure</th>
                      <th>Room allocation</th>
                      <th>Block other beds</th>
                      <th>Split</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>

                    <!-- New allocation line, select the color wanted here -->
                    <tr class="attr_list" style="background-color: #f2f2f2;">

                      <!-- ID -->
                      <th>1975</td>
                      <!-- Name -->
                      <td>Joseph Martell</td>
                      <!-- Arrival -->
                      <td>12/06/18</td>
                      <!-- Departure -->
                      <td>
                        <p class="departure_text">14/06/18</p>
                        <!-- Datepicker that will be shown when split will be checked -->
                        <input class="departure_picker" type="text" class="datepicker">
                      </td>
                      <!-- Select room -->
                      <td>                        
                        
                          <select class="">
                            <option value="" disabled selected>Bed to allocate</option>
                            <optgroup label="Room">
                            <option value="">Room 1 - Bed 1</option>
                            <option value="">Room 1 - Bed 2</option>
                            <option value="">Room 1 - Bed 3</option>
                            <option value="">Room 2 - Bed 1</option>
                            <option value="">Room 2 - Bed 2</option>
                            <optgroup label="Dormitory">
                            <option value="">Dorm 1 - Bed 1</option>
                            <option value="">Dorm 1 - Bed 2</option>
                            <option value="">Dorm 1 - Bed 3</option>
                            <option value="">Dorm 1 - Bed 4</option>
                            <option value="">Dorm 1 - Bed 5</option>
                            <option value="">Dorm 2 - Bed 1</option>
                            <option value="">Dorm 2 - Bed 2</option>
                            <option value="">Dorm 2 - Bed 3</option>
                            <option value="">Dorm 2 - Bed 4</option>
                          </select>
                      </td>

                      <!-- Block other beds checkbox -->
                      <td>                      
                        <label>
                          <input type="checkbox" class="filled-in block" />
                          <span>Block</span>
                        </label>
                      </td>
                      
                      <!-- Split reservation checkbox -->
                      <!-- if this is checked, display datepicker -->
                      <td>                      
                        <label> 
                          <input type="checkbox" class="filled-in split" />
                          <span>Split</span>
                        </label>
                      </td>

                      <!-- Edit -->
                      <td> <a class="btn blue"><i class="material-icons">create</i></a></td>
                      <!-- Delete -->
                      <td> <a class="btn red"><i class="material-icons">delete</i></a></td>
                      <!-- Allocate -->
                      <td><button style="margin-left : 10px;" class="btn" onclick="compare()">Save</button></td>

                    </tr>
                    
                  </table>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Planning -->

        <div class="row">
          <div class="col s12">
            <div class="card blue-grey darken-1">
              <div class="card-content grey lighten-4">
                <span class="card-title">Timeline</span>
                <div id="mytimeline"></div>
              </div>
              <div class="card-action">
                <a onclick="udpteTimeline()" >Update values</a>
              </div>
            </div>
          </div>
        </div>

  <?php include('footer.php'); ?>

   </body>
</html>