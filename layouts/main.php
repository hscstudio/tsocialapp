<?php
/**
 * Created by PhpStorm.
 * User: hafid
 * Date: 5/7/2016
 * Time: 9:30 AM
 */
?>
<!-- Static navbar -->
<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><?= $config['app']['title'] ?></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<?php
				$menus = [];
				if(!empty($Guser)){
					$menus[] = [ 'label' => $Guser['surename'], 'href' => '#', 'items' => [
						[ 'label' => 'Profile', 'href' => 'index.php?page=profile'],
						[ 'label' => 'Logout', 'href' => 'index.php?page=logout'],
					]];
				}
				else{
					$menus[] = [ 'label' => 'Register', 'href' => 'index.php?page=register'];
					$menus[] = [ 'label' => 'Login', 'href' => 'index.php?page=login'];
				}

				foreach($menus as $menu){
					if(isset($menu['items'])){
						$items = $menu['items'];
						echo '<li class="dropdown">';
						echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> '.$menu['label'].' <span class="caret"></span></a>';
						echo '<ul class="dropdown-menu">';
						foreach($items as $item){
							echo '<li><a href="'.$item['href'].'">'.$item['label'].'</a></li>';
						}
						echo '</ul>';
						echo '</li>';
					}
					else{
						echo '<li><a href="'.$menu['href'].'">'.$menu['label'].'</a></li>';
					}
				}
				?>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>


<div class="container">

	<!-- GET var $content FROM index.php -->
	<?= $content ?>

</div> <!-- /container -->
<div class="clearfix" style="height:10px;"><br></div>