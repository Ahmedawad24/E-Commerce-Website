<?php
	

	/*

	 =====================================================
	 === Manage Comments page
	 === you can  EDIT | DELETE Comment from here
	 =====================================================

	*/

	 session_start();
	 $pageTitle= 'Comments';

	if(isset($_SESSION['username']))
	{
         include 'init.php';

         $do = isset($_GET['do']) ? $_GET['do']:'Manage';

         if($do == 'Manage') // Manage members page
         {

         	$stmt = $db->prepare("SELECT 
         							comments.*,items.Name AS itemname,users.name AS username
         							FROM 
         							    comments
         							INNER JOIN 
         								items
         							ON 
         								items.itemID=comments.item_id
         							INNER JOIN 
         								users
         							ON 
         								users.id=comments.user_id");
         	$stmt->execute();
         	$rows = $stmt->fetchAll();
         	?>
         	<h1 class="text-center">Manage Comments</h1>
	         <div class="container">
	         	<div class="table-responsive">
	         		<table class="main-table table table-bordered text-center">
	         			<tr>
	         				<td>ID</td>
	         				<td>Comment</td>
	         				<td>Item Name</td>
	         				<td>Username</td>
	         				<td>Added Date</td>
	         				<td>Control</td>
	         			</tr>
	         			<?php foreach ($rows as $row) {
	         				echo "<tr>";
	         					echo "<td>" . $row['c_id'] . "</td>";
	         					echo "<td>" . $row['comment'] . "</td>";
	         					echo "<td>" . $row['itemname'] . "</td>";
	         					echo "<td>" . $row['username'] . "</td>";
	         					echo "<td>". $row['added_date'] ."</td>";
	         					echo "<td>

	         						<a href='comments.php?do=Edit&comid=".$row['c_id'] ."'class='btn btn-success'> <i class='fa fa-edit'> </i> Edit </a>
	         						<a href='comments.php?do=Delete&comid=".$row['c_id'] ."'class='btn btn-danger confirm '> <i class='fa fa-times'> </i> Delete </a>";

                                    if($row['status']==0)
                                    {
                                       echo "<a href='comments.php?do=approve&comid=".$row['c_id'] ."'class='btn btn-info approve'> <i class='fa fa-check'> </i> Approve </a>";
                                    }

	         					 echo "</td>";

	         				echo "</tr>";
	         			} ?>
	         			
	         			
	         		</table>
	         	</div>
	         	
	         </div>
     
         	
   <?php }
        
         elseif ($do == 'Edit'){
         	$comid=(isset($_GET['comid'])&& is_numeric($_GET['comid'])) ? intval($_GET['comid']):0;

         	$stmt= $db-> prepare("SELECT * FROM comments Where c_id=? LIMIT 1");

			$stmt-> execute(array($comid));
			$row = $stmt->fetch();
			$ct= $stmt->rowCount();
			if($ct>0)
			{?>


	         	<h1 class="text-center">Edit comment</h1>
	         	<div class="container">
	         		<form class="form-horizontal" action="?do=update" method="POST">
	         			<input type="hidden" name="comid" value="<?php echo $comid ?>">
	         			<!-- Start username -->
	         			<div class="form-group form-group-lg">
	         				<label class="col-sm-2 control-label">Comment</label>
	         				<div class="col-sm-10 col-md-4">
	         					<textarea name="comment" class="form-control" > <?php echo $row['comment']?> </textarea>
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
           	  redirect('<div class="alert alert-danger">There is no such ID </div>','comments.php');

           }
    	}
    	elseif ($do=='update') 
    	{
    		

    		if($_SERVER['REQUEST_METHOD']=='POST')
    		{
    			echo "<h1 class='text-center'>update Comment</h1>";

    			echo "<div class='container'>";
    			//get var from form 

    			$id 		=$_POST['comid'];
    			$comment 	= $_POST['comment'];
    			//password trick
    			


    			
    		
    			$stmt =$db->prepare("UPDATE comments SET comment=? WHERE c_id=?");
	    		$stmt-> execute(array($comment,$id));
	    		redirect("<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Updated'."</div>",'comments.php');
	    			
    			echo "</div>";

    		}
    		else
    		{
    			redirect('<div class="alert alert-danger">you cant browse this page directly </div>');
    		}
    	}
    	elseif ($do=='Delete') {
    		echo "<h1 class='text-center'>Delete comment</h1>";
    			echo "<div class='container'>";
    		
			$comid=(isset($_GET['comid'])&& is_numeric($_GET['comid'])) ? intval($_GET['comid']):0;

         	$stmt= $db-> prepare("SELECT * FROM comments Where c_id=? LIMIT 1");

			$stmt-> execute(array($comid));
			$ct= $stmt->rowCount();
			if($ct>0) 
			{
				$stmt= $db-> prepare("DELETE FROM comments WHERE c_id=?");
				$stmt->execute(array($comid));
				echo "<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Deleted'."</div>";

			}   		
			echo "</div>";
			redirect('','back',1);

    	}
        elseif ($do='approve') {
            
            $comid=(isset($_GET['comid'])&& is_numeric($_GET['comid'])) ? intval($_GET['comid']):0;
            $stmt =$db->prepare("UPDATE comments SET status =? WHERE  c_id=?");
            $stmt->execute(array(1,$comid));
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