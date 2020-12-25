<?php 
include('../config/conn.php');

if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
    
    // write sql
    $sql = "DELETE FROM book where id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
        header('Location: listBooks.php');
    } else {
        echo 'Delete error: '.mysqli_error($conn);
    }
}

?>