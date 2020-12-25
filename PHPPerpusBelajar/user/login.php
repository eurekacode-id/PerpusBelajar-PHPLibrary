<?php 
    $pagetitle = 'Login';

    include('../config/conn.php');

    $errors = array('username' => '', 'password' => '');
    $dberrors = '';

    $username = $password = '';

    if(isset($_POST['submit'])){
        if(empty($_POST['username'])){
            $errors['username'] = 'Username is required <br/>';
        }
        else{
            $username = $_POST['username'];
        }

        if(empty($_POST['password'])){
            $errors['password'] = 'Password is required <br/>';
        }
        else{
            $password = $_POST['password'];
        }

        if(!array_filter($errors)){

            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            // create sql
            $sql = "SELECT username, user_role FROM user WHERE username = '$username' AND user_password = '$password'";

            // make query & get result
            $result = mysqli_query($conn, $sql);
            
            // fetch the result
            $user = mysqli_fetch_assoc($result);
            
            // free up result resources
            mysqli_free_result($result);
            
            // // close connection
            mysqli_close($conn);

            // $user['username'] = $username;
            // $user['user_role'] = 'ADMIN';
            if(!empty($user)){
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                $_SESSION['user'] = $user;
                header('Location: ~/../../index.php');
            } else{
                $dberrors = 'Login failed: '.mysqli_error($conn);
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
                <form class="site-form" action="login.php" method="POST">
                    <div class="card-deck">
                        <div class="card">
                            <div class="card-header text-center"><h3>Login</h3></div>
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
                                    <div class="col-md-12">
                                        <p><span class="text-danger"><?php echo $dberrors; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Login">
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