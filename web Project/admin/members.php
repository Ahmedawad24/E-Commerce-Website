<?php
	

	/*

	 =====================================================
	 === Manage Member page
	 === you can ADD | EDIT | DELETE members from here
	 =====================================================

	*/

	 session_start();
	 $pageTitle= 'Members';

	if(isset($_SESSION['username']))
	{
         include 'init.php';

         $do = isset($_GET['do']) ? $_GET['do']:'Manage';

         if($do == 'Manage') // Manage members page
         {

            $query=' ';

            if(isset($_GET['pending'])&&$_GET['pending']==0)
            {
                $query='AND Regstatus =0';
            }

         	$stmt = $db->prepare("SELECT * FROM users WHERE admin!=1 $query ORDER BY id DESC");
         	$stmt->execute();
         	$rows = $stmt->fetchAll();
            if(!empty($rows))
            {
             	?>
             	<h1 class="text-center">Manage Members</h1>
    	         <div class="container">
    	         	<div class="table-responsive">
    	         		<table class="main-table table table-bordered text-center">
    	         			<tr>
    	         				<td>#ID</td>
    	         				<td>Username</td>
    	         				<td>Email</td>
								 <td>Register Date</td>
								 <td>Control</td>
    	         			</tr>
    	         			<?php foreach ($rows as $row) {
    	         				echo "<tr>";
    	         					echo "<td>" . $row['id'] . "</td>";
    	         					echo "<td>" . $row['name'] . "</td>";
    	         					echo "<td>" . $row['email'] . "</td>";
    	         					
    	         					echo "<td>". $row['regDate'] ."</td>";
    	         					echo "<td>

    	         						<a href='members.php?do=Edit&userid=".$row['id'] ."'class='btn btn-success'> <i class='fa fa-edit'> </i> Edit </a>
    	         						<a href='members.php?do=Delete&userid=".$row['id'] ."'class='btn btn-danger confirm '> <i class='fa fa-times'> </i> Delete </a>";

                                       // if($row['Regstatus']==0)
                                      //  {
                                         //  echo "<a href='members.php?do=approve&userid=".$row['UserID'] ."'class='btn btn-info approve'> <i class='fa fa-check'> </i> Approve </a>";
                                       // }

    	         					 echo "</td>";

    	         				echo "</tr>";
    	         			} ?>
    	         			
    	         			
    	         		</table>
    	         	</div>
    	         	<a href='members.php?do=Add' class="btn btn-primary"><i class='fa fa-plus'></i> new member</a>
    	         	
    	         </div>
             <?php } 
                    else
                    {
                        echo "<div class='container'>";
                            echo "<div class='alert alert-info'>There's no record to show</div>";
                            echo "<a href='members.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> new member</a>";
                        echo "</div>";
                    }
             ?>
     
         	
   <?php }
         elseif ($do=='Add') {?>

         		<h1 class="text-center">Add New Member</h1>
	         	<div class="container">
	         		<form class="form-horizontal" action="?do=Insert" method="POST">
	         			<!-- Start username -->
	         			<div class="form-group form-group-lg">
	         				<label class="col-sm-2 control-label">Username</label>
	         				<div class="col-sm-10 col-md-4">
	         					<input type="text" name="username" class="form-control"  autocomplete='off' required='required'>
	         				</div>
	         			</div>

	         			<!-- Start Password -->
	         			<div class="form-group form-group-lg">
	         				<label class="col-sm-2 control-label">Password</label>
	         				<div class="col-sm-10 col-md-4">
	         					<input type="password" name="Password" class=" password form-control" autocomplete="new-password" required='required'>
	         					<i class="show-pass fa fa-eye fa-1x"></i>
	         				</div>
	         			</div>

	         				<!-- Start Email -->
	         			<div class="form-group form-group-lg">
	         				<label class="col-sm-2 control-label">E-mail</label>
	         				<div class="col-sm-10 col-md-4">
	         					<input type="email" name="email" class="form-control"  autocomplete='off' required='required'>
	         				</div>
	         			</div>

	         				
	         			
	         				<!-- Start submit -->
	         			<div class="form-group form-group-lg">
	         				
	         				<div class="col-sm-offset-2 col-sm-10">
	         					<input type="submit" value="Add Member" class="btn btn-danger btn-lg ">
	         				</div>
	         			</div>


	         		</form>
	         	</div>
         	
         <?php
     	 }
     	 // insert field
     	 elseif ($do=='Insert') {


     	 	if($_SERVER['REQUEST_METHOD']=='POST')
     	 	{
     	 		echo "<h1 class='text-center'>Insert Member</h1>";
    			echo "<div class='container'>";
    			$user 		=$_POST['username'];
    			$pass   	=$_POST['Password'];
    			$email 		=$_POST['email'];
    			$hashPass  = sha1($pass);
    			

	    		$formErr=array();

    			// validate the form

    			//username valaidate
    			if(strlen($user)<4)
    			{
    				$formErr[]='username cant be less than <strong>3 char</strong>';
    			}
    			if(strlen($user)>20)
    			{
    				$formErr[]='username cant be larger than <strong>20 char</strong>';
    			}
    			if(empty($user))
    			{
    				$formErr[]='user name can\'t be <strong>empty</strong>';
    			}
    			if(checkItem('name','users',$user)==1)
    			{
    					$formErr[]= ' sorry this user is <strong>Exist</strong>';

    			}

    			if(empty($email))
    			{
    				
    				$formErr[]='E-mail can\'t be <strong>empty</strong>';
    			}


    			if( strlen($pass)<7)
    			{
    				$formErr[]='Password can\'t be less than <strong>6</strong>';

    			}

    			if(empty($pass))
    			{
    				$formErr[]='Password can\'t be <strong>empty</strong>';

    			}
    			


    			//Insert to database with this info
    			if(empty($formErr))
    			{
    				$stmt =$db->prepare("INSERT INTO 
    					                       users(name,Password,email,regDate)
    					                       VALUES(:zuser, :zhashPass, :zemail,now())");
		    		$stmt->execute(array(

		    			'zuser' => $user,
		    			'zhashPass'=> $hashPass,
		    			'zemail'=> $email
		    			
		    		));
		    		redirect("<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Added'."</div>",'members.php');

    			}
    			else
    			{
    				foreach ($formErr as $Error) {

    					redirect('<div class="alert alert-danger text-center">' . $Error .'</div>');
    					
    				}
    				
    			}

    			echo "</div>";


     	 	}
     	 	else
     	 	{
     	 		//header('Location: ../layout/index.html');
     	 		// you can Increse waiting min
     	 		// 
     	 		redirect('<div class="alert alert-danger">you cant browse this page directly </div>');
     	 	}
         }
         elseif ($do == 'Edit'){
         	$userid=(isset($_GET['userid'])&& is_numeric($_GET['userid'])) ? intval($_GET['userid']):0;

         	$stmt= $db-> prepare("SELECT * FROM users Where id=? LIMIT 1");

			$stmt-> execute(array($userid));
			$row = $stmt->fetch();
			$ct= $stmt->rowCount();
			if($ct>0)
			{?>


	         	<h1 class="text-center">Edit Member</h1>
	         	<div class="container">
	         		<form class="form-horizontal" action="?do=update" method="POST">
	         			<input type="hidden" name="userid" value="<?php echo $userid ?>">
	         			<!-- Start username -->
	         			<div class="form-group form-group-lg">
	         				<label class="col-sm-2 control-label">Username</label>
	         				<div class="col-sm-10 col-md-4">
	         					<input type="text" name="username" class="form-control" value="<?php echo $row['name'] ?>" autocomplete='off' required='required'>
	         				</div>
	         			</div>

	         			<!-- Start Password -->
	         			<div class="form-group form-group-lg">
	         				<label class="col-sm-2 control-label">Password</label>
	         				<div class="col-sm-10 col-md-4">
	         					<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
	         					<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="leave blank if you dont want change">
	         				</div>
	         			</div>

	         				<!-- Start Email -->
	         			<div class="form-group form-group-lg">
	         				<label class="col-sm-2 control-label">E-mail</label>
	         				<div class="col-sm-10 col-md-4">
	         					<input type="email" name="email" class="form-control" value="<?php echo $row['email'] ?>" autocomplete='off' required='required'>
	         				</div>
	         			</div>



	         				<!-- Start submit -->
	         			<div class="form-group form-group-lg">
	         				
	         				<div class="col-sm-offset-2 col-sm-10">
	         					<input type="submit" value="save" class="btn btn-danger btn-lg ">
	         				</div>
	         			</div>


	         		</form>
	         	</div>
         	
        <?php 

           }
           else
           {
           	  echo "there is no such ID";
           }
    	}
    	elseif ($do=='update') 
    	{
    		

    		if($_SERVER['REQUEST_METHOD']=='POST')
    		{
    			echo "<h1 class='text-center'>update Member</h1>";

    			echo "<div class='container'>";
    			//get var from form 

    			$id 	=$_POST['userid'];
    			$user 	=$_POST['username'];
    			$email 	=$_POST['email'];
    			//password trick
    			if(empty($_POST['newpassword']))
    			{
    				$pass=$_POST['oldpassword'];
    			}
    			else
    			{

    				$pass=sha1($_POST['newpassword']);


    			}
    			$formErr=array();

    			// validate the form

    			//username valaidate
                //check if user is exise
                 $stmt2=$db->prepare("SELECT * FROM users WHERE name=? AND id!=?");
                 $stmt2->execute(array($user,$id));
                 $count = $stmt2->rowCount();
                 //..........................

                if($count==1)
                {
                    $formErr[]='This user is <strong> exist </strong>';
                }
    			if(strlen($user)<4)
    			{
    				$formErr[]='username cant be less than <strong>3 char</strong>';
    			}
    			if(strlen($user)>20)
    			{
    				$formErr[]='username cant be larger than <strong>20 char</strong>';
    			}
    			if(empty($user))
    			{
    				$formErr[]='user name can\'t be <strong>empty</strong>';
    			}
    			
    			//username valaidate
    		
    			if(empty($email))
    			{
    				
    				$formErr[]='E-mail can\'t be <strong>empty</strong>';
    			}

    			//Update database with this info



    			if(empty($formErr))
    			{


                    
    				$stmt =$db->prepare("UPDATE users SET name=?, email=?, Password=? WHERE id=?");
	    			$stmt-> execute(array($user,$email,$pass,$id ));
	    			redirect("<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Updated'."</div>",'back');
    			}
    			else
    			{
    				foreach ($formErr as $Error) {
    					
                        redirect("<div class='alert alert-danger text-center'>" . $Error .'</div>','back');

    				}
    			}

    			echo "</div>";



    		}
    		else
    		{
    			redirect('<div class="alert alert-danger">you cant browse this page directly </div>');
    		}
    	}
    	elseif ($do=='Delete') {
    		echo "<h1 class='text-center'>Delete Member</h1>";
    			echo "<div class='container'>";
    		
			$userid=(isset($_GET['userid'])&& is_numeric($_GET['userid'])) ? intval($_GET['userid']):0;

         	$stmt= $db-> prepare("SELECT * FROM users Where id=? LIMIT 1");

			$stmt-> execute(array($userid));
			$ct= $stmt->rowCount();
			if($ct>0) 
			{
				$stmt= $db-> prepare("DELETE FROM users WHERE id=?");
				$stmt->execute(array($userid));
				echo "<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Deleted'."</div>";

			}   		
			echo "</div>";
			redirect('','back',1);

    	}
        elseif ($do='approve') {
            
            $userid=(isset($_GET['userid'])&& is_numeric($_GET['userid'])) ? intval($_GET['userid']):0;
            $stmt =$db->prepare("UPDATE users SET Regstatus =? WHERE  UserID=?");
            $stmt->execute(array(1,$userid));
            echo "<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Approved'."</div>";
            redirect('','back',1);


        }

         include $tpl . 'footer.php';
			
	}
	else
	{
		redirect('<div class="alert alert-danger">you cant browse this page directly </div>');
		exit();
	}