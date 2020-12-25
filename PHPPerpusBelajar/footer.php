<footer class="border-top footer text-muted mt-auto">
    <div class="container">
        &copy; <?php print date("Y"); ?> - TheLibrary on PHP with bootstrap
    </div>
</footer>

<?php if (strpos($_SERVER['PHP_SELF'], 'index.php') !== false): ?>
    <script src="~/../assets/js/jquery/jquery.min.js"></script>
    <!-- <script src="./PHPPerpusBelajarassets/js/popper.min.js'"></script> -->
    <script src="~/../assets/js/bootstrap/bootstrap.min.js"></script>
<?php else: ?>
    <script src="~/../../assets/js/jquery/jquery.min.js"></script>
    <!-- <script src="./PHPPerpusBelajarassets/js/popper.min.js'"></script> -->
    <script src="~/../../assets/js/bootstrap/bootstrap.min.js"></script>
<?php endif; ?>
