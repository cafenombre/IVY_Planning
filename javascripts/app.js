$(document).ready(function(){
  $('select').formSelect();
});

$(document).ready(function(){
  $('.datepicker').datepicker();
});


//Hide the values
var ul = document.getElementById('ulValues');
ul.style.display = "none";
var timerStart = Date.now();
function makeApiCall() {
  //console.log("called");
    var params = {
      // The ID of the spreadsheet to retrieve data from.
      spreadsheetId: '1ubLa6d6r1ZZ8C-3GEvQFVkQb0--Gfkwh-nUeVBo-j54',  

      // The A1 notation of the values to retrieve.
      range: 'A2:E1000',  

      // How values should be represented in the output.
      // The default render option is ValueRenderOption.FORMATTED_VALUE.
      //valueRenderOption: '',  // TODO: Update placeholder value.

      // How dates, times, and durations should be represented in the output.
      // This is ignored if value_render_option is
      // FORMATTED_VALUE.
      // The default dateTime render option is [DateTimeRenderOption.SERIAL_NUMBER].
      //dateTimeRenderOption: '',  // TODO: Update placeholder value.
    };

    var request = gapi.client.sheets.spreadsheets.values.get(params);
    request.then(function(response) {
      // TODO: Change code below to process the `response` object:
      displayValues(response.result);
    }, function(reason) {
      console.error('error: ' + reason.result.error.message);
    });
  }

  function initClient() {
    var API_KEY = 'AIzaSyDqBTge2MaHaPqZo6VoHd876WlxNfd67gs';  // TODO: Update placeholder with desired API key.

    var CLIENT_ID = '1073677879264-bdqs94h4t8g263ul9kk3ugogol6kagjg.apps.googleusercontent.com';  // TODO: Update placeholder with desired client ID.

    // TODO: Authorize using one of the following scopes:
    //   'https://www.googleapis.com/auth/drive'
    //   'https://www.googleapis.com/auth/drive.file'
    //   'https://www.googleapis.com/auth/drive.readonly'
    //   'https://www.googleapis.com/auth/spreadsheets'
    //   'https://www.googleapis.com/auth/spreadsheets.readonly'
    var SCOPE = 'https://www.googleapis.com/auth/spreadsheets.readonly';

    gapi.client.init({
      'apiKey': API_KEY,
      'clientId': CLIENT_ID,
      'scope': SCOPE,
      'discoveryDocs': ['https://sheets.googleapis.com/$discovery/rest?version=v4'],
    }).then(function() {
      gapi.auth2.getAuthInstance().isSignedIn.listen(updateSignInStatus);
      updateSignInStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
    });
  }

  function handleClientLoad() {
    gapi.load('client:auth2', initClient);
  }

  function updateSignInStatus(isSignedIn) {
    if (isSignedIn) {
      makeApiCall();
    }
  }

  function handleSignInClick(event) {
    gapi.auth2.getAuthInstance().signIn();
  }

  function handleSignOutClick(event) {
    gapi.auth2.getAuthInstance().signOut();
  }

    //Generates a random date to fill the sheet
    function randomDate(start, end) {
        return new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
    }

    //Give a random name
    function randomName(){
        var items = Array("Paul", "Pierre", "Henry", "Sophie", "Patrick","Hubert","Emily","Jeanne","Josepah","Joseph","Sylvie","Manu","Vincent","Dovah");
        return items[Math.floor(Math.random()*items.length)];
    }

    function ShowValues(){
        var ul = document.getElementById('ulValues').style;
        ul.display = (ul.display == "none")? "block": "none";
    }

    function displayValues(result){
        var ul = document.getElementById('ulValues');
        for(var row=0; row<result.values.length; row++){
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(result.values[row][0]+" - "+result.values[row][1]+" - "+result.values[row][2]+" - "+result.values[row][3]+" - "+result.values[row][4]))
            li.setAttribute('class','collection-item');
            ul.appendChild(li);
        }

            //Recieve the values, send it to the model, compare to see if modified, update/create, return the number of modifications
            //Call the update
            $.ajax({ url: 'http://localhost/planning/controllers/master_controller.php',
              data: {json: JSON.stringify(result.values)},
              type: 'post',
              success: function(output) {
                console.log(output);
                //console.log(JSON.parse(output));
                createTimeline(output);
                }
            });

            //END AJAX

            
    }
    function populateSheet(){
        var sheet = SpreadsheetApp.getActiveSheet().setName('Settings');
        var headers = [
        'ID',
        'Name',
        'Date',
        'isDeleted'];
        //Set the header
        sheet.getRange('A1:D1').setValues([headers]).setFontWeight('bold');
        

        //Sets the values
        for(var i=2; i<14; i++){
        var date = randomDate(new Date(2012, 0, 1), new Date());
        var rndBool = Math.random() >= 0.5 ? "N" : "Y";
        var initialData = [i-1, randomName(), date, rndBool];
        sheet.getRange('A'+i+':D'+i).setValues([initialData]);
        }

    }