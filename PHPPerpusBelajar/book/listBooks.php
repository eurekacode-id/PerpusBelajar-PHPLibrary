<?php
    $pagetitle = 'List of Books';

    include('../config/conn.php');
    
    // write query
    $sql = 'SELECT id, title, author, isbn, cover from book';

    // make query & get result
    $result = mysqli_query($conn, $sql);

    // fetch the result
    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free up result resources
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('../header.php'); ?>
    <body class="d-flex flex-column min-vh-100">
        <?php include('../nav.php'); ?>
        <div class="container">
            <main role="main" class="pb-3">
            <div class="jumbotron">
                <div class="text-center">
                    <h3>
                        Enjoy the collections of TheLibrary!
                    </h3>
                </div>
            </div>
            <?php if($user['user_role'] === 'ADMIN'): ?>
            <div class="row">
                <a href="addBook.php" class="btn btn-success btn-block">Add new book</a>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="card-deck">
            <?php 
                    if(!empty($books)):
                        foreach($books as $book):
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
            ?>
                            <div class="card card-m3" style="min-width:18rem;max-width:30.5%;">
                                <div class="card-header"><h3><?php echo htmlspecialchars($book['title']); ?></h3></div>
                                <img class="card-img-top imageThumbnail" 
                                style="height:500px; width:auto;"
                                src="<?php echo $coverpath; ?>" 
                                alt="<?php echo htmlspecialchars($book['title']); ?>"/>
                                <div class="card-footer text-center">
                                    <a class="btn btn-primary" href="detailsBook.php?id=<?php echo htmlspecialchars($book['id']); ?>">View</a>
                                    <?php if($user['user_role'] === 'ADMIN'): ?>
                                    <a href="editBook.php?id=<?php echo htmlspecialchars($book['id']); ?>" class="btn btn-primary">Edit</a>
                                    <form action="deleteBook.php" method="POST">
                                        <input type="hidden" name="id_to_delete" value="<?php echo $book['id']; ?>"/>
                                        <input type="submit" name="delete" value="Delete" class="btn btn-danger"/>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                <?php   endforeach; ?>
            <?php   else: ?>
                        <p>Sorry, there is no book to display currently</p> 
            <?php   endif; ?>
                </div>
            </div>
            </main>
        </div>
    </body>
    <?php include('../footer.php'); ?>
</html>