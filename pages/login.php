<?php
/**
 * Created by PhpStorm.
 * User: hafid
 * Date: 5/7/2016
 * Time: 10:48 AM
 */
?>
<form method="post" action="index.php?page=login">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="page-header">
				<h1>Login</h1>
			</div>
			<?php
			$fields = ['username', 'password'];
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
					$stmt =  $mysqli->stmt_init();
					if ($stmt->prepare("SELECT id, username, password, name, surename, born, photo FROM user WHERE username=? AND password=? AND status=1")) {
						/* bind parameters for markers */
						$stmt->bind_param("ss", $username, $password);
						/* execute query */
						$stmt->execute();
						/* bind result variables */
						$stmt->bind_result($id, $username, $password, $name, $surename, $born, $photo);
						/* fetch value */
						$stmt->fetch();

						/* close statement */
						$stmt->close();

						if(!empty($id)){
							$_SESSION['login'] = 'OK';
							$_SESSION['user'] = [
								'id' => $id,
								'username' => $username,
								'password' => $password,
								'name' => $name,
								'surename' => $surename,
								'born' => $born,
								'photo' => $photo,
							];
							header('Location: index.php');
						}
						else{
							echo '<div class="alert alert-warning" role="alert">';
							echo "Login failed";
							echo '</div>';
						}
					}
				}
			}
			?>
			<div class="form-group">
				<label for="username">Username/Email</label>
				<input type="email" class="form-control" id="username" name="username" placeholder="Username/Email">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox"> Remember me
				</label>
			</div>
			<button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</button>
		</div>
	</div>
</form>
