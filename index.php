<?php 

session_start();// creates a session id cookie for the user in the browser

$page_title = 'Home Page';
?>
<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
    <div class="container">
        <div class="row">
            <section id="top-content">
                <div class="col-12 text-center mt-3">
                    <h1 class="display-4">Do you digg me?</h1>
                    <p>Forum blog for everybody</p>
                    <p>
                        <a href="signup.php" class="btn btn-outline-warning btn-lg">Join Us Now</a>
                    </p>
                </div>
            </section>
        </div>
        <section id="main-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <hr>
                    <p>Digger is my first php website implementation</p>
                    <p>You can view our blog through the link above, or contribute your posts by signing up
                        <a href="signup.php">here...</a>
                    </p>
                    <hr>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
