<?php
/**
 * Created by PhpStorm.
 * User: hafid
 * Date: 5/7/2016
 * Time: 10:10 AM
 */
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?= $errors['title'] ?></h3>
	</div>
	<div class="panel-body">
		<div class="alert alert-danger" role="alert">
			<p><?= $errors['content'] ?></p>
		</div>
	</div>
</div>
