<?php
/**
 * Created by PhpStorm.
 * User: hafid
 * Date: 5/7/2016
 * Time: 11:20 AM
 */

?>
<div class="page-header">
	<h1>Confirmation</h1>
</div>
<?php
$user = $_GET['user'];
$key = $_GET['key'];
$stmt =  $mysqli->stmt_init();
if ($stmt->prepare("SELECT id, username, auth_key FROM user WHERE username=? AND auth_key=?")) {
	/* bind parameters for markers */
	$stmt->bind_param("si", $user, $key);
	/* execute query */
	$stmt->execute();
	/* bind result variables */
	$stmt->bind_result($id, $username, $auth_key);
	/* fetch value */
	$stmt->fetch();

	/* close statement */
	$stmt->close();

	$confirmation = false;

	if(!empty($username)) {
		$stmt = $mysqli->prepare("UPDATE user SET auth_key = '', status = 1 WHERE id=?");
		$stmt->bind_param("i", $id);
		$confirmation = $stmt->execute();
		/* close statement */
		$stmt->close();
	}

	if($confirmation ){
		echo '<div class="alert alert-success" role="alert">';
		echo 'Confirmation successfully';
		echo '</div>';
	}
	else{
		echo '<div class="alert alert-warning" role="alert">';
		echo 'Key not found';
		echo '</div>';
	}


}


