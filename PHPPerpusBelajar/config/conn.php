<?php 
    include('secret.php');
    // create connection
    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    // check connection
    if(!$conn){
        echo 'Connection error: '. mysqli_connect_error();
    }
    
?>