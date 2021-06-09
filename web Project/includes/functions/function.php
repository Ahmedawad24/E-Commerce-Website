

<?php

	/*
	*** function that echo page title 0.1v
	*** has varaiable $pagetitle and echo default title for othher page
	*/
	function getTitle()
	{
		global $pageTitle;
		if(isset($pageTitle))
		{
			echo $pageTitle;
		}
		else
		{
			echo "default";
		}
	};

	/*
	*** function that rediret link 0.2v
	*** you can put your msg ($thMsg)
	*** you can coustmize your waitng min
	*** add url
	*/

	function redirect($theMsg,$url='index.php',$sec=3)
	{

		if($url=='back')
		{
			if(isset($_SERVER['HTTP_REFERER'])&& !empty($_SERVER['HTTP_REFERER']))
			{
				$url=$_SERVER['HTTP_REFERER'];
			}

		}


		echo "<div class='container'>";

		echo $theMsg;

		echo "<div class='alert alert-info'>You will be redirected to $url after". $sec ."</div>";

		echo "</div>";
		header("refresh: $sec; url = $url");

	}




	 /*
	*** check if username exist or not 0.1v
	*** 
	*** 
	*/

	function checkItem($select,$from,$value)
	{
		global $db;
		$stmt= $db->prepare("SELECT $select FROM $from WHERE $select =?");
		$stmt->execute(array($value));
		$ct= $stmt->rowCount();

		return $ct;
	}


	/*
	*** funcation to calc number of items v 2.0
	*** $select = the row i would to count from the database
	*** $form   = name of table
	*/

	function calcItems($select,$from)
	{
		 global $db;
		 $query='';
		 if($select=='Regstatus')
		 {
		 	$query='WHERE Regstatus=0';
		 }
		 $stmt2 = $db->prepare("SELECT count($select) FROM $from $query");
         $stmt2->execute();
         $membersCt = $stmt2->fetchColumn();

         return $membersCt;
	}




	/*
	*** get latest item v 1.0
	*** $select = the name of [username,email,id] i wanna fetch
	*** $from.  = table's name
	*** $num.   = limit number [optional]
	*/

	function getLatest($select,$from,$order,$num=5)
	{
		global $db;
		 $query='';
		 if($from=='users')
		 {
		 	$query='WHERE GroupID = ?';
		 }
		$getStmt = $db->prepare("SELECT $select FROM $from  $query  ORDER BY $order DESC LIMIT $num " );
		$getStmt->execute(array(0));
		$rows = $getStmt->fetchAll();

		return $rows;

	}



























