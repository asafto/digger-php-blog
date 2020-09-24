<?php 

session_start();// creates a session id cookie for the user in the browser

if (isset ($_SESSION['user_id']) ) {
    header('location: blog.php');
}

require_once 'app/helpers.php';

    $page_title = 'About Us';
    $error = ['email' => '', 'password' => '', 'submit' => '', ];
    //if submit was clicked
    if( isset($_POST['submit'] )) {
        // collecting the information from the form into variables
       $email = !empty ($_POST['email']) ? trim($_POST['email']) : ''; 
       
       $password = !empty ($_POST['password']) ? trim($_POST['password']) : '';

       $form_valid = true;
       
       // populating error messages in the errors array in case email or password were not provided
       if ( ! $email ) {
          $error['email'] = 'A valid email is required';
          $form_valid = false;
        }
        if ( ! $password ) {
            $error['password'] = 'A valid password is required';
            $form_valid = false;
       }
       
       //checking if the email and password are for valid user based on the mysql users table
       if ( $form_valid ) {
           
           $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
            
           $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
           
           //mysqli query will return false if the query is wrong (bad table name or sql command, otherwise it will return an object with the results - might be still with 0 results - which is still a truthy object)
           $result = mysqli_query($link, $sql);
           if( $result && mysqli_num_rows($result) >0 ) {
               
               $user = mysqli_fetch_assoc($result);
               $_SESSION['user_id'] = $user['id'];
               $_SESSION['user_name'] = $user['name'];
               header('location: blog.php');
               
           } else {
               
                $error['submit'] = ' * Invalid email or password';
            
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
                    <h1 class="display-4">Sign in to your Digger Account</h1>
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
                            <input value="<?= old('email'); ?>" type=" email" name="email" id="email"
                                class="form-control">
                            <span class="text-danger">
                                <?= $error['email']; ?> </span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <span class="text-danger">
                                <?= $error['password']; ?>
                            </span>
                        </div>
                        <button type="submit" name="submit" class=" btn btn-primary d-block">Signin</button>
                        <span class="text-danger">
                            <?= $error['submit']; ?>
                        </span>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include 'tpl/footer.php'; ?>
