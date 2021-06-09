
<?php
session_start();
	$pageTitle = 'login';
	include 'init.php';
?>
<div class = "abbod">
<p class="about"> About us</p>
<div class="aboutall">
    <div class="admin">
        <img src="image/magneto.jpg" />
        <p class="name"> Ahmed Awad </p>
        <p class="id"> ID: 185917</p>
    </div>
    <div class="admin">
        <img src="image/simone.jfif" />
        <p class="name"> Simone Moggi</p>
        <p class="id"> ID: 185919 </p>
    </div>
    <div class="admin">
        <img src="image/abdulrahman.jfif" />
        <p class="name"> Abdulrahman Mohamed </p>
        <p class="id"> ID: 181455</p>
    </div>
</div>
<div class="clear"></div>
<p class="abtitles"> About the admins</p>
<p class="abprgph"> This project is made by Ahmed , Simone , Abdulrahman, and was submitted to Dr. Hesham Mansour(Web Programming).</p>
<p class="abtitles"> About this website</p>
<p class="abprgph"> This website named "E-shop". E-shop is guitar shop. Now you can buy any guitar from your place without going out.</p>s

    </div>
    <?php
   include $tpl.'footer.php' 
   ?>