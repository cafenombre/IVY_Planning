//CONSTANT 


document.getElementById('mytimeline').onclick = function (event) {
    var props = timeline.getEventProperties(event);

    // Ajax this shit : get_all_unassinged_res_by_day
    if((typeof props["group"] !== 'undefined') && props["group"] == 1 && props["item"] !== null){
        $.ajax({ url: 'http://localhost/planning/controllers/master_controller.php',
        data: {day: JSON.stringify(props["item"])},
        type: 'post',
        success: function(output) {
            console.log(JSON.parse(output));
            //var x = JSON.parse(output);
            //var count = Object.keys(x).length;
            //console.log(count)
            add_allocation_node(output);
        }
      });
    }

}

function add_allocation_node(values){

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems, options);
      });
    
    var table = document.getElementById("allocation_table");
    var val = JSON.parse(values);
    var count = Object.keys(val).length;
    
    while(table.rows.length > 1){
        table.deleteRow(1);
    }

    //console.log(count);

    for(var i = 0; i<count; i++){
        var id = Object.keys(val)[i];
        var resa = val[id];

        //Create tr
        var row = table.insertRow(i+1);

        //Fill tr
        var cells = [];

        for(var y = 0; y<10; y++)
            cells[y] = row.insertCell(y);
        
        //Cell 1 --- ID    
        var a = document.createElement('strong');
        var linkText = document.createTextNode(resa.unassigned_res[0]);
        a.appendChild(linkText);
        cells[0].appendChild(a);

        //Cell 2 --- Name
        cells[1].innerHTML = resa.unassigned_res[1];

        //Cell 3 --- Start date
        cells[2].innerHTML = resa.unassigned_res[2];

        //Cell 4 --- End date
        cells[3].innerHTML = resa.unassigned_res[3];

        //Cell 5 --- Select
        var divselect = document.createElement('div');
        divselect.className = "input-field";

        var select_rooms = document.createElement('select');
        select_rooms.className = "browser-default";
        select_rooms.id = "select_attr_"+y;
        select_rooms.name = "select_attr_"+y;

        var count_rooms = Object.keys(resa.infos.rooms).length;

        //var labelselect = document.createElement('label');
        //labelselect.innerHTML = "Selectionner chambre";

        //Foreach rooms
        for (var z = 0; z < count_rooms; z++) {
            var id_room = Object.keys(resa.infos.rooms)[z];
            var room = resa.infos.rooms[id_room];
            var number_beds = room.beds.length;

            //Foreach beds
            for(var zz = 0 ; zz<number_beds; zz++){
                var option = document.createElement("option");
                option.value = id_room+":"+room.beds[zz];
                //console.log(id_room);
                option.text = room.name+" - Lit n."+room.beds[zz];
                select_rooms.appendChild(option);
            }
        }

        divselect.appendChild(select_rooms);
        //divselect.appendChild(labelselect);
        cells[4].appendChild(divselect);

        //Cell 5 -- Block

        //label
        var label = document.createElement('label');
        label.id = 'label'+y;
        //checkbox
        var checkblock = document.createElement('input');
        checkblock.type = "checkbox";
        checkblock.className = "filled-in block";
        checkblock.id = "block"+y;

        //span
        var spanblock = document.createElement('span');
        spanblock.innerHTML = "block";

        label.appendChild(checkblock);
        label.appendChild(spanblock);

        cells[5].appendChild(label);

        /*<!-- Block other beds checkbox -->
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

      </tr>*/
    }


}
// create groups
function createGroups(rooms){
    var groups = new vis.DataSet()
    var count = Object.keys(rooms).length;

    groups.add({
        id: 1,
        content: 'ALLOCATIONS'
    });
    //for each room : for number of solo bed, for 2x number of duo bed
    for (var i = 0; i < count; i++) {
        var id = rooms[i][0];
        var name = rooms[i][1];
        var s_b = rooms[i][3];
        var d_b = rooms[i][4];

        for(var s_bed = 0; s_bed < s_b; s_bed ++){
            groups.add({
                id: id+':'+(s_bed+1),
                content: name+' - Lit n.'+(s_bed+1)
            });
        }
        for(var d_bed = 0; d_bed < (d_b*2); d_bed ++){
            groups.add({
                id: id+':'+(s_bed+d_bed+1),
                content: name+' - Lit n.'+(s_bed+d_bed+1)
            });
        }
    }
    

    return groups;
}


// create items
function createItems(days, res_attr, blocked_beds){
    // Randomized values   
    if (typeof days == 'undefined' || typeof res_attr == 'undefined' || typeof blocked_beds == 'undefined') { 
        var numberOfItems = 20;
        var items = new vis.DataSet();

        var itemsPerGroup = Math.round(numberOfItems/20);

        for (var truck = 0; truck < 20; truck++) {
            var date = new Date();
            for (var order = 0; order < itemsPerGroup; order++) {
            date.setHours(date.getHours() + 4 * (Math.random() < 0.2));
            var start = new Date(date);

            date.setHours(date.getHours() + 2 + Math.floor(Math.random()*4));
            var end = new Date(date);

            items.add({
                id: order + itemsPerGroup * truck,
                group: truck,
                start: start,
                end: end,
                content: 'Order ' + order
            });
            }
        }
    }
    //JSON Parsing display
    else{

        var items = new vis.DataSet();
        count = Object.keys(res_attr).length;

        //Planning in itsleft with resevations
        for(var i =0; i<count; i++){
            items.add({
                //className: 'pink',
                id: res_attr[i][0]+'-'+res_attr[i][3],
                group: res_attr[i][1]+':'+res_attr[i][2],
                start: res_attr[i][3],
                end: res_attr[i][4],
                content: res_attr[i][1]
            });
        }

        var date1 = new Date();
        for(var y = 0; y< Object.keys(days).length; y++){
            var dt = Object.keys(days)[y];
            var d = new Date(dt);
            items.add({
                className: 'pink',
                id: dt,
                group: 1,
                start: d,
                //end: d,
                end: new Date(d).setDate(d.getDate() + 1),
                content: 'N.'+days[dt]
            });
        }
    }
    return items;
}


// Specify options
function setParameters(){
    //Beginning of the planning display
    var startDate = new Date();
    //Ending
    var endDate = new Date();
    endDate.setDate(endDate.getDate() + 10)

    //Parameters
    var options = {
        stack: false,
        verticalScroll: true,
        zoomKey: 'ctrlKey',
        maxHeight: 500,
        start: startDate,
        end: endDate,
        editable: false,
        margin: {
            item: 10, // minimal margin between items
            axis: 5   // minimal margin between items and the axis
        },
        orientation: 'top'
    };
    return options;
}

//Function that create the timeline, taking as parameter the values the will be used to fill it
function createTimeline(values){
    //Split the values
    var val = JSON.parse(values);
    // create a Timeline
    var container = document.getElementById('mytimeline');
    timeline = new vis.Timeline(container, createItems(val.days, val.res_attr, val.blocked_beds), createGroups(val.rooms), setParameters());
    
}

function udpteTimeline(){
    timeline.setData({
        groups: createGroups(),
        items: createItems()
      })
}


