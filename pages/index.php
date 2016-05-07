<?php
/**
 * Created by PhpStorm.
 * User: hafid
 * Date: 5/7/2016
 * Time: 10:01 AM
 */
?>
<div class="jumbotron">
	<h1>Welcome in SocialApp!</h1>
	<p>You can connect with Your friend in the world :)</p>
	<?php
	if(empty($Guser)) {
		?>
		<p>
			<a class="btn btn-primary btn-lg" href="index.php?page=login" role="button">
				<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login
			</a>
			<a class="btn btn-success btn-lg" href="index.php?page=register" role="button">
				<span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Register</a>
		</p>
		<?php
	}
	?>
</div>
