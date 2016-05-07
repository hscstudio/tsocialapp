<?php
session_start();
// include all config
require "config.php";

// GET PAGE
$page = "index";
if(!empty($_GET['page'])){
	// anti sensitive file expose
	$page = str_replace('.','',$_GET['page']);
}

// SESSION CHECKING
$Guser = [];
if(!empty($_SESSION['login'])){
	$Guser = $_SESSION['user'];
}
else{
	$authenticated_pages = ['profile'];
	if(in_array($page,$authenticated_pages)){
		$errors = [
			'title' => 'Request refused!',
			'content' => 'You should login first',
		];
		$page = 'error';
	}
}

// GETTING PAGE
ob_start();

if(file_exists('pages/'.$page.'.php')){
	include 'pages/'.$page.'.php';
}
else{
	$errors = [
		'title' => 'Page Not Found :(',
		'content' => 'Unfortunately, this page not found or obsolete :|',
	];
	include "pages/error.php";
}
$content = ob_get_contents();
ob_end_clean();


include "layouts/begin.php";
include "layouts/main.php";
include "layouts/end.php";