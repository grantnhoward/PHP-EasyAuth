<div id="nav">
	<?php if(isset($_SESSION['user'])){?>
		<a href="/home.php">Home</a> |
		<a href="/logout.php">Logout</a>
	<?php }else{?>
		<a href="/index.php">Home</a> |
		<a href="/register.php">Register</a> |
		<a href="/login.php">Login</a>
	<?php }?>
</div>