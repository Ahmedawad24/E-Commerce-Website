
<?php 

	session_start();
	$nonav='Admin';
	$pageTitle = 'login';
	if(isset($_SESSION['username']))
	{
		header("Location: dashboard.php");
		exit();
	}

	include "init.php";
	

	//Check if user coming from POST method

	if( $_SERVER['REQUEST_METHOD']=='POST')
	{

		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashedPass = sha1($password);

		$stmt= $db-> prepare("SELECT 
			                      id,name,password 
			                  FROM 
			                      users
			                  Where 
			                      name=? 
			                  AND 
			                      Password=? 
			                  AND 
			                      admin=1
			                  LIMIT 1");

		$stmt-> execute(array($username,$password));
		$row = $stmt->fetch();
		$ct= $stmt->rowCount();

		// if count > 0 this mean the database contain record about this user name.
		if($ct>0)
		{

			$_SESSION['username'] = $username;
			$_SESSION['ID'] = $row['id'];
			header("Location: dashboard.php");
			echo "<p> hello ". $_SESSION['username']."<p/>";
			$adminName=$username;
		    exit();


		}
		else
		{
			echo "<div class='container'>";
			echo '<div class="alert alert-danger text-center"> This user name not found in our database</div>';
			echo "</div>";
		}



	}
?>

	

	<form class="login" method="POST" action="index.php">

		<h4 class="text-center"> Admin Login</h4>
		<input type="text" 
			   class="form-control " 
			   name="username" 
			   placeholder="Username" 
			   autocomplete="off"/>

		<input type="password" 
	           class="form-control"
		       name="password"
		       placeholder="password" 
		       autocomplete="new-password" />

		<input type="submit" value="login" class="btn btn-success btn-block "/>
		
	</form>

<?php include $tpl . 'footer.php';?>
