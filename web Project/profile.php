<!DOCTYPE >
<?php 

  session_start();
	$pageTitle = 'login';
	include 'init.php';
?>

    <div class="profile">
      <div class="myprofile">
      <p>My Profile</p>
</div>
    <div class="profileph">
        <img src="image/magneto.jpg" />
        <?php
        $stmt = $db->prepare("SELECT * FROM users");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>
        <div class="profilet">
      <h3>First name</h3>
      <p> <?php echo $_SESSION["user"]?> </p>
      <h3>Address</h3>
      <p>October</p>
</div>

        
    </div>
   <!-- Start of  Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=5b88d4fd-ecf9-4514-9f14-4719796e7db8"> </script>
<!-- End of  Zendesk Widget script -->
    </div>
    <div class="spotify">
    <iframe src="https://open.spotify.com/embed/user/t3qisbeluwzgr9zs8idwhebjo/playlist/4FNDbheK9MuTEdPmheFwB8" width="1400" height="70" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
    </div>
    <?php
   include $tpl.'footer.php' 
   ?>