<?php
/**
 * Created by PhpStorm.
 * User: hafid
 * Date: 5/7/2016
 * Time: 10:48 AM
 */
?>
<form method="post" action="index.php?page=register">
	<div class="row">
		<div class="col-sm-6">
			<div class="page-header">
				<h1>Register</h1>
			</div>
			<?php
			$fields = ['username', 'password', 'retype_password', 'name', 'surename', 'born'];
			foreach ($fields as $field) {
				$$field = "";
			}
			if(isset($_POST['submit'])) {
				$errors = [];
				foreach ($fields as $field) {
					if (!empty($_POST[$field])) {
						$$field = $_POST[$field];
					} else {
						$errors[$field] = "Field " . $field . " empty!";
					}
				}

				if(strlen($password)<=5){
					$errors['password'] = "Password min 6 chars!";
				}

				if($password!=$retype_password){
					$errors['retype_password'] = "Password & retype password not match!";
				}

				if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
					$errors['username'] = "Username/email invalid!";
				}

				if (!empty($errors)) {
					echo '<div class="alert alert-warning" role="alert">';
					echo implode(', ',$errors);
					echo '</div>';
				}
				else{
					$password = md5($password);
					$auth_key = rand(1000,1000000);
					$stmt = $mysqli->prepare("
						INSERT INTO user(username,password,name,surename,born,auth_key)
						VALUES (?,?,?,?,?,?)");
					$stmt->bind_param("ssssss", $username, $password, $name, $surename, $born, $auth_key);
					$register = false;
					$register = $stmt->execute();
					if($register){
						$to = $username;
						$subject = "SocialApp Registration Confirmation";

						$message = "
						<html>
						<head>
						<title>SocialApp Registration Confirmation</title>
						</head>
						<body>
						<p>Hello, ".$name."!</p>
						<p>Please click this link to confirmation of Your registration!</p>
						<p><a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?page=confirmation&user=".$username."&key=".$auth_key."'>Confirmation</a></p>
						</body>
						</html>
						";

						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

						// More headers
						$headers .= 'From: <'.$config['app']['email'].'>' . "\r\n";

						// on production
						if($config['app']['status']=='prod'){
							mail($to,$subject,$message,$headers);
						}
						// on development
						else{
							echo "<hr>";
							echo $message;
							echo "<hr>";
						}

						/* close statement */
						$stmt->close();
					}

					echo '<div class="alert alert-success" role="alert">';
					echo 'Registration successfully, check Your email';
					echo '</div>';

				}
			}

			?>
			<div class="form-group">
				<label for="username">Email address</label>
				<input type="username" class="form-control" id="username" name="username" value="<?= $username ?>" placeholder="Email">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>
			<div class="form-group">
				<label for="retype_password">Retype Password</label>
				<input type="password" class="form-control" id="retype_password" name="retype_password" placeholder="Password">
			</div>
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" id="name" name="name" value="<?= $name ?>" placeholder="Name">
			</div>
			<div class="form-group">
				<label for="surename">Surename</label>
				<input type="text" class="form-control" id="surename" name="surename" value="<?= $surename ?>" placeholder="Surename">
			</div>
			<div class="form-group">
				<label for="born">Born</label>
				<input type="text" class="form-control" id="born" name="born" value="<?= $born ?>" placeholder="Born">
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox"> Remember me
				</label>
			</div>
			<button name="submit" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Register</button>
		</div>
	</div>
</form>
