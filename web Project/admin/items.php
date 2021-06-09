<?php


/* ========================================
            Item page
===========================================
*/



     ob_start();
	 session_start();
	 $pageTitle= 'items';

	if(isset($_SESSION['username']))
	{
         include 'init.php';

         $do = isset($_GET['do']) ? $_GET['do']:'Manage';

         if($do == 'Manage') // Manage members page
         {

            $stmt = $db->prepare("SELECT items.*,categories.Name AS Cat_Name FROM items
                                  INNER JOIN categories ON categories.ID = items.cat_ID 
                                  ORDER BY itemID DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows))
            {
                ?>
                <h1 class="text-center">Manage items</h1>
                 <div class="container">
                    <div class="table-responsive">
                        <table class="main-table table table-bordered text-center">
                            <tr>
                                <td>#ID</td>
                                <td>Name</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Adding Date</td>
                                <td>Cat_Name</td>
                                <td>Control</td>
                            </tr>
                            <?php foreach ($rows as $row) {
                                echo "<tr>";
                                    echo "<td>" . $row['itemID'] . "</td>";
                                    echo "<td>" . $row['Name'] . "</td>";
                                    echo "<td>" . $row['Description'] . "</td>";
                                    echo "<td>" . $row['price'] . "</td>";
                                    echo "<td>". $row['Add_Date'] ."</td>";
                                    echo "<td>". $row['Cat_Name'] ."</td>";
                                    echo "<td>

                                        <a href='items.php?do=Edit&courseid=".$row['itemID'] ."'class='btn btn-success'> <i class='fa fa-edit'> </i> Edit </a>
                                        <a href='items.php?do=Delete&courseid=".$row['itemID'] ."'class='btn btn-danger confirm '> <i class='fa fa-times'> </i> Delete </a>";
                                     echo "</td>";

                                echo "</tr>";
                            } ?>
                            
                            
                        </table>
                    </div>
                    <a href='items.php?do=Add' class="btn btn-primary"><i class='fa fa-plus'></i> new item</a>
                    
                 </div>

             <?php }else
             {
                echo "<div class='container'>";
                    echo "<div class='alert alert-info'>There's no record to show</div>";
                    echo "<a href='items.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> new item</a>";
                echo "</div>";
             }
              ?>
     
       <?php  }
         elseif ($do=='Add') {

         	?>

                <h1 class="text-center">Add New item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                        <!-- Start Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input 
                                       type="text" 
                                       name="name" 
                                       class="form-control"  
                                       required='required'>
                            </div>
                        </div>
                         <!-- Start Description -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input 
                                       type="text" 
                                       name="description" 
                                       class="form-control">
                            </div>
                        </div>
                        <!-- Start Price -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-4">
                                <input 
                                       type="text" 
                                       name="price" 
                                       class="form-control"
                                       required='required'>
                            </div>
                        </div>

                      <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Upload image</label>
                            <div class="col-sm-10 col-md-4">
                                <input 
                                       type="file" 
                                       name="image" >
                            </div>
                        </div>
                        <!-- Start Country -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Categories</label>
                            <div class="col-sm-10 col-md-4">
                              <select name="country">
                                 <option value="0">.....</option>
                                 <?php

                                    $stmt=$db->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    $cats =$stmt->fetchAll();
                                    foreach($cats as $cat)
                                    {
                                         echo "<option value='".$cat['ID'] ."'>".$cat['Name']."</option>";
                                    }
                                   
                                 ?>
                              </select>
                            </div>
                        </div>
                       
                        <!-- Start submit -->
                        <div class="form-group form-group-lg">
                            
                            <div class="col-sm-offset-2 col-sm-10">
                                <input 
                                      type="submit" 
                                      value="Add" 
                                      class="btn btn-danger btn-sm ">
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
                echo "<h1 class='text-center'>Insert Course </h1>";
                echo "<div class='container'>";
                $file=addslashes(file_get_contents($_FILES['image']['tmp_name']));
                $name           =$_POST['name'];
                $description    =$_POST['description'];
                $price          =$_POST['price'];
                $image          = $file;
                $country        =$_POST['country'];

                

                $formErr=array();
               
                if(checkItem('Name','categories',$name)==1)
                {
                        $formErr[]= ' sorry this user is <strong>Exist</strong>';

                }
                //username valaidate

                //Insert to database with this info
                if(empty($formErr))
                {
                    $stmt =$db->prepare("INSERT INTO 
                                               items(Name,Description,Price,Image,cat_ID,Add_Date)
                                               VALUES(:zname, :zdesc, :zprice, :zimage , :zcat,now())");
                    $stmt->execute(array(

                        'zname' => $name,
                        'zdesc'=> $description,
                        'zprice'=> $price,
                        'zimage'=> $image,
                        'zcat'=>$country
                        
                        
                    ));

                    redirect("<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Added'."</div>",'items.php');

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
                // you can Increse waiting min
                // 
                redirect('<div class="alert alert-danger">you cant browse this page directly </div>');
            }
     	 
         }
         elseif ($do == 'Edit'){

            $course=(isset($_GET['courseid'])&& is_numeric($_GET['courseid'])) ? intval($_GET['courseid']):0;

            $stmt= $db-> prepare("SELECT * FROM items Where itemID=? LIMIT 1");

            $stmt-> execute(array($course));
            $row = $stmt->fetch();
            $ct= $stmt->rowCount();
            if($ct>0)
            {?>


                <h1 class="text-center">Edit course</h1>
                <div class="container">
                     <form class="form-horizontal" action="?do=update" method="POST">
                        <!-- Start Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="hidden" name="ID" value="<?php echo $row['itemID']?>">
                                <input 
                                       type="text" 
                                       name="name" 
                                       class="form-control"
                                       value="<?php echo $row['Name']?>" 
                                       required='required'>
                            </div>
                        </div>
                         <!-- Start Description -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input 
                                       type="text" 
                                       name="description" 
                                       value="<?php echo $row['Description']?>"
                                       class="form-control">
                            </div>
                        </div>
                        <!-- Start Price -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-4">
                                <input 
                                       type="text" 
                                       name="price" 
                                       class="form-control"
                                       value="<?php echo $row['price']?>"
                                       required='required'>
                            </div>
                        </div>

                       <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Upload image</label>
                            <div class="col-sm-10 col-md-4">
                                <input 
                                       type="file" 
                                       name="image" 
                                       class="form-control"
                                       value="<?php echo $row['image']?>"
                                       >
                            </div>
                        </div>
                        <!-- Start Country -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">cata</label>
                            <div class="col-sm-10 col-md-4">
                              <select class="" name="country">
                                 <option value="0">.....</option>
                                 <?php

                                    $stmt=$db->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    $cats =$stmt->fetchAll();
                                    foreach($cats as $cat)
                                    {
                                         echo "<option value='".$cat['ID'] ."'>".$cat['Name']."</option>";
                                    }
                                   
                                 ?>
                              </select>
                            </div>
                        </div>
                       
                        <!-- Start submit -->
                        <div class="form-group form-group-lg">
                            
                            <div class="col-sm-offset-2 col-sm-10">
                                <input 
                                      type="submit" 
                                      value="update" 
                                      class="btn btn-danger btn-sm ">
                            </div>
                        </div>


                    </form>
                    <?php
                    $stmt = $db->prepare("SELECT 
                                        comment
                                    FROM 
                                        comments
                                    INNER JOIN 
                                        items
                                    ON 
                                        items.itemID=comments.item_id
                                    INNER JOIN 
                                        users
                                    ON 
                                        users.id=comments.user_id WHERE item_id=? ");
            $stmt->execute(array($course));
            $rows = $stmt->fetchAll();

            if(!empty($rows))
            {
            ?>
            <h1 class="text-center">Manage [<?php echo $row['Name']?>] Comments</h1>
                <div class="table-responsive">
                    <table class="main-table table table-bordered text-center">
                        <tr>
                            <td>Comment</td>
                            <td>Username</td>
                            <td>Added Date</td>
                            <td>Control</td>
                        </tr>
                        <?php foreach ($rows as $row) {
                            echo "<tr>";
                                echo "<td>" . $row['comment'] . "</td>";
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
                <?php } ?>
     
                </div>
            
        <?php 
            }
    	 }
    	elseif ($do=='update') 
    	{
    		
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                echo "<h1 class='text-center'>update Member</h1>";

                echo "<div class='container'>";
                //get var from form 
                $id             =$_POST['ID'];
                $name           =$_POST['name'];
                $description    =$_POST['description'];
                $price          =$_POST['price'];
                $country        =$_POST['country'];
                //password trick
               
                $formErr=array();

                // validate the form

                //username valaidate

              

                //Update database with this info



                if(empty($formErr))
                {
                    $stmt =$db->prepare("UPDATE items SET Name=?, Description=?, Price=?,cat_ID=? WHERE itemID=?");
                    $stmt-> execute(array($name,$description,$price,$country,$id));
                    redirect("<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Updated'."</div>",'back');
                    
                }
                else
                {
                    foreach ($formErr as $Error) {
                        echo '<div class="alert alert-danger text-center">' . $Error .'</div>' ;
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
            
            $courseid=(isset($_GET['courseid'])&& is_numeric($_GET['courseid'])) ? intval($_GET['courseid']):0;
            $stmt= $db-> prepare("SELECT * FROM items Where itemID=? LIMIT 1");
            $stmt-> execute(array($courseid));
            $ct= $stmt->rowCount();
            if($ct>0) 
            {
                $stmt= $db-> prepare("DELETE FROM items WHERE itemID=?");
                $stmt->execute(array($courseid));
                echo "<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Deleted'."</div>";

            }           
            echo "</div>";
            redirect('','back',1);
    	}
        elseif ($do='approve') {
            
           
        }
         include $tpl . 'footer.php';
			
	}
	else
	{
		redirect('<div class="alert alert-danger">you cant browse this page directly </div>');
		exit();
	}

    ob_end_flush();

    ?>