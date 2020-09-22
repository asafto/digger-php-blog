<?php 
    $page_title = 'About Us';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
?>
<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
    <div class="container">
        <section id="top-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="display-4">Sign In to Your Digger</h1>
                    <p><a href="signup.php">Open a New Account</a></p>
                </div>
            </div>
        </section>
        <section id="signin-form">
            <div class="row">
                <div class="col-lg-6 mt-3">
                    <form action="" method="POST" autocomplete="off" novalidate="novalidate">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <button type="submit" name="submit" class=" btn btn-primary">Signin</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
