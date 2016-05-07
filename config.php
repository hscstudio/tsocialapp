<?php
/**
 * Created by PhpStorm.
 * User: hafid
 * Date: 5/7/2016
 * Time: 9:39 AM
 */

$config = [
	'app' => [
		'title' => 'SocialApp',
		'email' => 'hafidmukhlasin@gmail.com',
		'status' => 'dev', // prod
	],
	'db' => [
		'host' => 'localhost',
		'username' => 'root',
		'password' => '123456',
		'name' => 'socialapp',
	],
	'upload' => [
		'path' => 'uploads',
	]
];

// Create connection
$mysqli = new mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']);

// Check connection
if ($mysqli->connect_error) {
	die("Connection failed: " . $mysqli->connect_error);
}
