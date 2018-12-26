<?php
//Start Session
session_start();
//Config File
require 'config.php';
//Database Class
require 'classes/database.php';

$database = new Database;

//Set Timezone
date_default_timezone_set('America/New_York');
?>

<?php
  //LOG IN
  if($_POST['login_submit']){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $enc_password = md5($password);
    //Query
    $database->query("SELECT * FROM users WHERE username = :username AND password = :password");
    $database->bind(':username',$username);
    $database->bind(':password',$enc_password);
    $rows = $database->resultset();
    $count = count($rows);
    if($count > 0){
      session_start();
      //Assign session variables
      $_SESSION['username']   = $username;
      $_SESSION['password']   = $password;
      $_SESSION['logged_in']  = 1;
    } else {
      $login_msg[] = 'Sorry, that login does not work';
    }
  }


  //LOG OUT
  if($_POST['logout_submit']){
    if(isset($_SESSION['username']))
        unset($_SESSION['username']);
    if(isset($_SESSION['password']))
        unset($_SESSION['password']);
    if(isset($_SESSION['logged_in']))
        unset($_SESSION['logged_in']);
    session_destroy();
  }
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TaskBox</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/custom.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="fonts/glyphicons-halflings-regular.ttf">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script type="text/javascript" src="js/bootstrap.js"></script>
<script src="js/site.js"></script>

</head>
<body>


 <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="http://localhost/myListApp"><i class="fas fa-tasks"></i> TaskBox</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              <?php if($_SESSION['logged_in']) : ?>
                Hello, <?php echo $_SESSION['username']; ?>
            <?php endif; ?>
            </p>
            <ul class="nav">
              <!-- <li><a href="http://localhost/myListApp">Home</a></li>   -->
              <?php if(!$_SESSION['logged_in']) : ?>
                  <li><a href="index.php?page=register">Register</a></li>
              <?php else : ?>
  
                  <li><a href="index.php?page=new_list">Add List</a></li>
                  <li><a href="index.php?page=new_task">Add Task</a></li>
              <?php endif; ?>         
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
          <div>

          <h3>Login Form</h3>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
              <?php if(!$_SESSION['logged_in']) : ?>
                <?php foreach($login_msg as $msg) : ?>
                    <?php echo $msg.'<br />'; ?>
                <?php endforeach; ?>
                
                <input type="text" name="username" placeholder="Username..." /><br />
                
                <input type="password" name="password" placeholder="Password..." /><br />
                <br />
                <input class="btn btn-primary" type="submit" value="Login" name="login_submit" />
              <?php else : ?>
                <input class="btn btn-primary" type="submit" value="Logout" name="logout_submit" />
              <?php endif; ?>
          </form>
          </div>
          </div><!--/.well -->
        </div><!--/span-->

        <div class="span9">
    <?php
    if($_GET['msg'] == 'listdeleted'){
      echo "<div class='alert alert-danger'>
          Your List has been deleted
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
          </div>";
    }
    if($_GET['page'] == 'welcome' || $_GET['page'] == ""){
      include 'pages/welcome.php';
    } elseif($_GET['page'] == 'list'){
      include 'pages/list.php';
    } elseif($_GET['page'] == 'task'){
      include 'pages/task.php';
    } elseif($_GET['page'] == 'new_task'){
      include 'pages/new_task.php';
    } elseif($_GET['page'] == 'new_list'){
      include 'pages/new_list.php';
    } elseif($_GET['page'] == 'edit_task'){
      include 'pages/edit_task.php';
    } elseif($_GET['page'] == 'edit_list'){
      include 'pages/edit_list.php';
    } elseif($_GET['page'] == 'register'){
      include 'pages/register.php';
    } elseif($_GET['page'] == 'delete_list'){
      include 'pages/delete_list.php';
    }
    ?>
			
        </div><!--/span-->
		</div><!--/row-->
      <hr>

      <footer>
        <p id="footer">&copy; 2018 Parker Sipes</p>
      </footer>
    </div><!--/.fluid-container-->


</body>
</html>

