<?php
        if (session_status() == PHP_SESSION_NONE) {
                session_start();
        }
        $user = ['username' => 'Guest', 'user_role' => 'GUEST'];
        if(!empty($_SESSION['user'])){
                $user = $_SESSION['user'];
        }
?>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP Library | <?php echo htmlspecialchars($pagetitle); ?></title>

<?php if (strpos($_SERVER['PHP_SELF'], 'index.php') !== false): ?>
        <link rel="stylesheet" type="text/css" href="~/../assets/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="~/../assets/css/site.css">
<?php else: ?>
        <link rel="stylesheet" type="text/css" href="~/../../assets/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="~/../../assets/css/site.css">
<?php endif; ?>


</head>