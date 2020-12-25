<?php 
    $pagetitle = 'Edit Book';

    include('../config/conn.php');

    $errors = array('title' => '', 'author' => '', 'isbn' => '', 'cover' => '');
    $dberrors = '';

    $title = $isbn = $author = $cover = '';

    if(isset($_POST['submit'])){
        if(empty($_POST['title'])){
            $errors['title'] = 'Title is required <br/>';
        }
        else{
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] = 'Title must be letters and spaces only <br/>';
            }
        }

        if(empty($_POST['author'])){
            $errors['author'] = 'Author is required <br/>';
        }
        else{
            $author = $_POST['author'];
        }

        if(empty($_POST['isbn'])){
            $errors['isbn'] = 'ISBN is required <br/>';
        }
        else{
            $isbn = $_POST['isbn'];
            if(!preg_match('/^\d{10}$/', $isbn)){
                $errors['isbn'] = 'ISBN must be 10 digit number <br/>';
            }
        }
        if(isset($_FILES['cover'])){
            $file_name = $_FILES['cover']['name'];
            $file_size = $_FILES['cover']['size'];
            $file_tmp = $_FILES['cover']['tmp_name'];
            $file_type = $_FILES['cover']['type'];
            $exploded = explode('.',$file_name);
            $file_ext = strtolower(end($exploded));
            
            $oldcover = $_POST['oldcover'];
            $oldcoverpath = '~/../../media/'.$oldcover;

            $file_name = date("Ymdhis").'_'.$file_name;
            $extensions = array("jpeg","jpg","png");
            $target = "~/../../media/" .$file_name;

            if(in_array($file_ext,$extensions) === false){
               $errors['cover']="extension not allowed, please choose a JPEG or PNG file.";
            } else if($file_size > 10000000){
               $errors['cover']='File size must be less than 10 MB';
            }
            if(empty($errors['cover'])){
                if (file_exists($oldcoverpath)){
                    unlink($oldcoverpath);
                }
                move_uploaded_file($file_tmp, $target);
            }
         }

        if(!array_filter($errors)){
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $author = mysqli_real_escape_string($conn, $_POST['author']);
            $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $cover = mysqli_real_escape_string($conn, $file_name);

            // create sql
            $sql = "UPDATE book SET title = '$title', author = '$author', isbn = '$isbn', cover = '$cover' where id = $id";

            // save to db
            if(mysqli_query($conn, $sql)){
                header('Location: listBooks.php');
            } else{
                $dberrors = 'Save data failed: '.mysqli_error($conn);
            }
        }
    }

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

        $title = $book['title'];
        $author = $book['author'];
        $isbn = $book['isbn'];
        $oldcover = $book['cover'];

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
            <form class="site-form" enctype="multipart/form-data" action="editBook.php" method="POST">
                    <div class="card-deck">
                        <div class="card">
                            <div class="card-header text-center"><h3>Edit Book</h3></div>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"/>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        Title
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"/>
                                        <p><span class="text-danger"><?php echo $errors['title']; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        ISBN
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>"/>
                                        <p><span class="text-danger"><?php echo $errors['isbn']; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        Author
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="author" value="<?php echo htmlspecialchars($author); ?>"/>
                                        <p><span class="text-danger"><?php echo $errors['author']; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        Old Cover
                                    </div>
                                    <div class="col-md-9">
                                        <input type="hidden" name="oldcover" id="oldcover" value="<?php echo htmlspecialchars($oldcover); ?>"/>
                                        <img class="card-img-top imageThumbnail"
                                        style="width:200px; height:auto;" 
                                        src="<?php echo $coverpath; ?>" 
                                        alt="<?php echo htmlspecialchars($book['title']); ?>"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        Book Cover
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" name="cover" id="cover"/>
                                        <span class="text-danger"><?php echo $errors['cover']; ?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <p><span class="text-danger"><?php echo $dberrors; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </body>
    <?php include('../footer.php'); ?>
</html>