<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';
	include_once UTIL.'/validators.php';
	
	session_start();
	$results = array();
	
	if(isset($_SESSION['results'])){
		$results= $_SESSION['results'];
		unset($_SESSION['results']);
		session_destroy();
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link href="/view/css/style.css?v=<?php echo STATIC_VERSION;?>" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" ></script>
	
	<script type="text/javascript">
		$(document).ready(function () {
		  var validateUsername = $('#validateUsername');
		  var validateEmail = $('#validateEmail');
		  var validatePw = $('#validatePw');
		  
		  $('#username').blur(function() {
			    var t = this; 
			    validateUsername.removeClass('error').removeClass('success').html('<img src="/view/images/ajax.gif" height="16" width="16" /> validating...');
			      
		        $.ajax({
		          url: 'src/util/ajax.php',
		          data: 'action=checkUsername&username=' + t.value,
		          dataType: 'json',
		          type: 'post',
		          success: function (j) {
		            if(j.ok){
		            	validateUsername.html('<img src="/view/images/accept.png"/>').removeClass('error').addClass('success');
		            }
		            else{
		            	validateUsername.html('<img src="/view/images/exclamation.png"/> '+j.msg).removeClass('success').addClass('error');
		            }
		          }
		        });
			      
			 });

		  $('#password').blur(function(){
	          if(this.value.match("(?=^.{6,}$)")){
	          	validatePw.html('<img src="/view/images/accept.png"/>').removeClass('error').addClass('success');
	          }
	          else{
	          	validatePw.html('<img src="/view/images/exclamation.png"/> Minimum 6 characters.').removeClass('success').addClass('error');
	          }
	
		  });
	
	
		  $('#email').blur(function() {
			    var t = this; 
			    validateEmail.removeClass('error').removeClass('success').html('<img src="/view/images/ajax.gif" height="16" width="16" /> checking accounts...');
			      
		        $.ajax({
		          url: 'src/util/ajax.php',
		          data: 'action=checkEmail&email=' + t.value,
		          dataType: 'json',
		          type: 'post',
		          success: function (j) {
		            if(j.ok){
		            	validateEmail.html('<img src="/view/images/accept.png"/>').removeClass('error').addClass('success');
		            }
		            else{
		            	validateEmail.html('<img src="/view/images/exclamation.png"/> '+j.msg).removeClass('success').addClass('error');
		            }
		          }
		        });
			      
			 });
		});
	</script>
</head>
<body>
	<div id="wrapper">
	<?php include ELEMENTS.'/nav.php'; ?>
		<h1>Create New Account</h1>
		
		<form id="signup" method="post" action="src/actions/register.php">
			<?php echo show_errors($results); ?>

    		<label for="username">Username\Login:</label> <br/>
    		<input type="text" id="username" name="username" maxlength="30" required value="<?php echo $_SESSION['username']?>"/>
    		<span id="validateUsername"><?php if ($error) { echo $error['msg']; } ?></span><br/>

    		<label for="password">Password:</label> <br/>
    		<input type="password" id="password" name="password" required maxlength="50" />	
    		<span id="validatePw"><?php if ($error) { echo $error['msg']; } ?></span><br/>

    		<label for="email">Email:</label><br/>
    		<input type="text" id="email" name="email" maxlength="60" required value="<?php echo $_SESSION['email'];?>"/>	
    		<span id="validateEmail"><?php if ($error) { echo $error['msg']; } ?></span><br/>
			<br/>
    		<input type="submit" value="Sign Up" id="signup_btn" name="signup_btn" />			

		</form>	
	<?php include ELEMENTS.'/footer.php'; ?>
	</div>
</body>
</html>
<?php include CONF.'/close.php'; ?>