<?php 

session_start();// creates a session id cookie for the user in the browser

$page_title = 'User Profile';
?>
<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
    <div class="container">
        <section id="top-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="display-4">Change Your User Details</h1>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
