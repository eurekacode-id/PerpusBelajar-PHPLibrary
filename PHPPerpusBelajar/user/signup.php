<?php 
    $pagetitle = 'Login';

    include('../config/conn.php');

    $errors = array('username' => '', 'password' => '', 'confirmpassword' => '');
    $dberrors = '';

    $username = $password = $confirmpassword = '';

    if(isset($_POST['submit'])){
        if(empty($_POST['username'])){
            $errors['username'] = 'Username is required <br/>';
        }
        else{
            $username = $_POST['username'];
        }

        if(empty($_POST['password'])){
            $errors['password'] = 'Password is required <br/>';
        } else if(strlen($_POST['password']) < 2){
            $errors['password'] = 'Password should be two or more characters <br/>';
        }
        else{
            $password = $_POST['password'];
            if (empty($_POST['confirmpassword'])){
                $errors['confirmpassword'] = 'Please retype the password';
            } 
            else{
                $confirmpassword = $_POST['confirmpassword'];
                if($password !== $confirmpassword){
                    $errors['confirmpassword'] = 'Retyped password is not matched with password';
                }
            }
        }

        if(!array_filter($errors)){

            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            // create sql
            $sql = "INSERT INTO user(id, username, user_password, user_role) VALUES ('$username','$password','VISITOR')";

            // save to db
            if(mysqli_query($conn, $sql)){
                
                if(!empty($user)){
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $user['username'] = $username;
                    $user['user_role'] = 'VISITOR';
                    $_SESSION['user'] = $user;
                    header('Location: ~/../../index.php');
                } else{
                    $dberrors = 'Login failed: '.mysqli_error($conn);
                }
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
                <form class="site-form" action="signup.php" method="POST">
                    <div class="card-deck">
                        <div class="card">
                            <div class="card-header text-center"><h3>Signup</h3></div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        Username
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"/>
                                        <p><span class="text-danger"><?php echo $errors['username']; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        Password
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>"/>
                                        <p><span class="text-danger"><?php echo $errors['password']; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        Re-Type Password
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" name="confirmpassword" value="<?php echo htmlspecialchars($confirmpassword); ?>"/>
                                        <p><span class="text-danger"><?php echo $errors['confirmpassword']; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <p><span class="text-danger"><?php echo $dberrors; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Signup">
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