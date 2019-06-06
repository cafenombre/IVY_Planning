//Hide the values
var ul = document.getElementById('attr_card');
//ul.style.display = "none";

function compare(){
  var variable1 = parseInt(document.getElementById('inputfield1').value);
  var variable2 = parseInt(document.getElementById('inputfield2').value);
  if (variable1 > variable2) {
    alert("The first variable is greater than the second.");
  } else {
    alert("The second variable is greater than or equal to the first one.");
  }    
};

