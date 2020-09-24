<?php 

session_start();// creates a session id cookie for the user in the browser

if( ! isset($_SESSION['user_id']) ) {
    header('location: signin.php');
}

require_once 'app/helpers.php';

$page_title = 'Add Post Form';

?>
<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
    <div class="container">
        <section id="top-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="display-4">Add Your New Post Here</h1>
                    <p>Fill the title and article</p>
                </div>
            </div>
        </section>
        <section id="add-post-form">
            <div class="row">
                <div class="col-lg-6 mt-3">
                    <form action="" method="POST" autocomplete="off" novalidate="novalidate">
                        <div class="form-group">
                            <label for="title">* Title</label>
                            <input value="<?= old('title'); ?>" type="text" name="title" id="title"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="article">* Article</label>
                            <textarea class="form-control" name="article" id="article" cols="30"
                                rows="10"><?= old('article'); ?></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Save Post</button>
                        <a class="btn btn-secondary" href="blog.php">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    </div>
</main>
<?php include 'tpl/footer.php'; ?>
