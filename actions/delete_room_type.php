<html>
    <?php include('../header.php'); ?>
   <body>
    
    <!-- ----------------- CONTENT ----------------- !-->
    <?php 
    include('../models/room_model.php'); 
    echo $_GET["id"];
    delete_room_type($_GET["id"], $conn); 

    include('../footer.php');
    ?>
    <script>
    window.location = "../rooms.php";
    </script>
   </body>
</html>