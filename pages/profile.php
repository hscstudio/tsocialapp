<?php
/**
 * Created by PhpStorm.
 * User: hafid
 * Date: 5/7/2016
 * Time: 10:48 AM
 */
?>
<form method="post" action="index.php?page=profile" enctype="multipart/form-data">
	<div class="page-header">
		<h1>Profile</h1>
	</div>
	<div class="row">
		<div class="col-sm-6">

			<?php

			foreach ($Guser as $num=>$field) {
				$$num = $field;
			}
			if(isset($_POST['submit'])) {
				$errors = [];
				$fields = ['name', 'surename', 'born'];
				foreach ($fields as $field) {
					if (!empty($_POST[$field])) {
						$$field = $_POST[$field];
					} else {
						$errors[$field] = "Field " . $field . " empty!";
					}
				}

				// field optional
				foreach (['last_password','password','retype_password'] as $field) {
					$$field = $_POST[$field];
				}

				if(!empty($last_password)){
					if(md5($last_password)!=$Guser['password']){
						$errors['last_password'] = "Last password wrong!";
					}

					if(strlen($password)<=5){
						$errors['password'] = "Password min 6 char!";
					}
					if($password!=$retype_password){
						$errors['retype_password'] = "Password & retype password not match!";
					}
				}

				$upload_photo = false;
				$photo = $Guser['photo'];
				if($_FILES['photo']['name'])
				{
					//if no errors...
					if(!$_FILES['photo']['error'])
					{
						//now is the time to modify the future file name and validate the file
						$path = $_FILES['photo']['name'];
						$ext = pathinfo($path, PATHINFO_EXTENSION);
						$new_file_name = $Guser['id'].'.'.$ext; //rename file
						$valid_file = true;
						if($_FILES['photo']['size'] > (1024000)) //can't be larger than 1 MB
						{
							$valid_file = false;
							$errors['photo'] = 'Your file\'s size is to large.';
						}

						//if the file has passed the test
						if($valid_file)
						{
							//move it to where we want it to be
							move_uploaded_file($_FILES['photo']['tmp_name'], $config['upload']['path'].'/'.$new_file_name);
							$photo = $new_file_name;
							$upload_photo = true;
						}
					}
					//if there is an error...
					else
					{
						//set that to be the returned message
						$errors['photo'] = 'Your upload triggered the following error:  '.$_FILES['photo']['error'];
					}
				}

				if (!empty($errors)) {
					echo '<div class="alert alert-warning" role="alert">';
					echo implode('<br>',$errors);
					echo '</div>';
				}
				else{

					if(!empty($password)){
						$password = md5($password);
						$stmt = $mysqli->prepare("UPDATE user SET name=?, password=?, surename=?, born=?, photo=? WHERE id=?");
						$stmt->bind_param("sssssi", $name, $password, $surename, $born, $photo, $Guser['id']);
					}
					else{
						$stmt = $mysqli->prepare("UPDATE user SET name=?, surename=?, born=?, photo=? WHERE id=?");
						$stmt->bind_param("ssssi", $name, $surename, $born, $photo, $Guser['id']);
					}

					if($stmt->execute()) {
						$_SESSION['user']['name'] = $name;
						$_SESSION['user']['surename'] = $surename;
						$_SESSION['user']['born'] = $born;
						$_SESSION['user']['photo'] = $photo;
						$Guser = $_SESSION['user'];
						echo '<div class="alert alert-success" role="alert">';
						echo 'Update profile successfully';
						echo '</div>';
					}
				}
			}

			?>
			<div class="form-group">
				<label for="username">Username/Email</label>
				<input type="text" class="form-control" disabled="disabled" value="<?= $username ?>" placeholder="Email">
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

			<h3> Left blank if you don't want change password!</h3>
			<div class="form-group">
				<label for="last-password">Last Password</label>
				<input type="password" class="form-control" id="last-password" name="last_password" placeholder="Last password">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>
			<div class="form-group">
				<label for="retype_password">Retype Password</label>
				<input type="password" class="form-control" id="retype_password" name="retype_password" placeholder="Password">
			</div>


			<button name="submit" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Update</button>
		</div>
		<div class="col-sm-6">
			<?php
			if (!empty($Guser['photo'])) {
				?>
				<div class="form-group">
					<img src="<?= $config['upload']['path'] . '/' . $Guser['photo'] ?>" alt="Photo"
						 class="img-thumbnail">
				</div>
				<?php
			}
			?>
			<div class="form-group">
				<label for="photo">Photo</label>
				<input type="file" class="form-control" id="photo" name="photo" placeholder="Photo">
			</div>
		</div>
	</div>
</form>
