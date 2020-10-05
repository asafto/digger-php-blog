<?php 

session_start();

if( isset($_SESSION['user_id']) ){
  header('location: blog.php');
}

require_once 'app/helpers.php';

$page_title = 'Signup Page';
$error = ['name'=> '', 'email' => '', 'password' => '', 'submit' => '',];

if( isset($_POST['submit']) ){

  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  mysqli_query($link, "SET NAMES utf8");

  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $name = trim($name);
  $name = mysqli_real_escape_string($link, $name);

  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $email = trim($email);
  $email = mysqli_real_escape_string($link, $email);

  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $password = trim($password);
  $password = mysqli_real_escape_string($link, $password);

  $form_valid = true;

  if( ! $name || mb_strlen($name) < 2 || mb_strlen($name) > 70 ){
    $error['name'] = 'Name is required for 2-70 chars';
    $form_valid = false;
  }

  if( ! $email ){
    $error['email'] = 'A valid email is required';
    $form_valid = false;
  } else if( email_exist($link, $email) ){
    $error['email'] = 'Email is taken';
    $form_valid = false;
  }

  if( ! $password || strlen($password) < 6 || strlen($password) > 20 ){
    $error['password'] = 'Password is required for 6-20 chars';
    $form_valid = false;
  }

  if( $form_valid ){

    $profile_image = 'default-profile.png';

    if ( isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) {
        
        if (validate_image($_FILES)) {
            $profile_image = str_replace('_', '-', $_FILES['image']['name']);
            $profile_image = date('d.m.Y.H.i.s') . '_' . str_rand(5) . '_' . $_FILES['image']['name'];

            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $profile_image);
        }
    }
    
    $password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users VALUES(null, '$name', '$email', '$password', '$profile_image')";
    $result = mysqli_query($link, $sql);

    if( $result && mysqli_affected_rows($link) > 0 ){

      $_SESSION['user_id'] = mysqli_insert_id($link);
      $_SESSION['user_name'] = $name;
      header('location: blog.php');

    }

  }

}

?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900 main">
    <div class="container">
        <section id="top-content">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="display-4">Open Your Digger Account</h1>
                    <p>
                        <a href="signin.php">Go To Signin Page</a>
                    </p>
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
                            <input value="<?= old('name'); ?>" type="text" name="name" id="name" class="form-control">
                            <span class="text-danger"><?= $error['name']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">* Email:</label>
                            <input value="<?= old('email'); ?>" type="email" name="email" id="email"
                                class="form-control">
                            <span class="text-danger"><?= $error['email']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">* Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <span class="text-danger"><?= $error['password']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="image">Profile Image:</label>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="image" id="image" class="custom-file-input">
                                <label class="custom-file-label overflow-hidden" for="inputGroupFile01">Choose
                                    file</label>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Signup</button>
                        <span class="text-danger"><?= $error['submit']; ?></span>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
