<?php

    $dsn  ='mysql:host=localhost;dbname=eshop'; //Data source name
    $user ='root'; // Data username
    $pass =''; // Data pass
    $options = array(

        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

    );
   

    try
    {
         $db= new PDO($dsn,$user,$pass,$options); // make the conection
         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "faild " . $e->getMessage();

    }



?>

