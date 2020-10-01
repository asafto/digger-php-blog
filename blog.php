<?php 

session_start();
require_once 'app/helpers.php';
$page_title = 'The Blog';

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
mysqli_query($link, "SET NAMES utf8");

$sql = "SELECT u.name,u.profile_image,p.* FROM posts p 
        JOIN users u ON u.id = p.user_id
        ORDER BY p.date DESC";

$result = mysqli_query($link, $sql);
$uid = $_SESSION['user_id'] ?? null;

?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
    <div class="container">
        <section id="top-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="display-4">View all posts</h1>
                    <p>
                        <?php if( isset($_SESSION['user_id']) ): ?>
                        <a class="btn btn-primary" href="add_post.php">+ Add New Post</a>
                        <?php else: ?>
                        <a href="signup.php">Open free account and add your post</a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </section>
        <?php if( $result && mysqli_num_rows($result) > 0 ): ?>
        <section id="posts-content" class="mb-5">
            <div class="row">
                <?php while($post = mysqli_fetch_assoc($result)): ?>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <img class="rounded-circle" src="images/<?= $post['profile_image']; ?>" width="40">
                            <span class="ml-2"><?= htmlentities($post['name']); ?></span>
                            <span class="float-right"><?= date('d/m/Y H:i:s', strtotime($post['date'])); ?></span>
                        </div>
                        <div class="card-body">
                            <h3><?= htmlentities($post['title']); ?></h3>
                            <p><?= str_replace("\n", '<br>', htmlentities($post['article'])); ?></p>
                            <?php if( $uid && $post['user_id'] == $uid ): ?>
                            <div class="float-right">
                                <a class="dropdown-toggle no-decoration no-arrow" href="#" role="button"
                                    id="dropdownMenuLink" data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="edit_post.php?pid=<?= $post['id']; ?>">
                                        <i class="fas fa-pen"></i>
                                        Edit
                                    </a>
                                    <a class="dropdown-item delete-post-btn"
                                        href="delete_post.php?pid=<?= $post['id']; ?>">
                                        <i class="fas fa-eraser"></i>
                                        Delete
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
