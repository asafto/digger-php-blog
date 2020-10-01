<?php 

session_start();

if( ! isset($_SESSION['user_id']) ){
  header('location: signin.php');
}

require_once 'app/helpers.php';

$uid = $_SESSION['user_id'];
$pid = $_GET['pid'] ?? null;

if( $pid && is_numeric($pid) ){

  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  mysqli_query($link, "SET NAMES utf8");
  $pid = mysqli_real_escape_string($link, $pid);
  $sql = "SELECT title,article FROM posts WHERE id = $pid AND user_id = $uid";
  $result = mysqli_query($link, $sql);

  if( $result && mysqli_num_rows($result) > 0 ){

    $post = mysqli_fetch_assoc($result);

  } else {

    header('location: blog.php');

  }

}

$page_title = 'Edit Post Form';
$error = ['title' => '', 'article' => '',];

if( isset($_POST['submit']) ){

  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $title = trim($title);
  $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $article = trim($article);
  $form_valid = true;

  if( ! $title || mb_strlen($title) < 2 ){
    $form_valid = false;
    $error['title'] = '* Title is reuqired for min 2 chars';
  }

  if( ! $article || mb_strlen($article) < 2 ){
    $form_valid = false;
    $error['article'] = '* Article is reuqired for min 2 chars';
  }

  if( $form_valid ){

    $uid = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($link, $title);
    $article = mysqli_real_escape_string($link, $article);

    // update record
    $sql = "UPDATE posts SET title = $title, article = $article WHERE id = $pid and user_id = $uid";
    
    mysqli_query($link, $sql);
    header('location: blog.php');

  }

}

?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
    <div class="container">
        <section id="top-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="display-4">Edit your post here</h1>
                </div>
            </div>
        </section>
        <section id="add-post-form">
            <div class="row">
                <div class="col-lg-6 mt-3">
                    <form action="" method="POST" autocomplete="off" novalidate="novalidate">
                        <div class="form-group">
                            <label for="title">* Title</label>
                            <input value="<?= htmlentities($post['title']); ?>" type="text" name="title" id="title"
                                class="form-control">
                            <span class="text-danger"><?= $error['title']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="article">* Article</label>
                            <textarea class="form-control" name="article" id="article" cols="30"
                                rows="10"><?= $post['article']; ?></textarea>
                            <span class="text-danger"><?= $error['article']; ?></span>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Edit Post</button>
                        <a class="btn btn-secondary" href="blog.php">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
