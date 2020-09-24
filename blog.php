<?php 

session_start();// creates a session id cookie for the user in the browser

$page_title = 'Blog Page'
?>
<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
    <div class="container">
        <section id="top-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="display-4">View All Posts</h1>
                    <p>
                        <?php if( isset($_SESSION['user_id'])): ?>
                        <a class="btn btn-primary" href="add_post.php">+ Add New Post</a>
                        <?php else: ?>
                        <a href="signup.php">Open free account and add your post</a>
                        <?php endif;?>
                    </p>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
