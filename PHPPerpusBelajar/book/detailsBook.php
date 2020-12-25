<?php 
    $pagetitle = 'Details of Book';
    include('../config/conn.php');


    // if(isset($_POST['delete'])){
    //     $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    //     // write sql
    //     $sql = "DELETE FROM book where id = $id_to_delete";

    //     if(mysqli_query($conn, $sql)){
    //         header('Location: listBooks.php');
    //     } else {
    //         echo 'Delete error: '.mysqli_error($conn);
    //     }
    // }

    $book = array();
    
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        
        // write query
        $sql = "SELECT id, title, author, isbn, cover FROM book WHERE id = $id";

        // make query & get result
        $result = mysqli_query($conn, $sql);

        // fetch the result
        $book = mysqli_fetch_assoc($result);

        // free up result resources
        mysqli_free_result($result);

        // close connection
        mysqli_close($conn);

        $filename = '';
        if(!empty($book['cover'])){
            $filename = htmlspecialchars($book['cover']);
        } else {
            $filename = 'no_image_found.jpg';
        }
        $coverpath = '~/../../media/'.$filename;
        if (!file_exists($coverpath)){
            $coverpath = '~/../../media/no_image_found.jpg';
        }
    }
    
    
?>


<!DOCTYPE html>
<html lang="en">
    <?php include('../header.php'); ?>
    <body class="d-flex flex-column min-vh-100">
        <?php include('../nav.php'); ?>
        <div class="container">
            <main role="main" class="pb-3">
            <h3 class="display-4"><?php echo htmlspecialchars($pagetitle);?></h3>
            
            <?php if(!empty($book)): ?>
                <div class="row justify-content-center m-3">
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-header">
                                <h2><?php echo htmlspecialchars($book['title']); ?></h2>
                            </div>
                            <div class="card-body text-center">
                                <img class="card-img-top imageThumbnail" 
                                src="<?php echo htmlspecialchars($coverpath); ?>" 
                                alt="<?php echo htmlspecialchars($book['title']); ?>" />

                                <h4>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></h4>
                                <h4>Author: <?php echo htmlspecialchars($book['author']); ?></h4>
                            </div>
                            <div class="card-footer text-center">
                                <a href="listBooks.php" class="btn btn-primary" >Back</a>
                                <a href="editBook.php?id=<?php echo htmlspecialchars($book['id']); ?>" class="btn btn-primary">Edit</a>
                                <form action="deleteBook.php" method="POST">
                                    <input type="hidden" name="id_to_delete" value="<?php echo $book['id']; ?>"/>
                                    <input type="submit" name="delete" value="Delete" class="btn btn-danger"/>
                                </form>
                                <!-- <a href="#" class="btn btn-danger">Delete</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row justify-content-center m-3">
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-header">
                                <h2>Ooops, book not found</h2>
                            </div>
                            <div class="card-footer text-center">
                                <a href="listBooks.php" class="btn btn-primary" >Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            </main>
        </div>
    </body>
    <?php include('../footer.php'); ?>
</html>
