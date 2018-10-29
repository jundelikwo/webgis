<?php
	require_once '../../includes/config.php';
	require_once(LIB_PATH.DS."User.php");
    require_once(LIB_PATH.DS."Session.php");
	$layout_context = '';

	$username = '';
    $password = '';
    $error;

    if($_SERVER['REQUEST_METHOD'] === "POST" ){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $foundUser = User::authenticate($username,$password);
        if($foundUser){
            $session->login($foundUser);
            header("Location: index.php");
        }else{
        	$error = true;
        }
    }


    if($session->isLoggedIn()){
        header("Location: index.php");
    }

	require_once LAYOUT_PATH.DS.'header.php';
?>

	<div id="main">
		<div id="navigation">
		</div>
		<div id="page">
			<?php
				if(!empty($error)){
					echo '<div class="message">Username/password not found.</div>';
				}
			?>
			<h2>Login</h2>
			<form action="<?php echo SITE_LINK ?>admin/login.php" method="post">
		      <p>Username:
		        <input type="text" name="username" value="<?php echo $username ?>">
		      </p>
		      <p>Password:
		        <input type="password" name="password" value="">
		      </p>
		      <input type="submit" name="submit" value="Submit">
		    </form>
		</div>
	</div>

<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>