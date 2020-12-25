<?php
    $pagetitle = 'Add New Book';
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
            
            $file_name = date("Ymdhis").'_'.$file_name;
            $extensions = array("jpeg","jpg","png");
            $target = "~/../../media/" .$file_name;

            if(in_array($file_ext,$extensions)=== false){
               $errors['cover']="extension not allowed, please choose a JPEG or PNG file.";
            } else if($file_size > 10000000){
               $errors['cover']='File size must be less than 10 MB';
            }
            if(empty($errors['cover'])){
                move_uploaded_file($file_tmp, $target);
            }
         }

        if(!array_filter($errors)){

            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $author = mysqli_real_escape_string($conn, $_POST['author']);
            $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
            $cover = mysqli_real_escape_string($conn, $file_name);

            // create sql
            $sql = "INSERT INTO book(title, author, isbn, cover) VALUES ('$title','$author','$isbn', '$cover')";

            // save to db
            if(mysqli_query($conn, $sql)){
                move_uploaded_file($file_tmp,"media/".$file_name);
                header('Location: listBooks.php');
            } else{
                $dberrors = 'Save data failed: '.mysqli_error($conn);
            }
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
                <form class="site-form" enctype="multipart/form-data" action="addBook.php" method="POST">
                    <div class="card-deck">
                        <div class="card">
                            <div class="card-header text-center"><h3>New Book</h3></div>
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
                                    <input type="submit" name="submit" class="btn btn-primary" value="Create">
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
