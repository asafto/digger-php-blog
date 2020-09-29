<?php 

session_start();// creates a session id cookie for the user in the browser

if( ! isset($_SESSION['user_id']) ) {
    header('location: signin.php');
}

require_once 'app/helpers.php';

$page_title = 'Add Post Form';
$error = ['title' => '', 'article' => '',];

if( isset($_POST['submit']) ){

    // $title = !empty($_POST['title']) ? trim($_POST['title']) : '';
    // $article = !empty($_POST['article']) ? trim($_POST['article']) : '';
    //preventing xss attack
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $title = trim($title);
    $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING);
    $article = trim($article);
    
    $form_valid = true;
  
    if( ! $title || mb_strlen($title) < 2 ){
  
      $form_valid = false;
      $error['title'] = '* Title requires minimum 2 charachters';
  
    }
  
    if( ! $article || mb_strlen($article) < 2 ){
  
      $form_valid = false;
      $error['article'] = '* Article requires minimum 2 characters';
  
    }
    
    if( $form_valid ) {
        
        $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
        mysqli_query($link, 'SET NAMES utf8');
        //mysqli_set_charset($link, 'utf8')
        $uid = $_SESSION['user_id'];
        //preventing sql injection to user inputs
        $title = mysqli_real_escape_string($link, $title);
        $article = mysqli_real_escape_string($link, $article);
        //end of sql injection prevention
        $sql = "INSERT INTO posts VALUES(null, $uid, '$title', '$article', NOW())";
        
        $result = mysqli_query($link, $sql);
        
        if ( $result && mysqli_affected_rows($link) > 0 ) {
            
            header('location: blog.php');
            
        }
    }
  
  }
  

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
                            <span class="text-danger">
                                <?= $error['title']; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="article">* Article</label>
                            <textarea class="form-control" name="article" id="article" cols="30"
                                rows="10"><?= old('article'); ?></textarea>
                            <span class="text-danger">
                                <?= $error['article']; ?>
                            </span>
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
