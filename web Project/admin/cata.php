<?php
     ob_start();
	 session_start();
	 $pageTitle= 'Categories';

	if(isset($_SESSION['username']))
	{
         include 'init.php';

         $do = isset($_GET['do']) ? $_GET['do']:'Manage';

         if($do == 'Manage') // Manage members page
         {
           $stmt=$db->prepare("SELECT * FROM categories ORDER BY ID DESC");
           $stmt->execute();
           $cats = $stmt->fetchAll(); ?>

            <h1 class="text-center">  Manage Categories </h1>
            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-edit"></i> Manage Categories</div>
                    <div class="panel-body">
                        <?php

                        foreach($cats as $key)
                        {
                           
                            echo "<div class='cat'>";
                                 echo "<div class='hidden-but'>";
                                     echo "<a href='cata.php?do=Edit&catid=". $key['ID'] ."' class='btn btn-xs btn-success '><i class='fa fa-edit'></i> Edit</a>";
                                    echo "<a href='cata.php?do=Delete&catid=". $key['ID'] ."' class='btn btn-xs btn-danger confirm '><i class='fa fa-times'></i> Delete</a>";
                                 echo "</div>";
                                echo '<h3>' . $key['Name'] ."</h3>";

                                echo "<div class='full-view'>";
                                    echo  "<p >"; if($key['Description']==''){echo "this category has no description";}else{echo $key['Description'];} echo"</p>";
                                    if($key['Visibility']==1){echo '<span class=" visibility">Hidden</span>';} 
                                    if($key['Allow_comment']==1){echo '<span class=" commenting">Comment Disable </span>';} 
                                echo "</div>";
                            echo "</div>";
                            echo "<hr>";
                        }
                        ?>


                        
                    </div>
                </div>
                <a href='cata.php?do=Add' class="btn btn-primary"><i class='fa fa-plus'></i> new Category</a>
            </div>

           <?php
         }
         elseif ($do=='Add') {?>

         		<h1 class="text-center">Add New Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                        <!-- Start Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="name" class="form-control"  autocomplete='off' required='required'>
                            </div>
                        </div>

                        <!-- Start Description -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="description" class=" password form-control">
                               
                            </div>
                        </div>

                            <!-- Start Ordering -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="ordering" class="form-control">
                            </div>
                        </div>

                            <!-- Start Visibility -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible</label>
                            <div class="col-sm-10 col-md-4">
                               <div>
                                   <input id="vis-yes" type="radio" name="visible" value="0" checked>
                                   <label for="vis-yes">Yes</label>
                               </div>
                               <div>
                                   <input id="vis-no" type="radio" name="visible" value="1">
                                   <label for="vis-no">No</label>
                               </div>
                            </div>
                        </div>
                             <!-- Start Commenting -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Commenting</label>
                            <div class="col-sm-10 col-md-4">
                               <div>
                                   <input id="com-yes" type="radio" name="commenting" value="0" checked>
                                   <label for="com-yes">Yes</label>
                               </div>
                               <div>
                                   <input id="com-no" type="radio" name="commenting" value="1">
                                   <label for="com-no">No</label>
                               </div>
                            </div>
                        </div>
                        
                            <!-- Start submit -->
                        <div class="form-group form-group-lg">
                            
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Category" class="btn btn-danger btn-lg ">
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
                echo "<h1 class='text-center'>Insert Category</h1>";
                echo "<div class='container'>";

                $name           =$_POST['name'];
                $description    =$_POST['description'];
                $ordering       =$_POST['ordering'];
                $visible        =$_POST['visible'];
                $commenting     =$_POST['commenting'];
                

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
                                               categories(Name,Description,Ordering,Visibility,Allow_comment)
                                               VALUES(:zname, :zdesc, :zorder, :zvis, :zallow)");
                    $stmt->execute(array(

                        'zname' => $name,
                        'zdesc'=> $description,
                        'zorder'=> $ordering,
                        'zvis'=>$visible,
                        'zallow'=>$commenting
                        
                    ));

                    redirect("<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Added'."</div>",'cata.php');

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

            $catid=(isset($_GET['catid'])&& is_numeric($_GET['catid'])) ? intval($_GET['catid']):0;

            $stmt= $db-> prepare("SELECT * FROM categories Where ID=?");

            $stmt-> execute(array($catid));
            $row = $stmt->fetch();
            $ct= $stmt->rowCount();
            if($ct>0)
            {?>
                <h1 class="text-center">Edit Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                        <!-- Start Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="Hidden" name="id" value="<?php echo $catid ?>">
                                <input type="text" name="name" class="form-control"  autocomplete='off' required='required' value="<?php echo $row['Name'];?>">
                            </div>
                        </div>

                        <!-- Start Description -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="description" class=" password form-control" value="<?php echo $row['Description'];?>">
                               
                            </div>
                        </div>

                            <!-- Start Ordering -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="ordering" class="form-control"value="<?php echo $row['Ordering'];?>" >
                            </div>
                        </div>

                            <!-- Start Visibility -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible</label>
                            <div class="col-sm-10 col-md-4">
                               <div>
                                   <input id="vis-yes" type="radio" name="visible" value="0" checked>
                                   <label for="vis-yes">Yes</label>
                               </div>
                               <div>
                                   <input id="vis-no" type="radio" name="visible" value="1">
                                   <label for="vis-no">No</label>
                               </div>
                            </div>
                        </div>
                             <!-- Start Commenting -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Commenting</label>
                            <div class="col-sm-10 col-md-4">
                               <div>
                                   <input id="com-yes" type="radio" name="commenting" value="0" checked>
                                   <label for="com-yes">Yes</label>
                               </div>
                               <div>
                                   <input id="com-no" type="radio" name="commenting" value="1">
                                   <label for="com-no">No</label>
                               </div>
                            </div>
                        </div>
                        
                            <!-- Start submit -->
                        <div class="form-group form-group-lg">
                            
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Update" class="btn btn-danger btn-lg ">
                            </div>
                        </div>


                    </form>
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

                $name           =$_POST['name'];
                $description    =$_POST['description'];
                $ordering       =$_POST['ordering'];
                $visible        =$_POST['visible'];
                $commenting     =$_POST['commenting'];
                $id             =$_POST['id'];
                //password trick
             
                //Update database with this info



                
                
                    $stmt =$db->prepare("UPDATE categories SET Name=?, Description=?, Ordering=?, Visibility=?,Allow_comment=? WHERE ID=?");
                    $stmt-> execute(array($name,$description,$ordering,$visible,$commenting,$id ));
                    redirect("<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Updated'."</div>",'back');
               

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
            
            $catid=(isset($_GET['catid'])&& is_numeric($_GET['catid'])) ? intval($_GET['catid']):0;

            $stmt= $db-> prepare("SELECT * FROM categories Where ID=? LIMIT 1");

            $stmt-> execute(array($catid));
            $ct= $stmt->rowCount();
            if($ct>0) 
            {
                $stmt= $db-> prepare("DELETE FROM categories WHERE ID=?");
                $stmt->execute(array($catid));
                echo "<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Record Deleted'."</div>";

            }           
            echo "</div>";
            redirect('','back',1);

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
    