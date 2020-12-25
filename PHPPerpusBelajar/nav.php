<header>
    <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
        <div class="container">
            <a class="navbar-brand" href="/PHPPerpusBelajar">
            <?php if (strpos($_SERVER['PHP_SELF'], 'index.php') !== false): ?>
                <img src="~/../assets/images/logo.jpg" width="100" height="50"/>
            <?php else: ?>
                <img src="~/../../assets/images/logo.jpg" width="100" height="50"/>
            <?php endif; ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse justify-content-between">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <?php if (strpos($_SERVER['PHP_SELF'], 'book/') !== false): ?>
                        <a class="nav-link text-dark" href="~/../listBooks.php">Book</a>
                    <?php elseif (strpos($_SERVER['PHP_SELF'], 'index.php') !== false): ?>
                        <a class="nav-link text-dark" href="~/../book/listBooks.php">Book</a>
                    <?php else: ?>
                        <a class="nav-link text-dark" href="~/../../book/listBooks.php">Book</a>
                    <?php endif; ?>
                    </li>
                    <?php if($user['user_role'] === 'ADMIN'): ?>
                    <li class="nav-item">
                        <?php if (strpos($_SERVER['PHP_SELF'], 'book/') !== false): ?>
                            <a class="nav-link text-dark" href="~/../addBook.php">Add New Book</a>
                        <?php elseif (strpos($_SERVER['PHP_SELF'], 'index.php') !== false): ?>
                            <a class="nav-link text-dark" href="~/../book/addBook.php">Add New Book</a>
                        <?php else: ?>
                            <a class="nav-link text-dark" href="~/../../book/addBook.php">Add New Book</a>
                        <?php endif; ?>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <!-- {% if user.is_authenticated %} -->
                    <li class="nav-item">
                        <a class="nav-link text-dark" href='#'>Welcome, <?php echo htmlspecialchars($user['username']); ?></a>
                    </li>
                    <?php if($user['user_role'] !== 'GUEST'): ?>
                    <li class="nav-item">
                        <form class='logout-link' 
                            <?php if (strpos($_SERVER['PHP_SELF'], 'user/') !== false): ?>
                                action="~/../logout.php"
                            <?php elseif (strpos($_SERVER['PHP_SELF'], 'index.php') !== false): ?>
                                action="~/../user/logout.php"
                            <?php else: ?>
                                action="~/../../user/logout.php"
                            <?php endif; ?>
                            method="POST">
                            <button type="submit"class="btn btn-link text-dark">Logout</button>
                        </form>
                    </li>
                    <?php else: ?>
                    <!-- {% else %} -->
                    <li class="nav-item">
                        <?php if (strpos($_SERVER['PHP_SELF'], 'user/') !== false): ?>
                            <a class="nav-link text-dark" href="~/../signup.php">Signup</a>
                        <?php elseif (strpos($_SERVER['PHP_SELF'], 'index.php') !== false): ?>
                            <a class="nav-link text-dark" href="~/../user/signup.php">Signup</a>
                        <?php else: ?>
                            <a class="nav-link text-dark" href="~/../../user/signup.php">Signup</a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <?php if (strpos($_SERVER['PHP_SELF'], 'user/') !== false): ?>
                            <a class="nav-link text-dark" href="~/../login.php">Login</a>
                        <?php elseif (strpos($_SERVER['PHP_SELF'], 'index.php') !== false): ?>
                            <a class="nav-link text-dark" href="~/../user/login.php">Login</a>
                        <?php else: ?>
                            <a class="nav-link text-dark" href="~/../../user/login.php">Login</a>
                        <?php endif; ?>
                    </li>
                    <?php endif; ?>
                    <!-- {% endif %} -->
                </ul>
            </div>
        </div>
    </nav>
</header>