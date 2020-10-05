<?php 

session_start();

if( ! isset($_SESSION['user_id']) ){
    header('location: blog.php');
}

require_once 'app/helpers.php';

$uid = $_GET['uid'] ?? null;

if ( $uid && is_numeric($uid) ) {
    
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    mysqli_query($link, "SET NAMES utf8");
    $uid = mysqli_real_escape_string($link, $uid);
    $sql = "SELECT * FROM users WHERE id = $uid";
    $result = mysqli_query($link, $sql);
    
    if ( $result && mysqli_num_rows($result) > 0 ) {
        
        $user = mysqli_fetch_assoc($result);

        // echo '<pre>';
        // print_r($user);
        // echo '</pre>';
        // die;
        $current_name = $user['name'];
        $current_email = $user['email'];
        $current_password = $user['password'];
        $current_pic = $user['profile_image'];
        $presented_pic = explode('_', $current_pic);
        $presented_pic = $presented_pic[count($presented_pic) - 1];

        
    } else {
        
        header('location: blog.php');
        
    }
    
}


$page_title = 'User Profile';
$error = ['name'=> '', 'email' => '', 'upd-password' => '', 'submit' => '',];

if( isset($_POST['submit']) ){

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $name = trim($name);
    $name = mysqli_real_escape_string($link, $name);

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = trim($email);
    $email = mysqli_real_escape_string($link, $email);
    
    $password = $_POST['upd-password'];
    $password_check = false;
    
    if ($password !== $current_password) {
        
        $password = filter_input(INPUT_POST, 'upd-password', FILTER_SANITIZE_STRING);
        $password = trim($password);
        $password = mysqli_real_escape_string($link, $password);
        $password_check = true;
        
    }
  

    $form_valid = true;

    if( ! $name || mb_strlen($name) < 2 || mb_strlen($name) > 70 ){
        $error['name'] = 'Name is required for 2-70 chars';
        $form_valid = false;
    }

    if( ! $email ){
        $error['email'] = 'A valid email is required';
        $form_valid = false;
    } else if( $email !== $current_email && email_exist($link, $email) ){
        $error['email'] = 'Email is taken';
        $form_valid = false;
    }

    if ($password_check){
        
        if( ! $password || strlen($password) < 6 || strlen($password) > 20 ) {
            $error['upd-password'] = 'Password is required for 6-20 chars';
            $form_valid = false;
        }
        
    }

    if( $form_valid ){

        $profile_image = $current_pic;

    if ( isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) {
        
        if (validate_image($_FILES)) {
            $profile_image = date('d.m.Y.H.i.s') . '_' . str_rand(5) . '_' . $_FILES['image']['name'];
            
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $profile_image);
        }
    }
    
    if ($password_check) {
        
        $password = password_hash($password, PASSWORD_BCRYPT);
        
    }
    
    $sql = "UPDATE users SET name = '$name', email = '$email', password = '$password', profile_image = '$profile_image' WHERE id = $uid";
    $result = mysqli_query($link, $sql);

    $_SESSION['user_id'] = $uid;
    $_SESSION['user_name'] = $name;
    header('location: blog.php');

  }

}

?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900 main">
    <div class="container">
        <section id="top-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="display-4">Update Your User Details</h1>
                </div>
            </div>
        </section>
        <section id="signup-form">
            <div class="row">
                <div class="col-lg-6 mt-3">
                    <form action="" method="POST" autocomplete="off" novalidate="novalidate"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">* Name:</label>
                            <input value="<?= $current_name; ?>" type="text" name="name" id="name" class="form-control">
                            <span class="text-danger"><?= $error['name']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">* Email:</label>
                            <input value="<?= $current_email; ?>" type="email" name="email" id="email"
                                class="form-control">
                            <span class="text-danger"><?= $error['email']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="upd-password">* Password:</label>
                            <input type="password" name="upd-password" id="upd-password" class="form-control"
                                value="<?= $current_password; ?>" readonly>
                            <span class="text-danger"><?= $error['upd-password']; ?></span>
                        </div>
                        <div class=" form-group">
                            <label for="image">Profile Image:</label>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="image" id="image" class="custom-file-input">
                                <label class="custom-file-label overflow-hidden" for="inputGroupFile01">
                                    <?= $presented_pic ?></label>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary mr-2">Update Profile</button>
                        <a class="btn btn-secondary" href="blog.php">Cancel</a>
                        <span class="text-danger"><?= $error['submit']; ?></span>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
