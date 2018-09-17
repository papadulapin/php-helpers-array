<?php

require 'vendor/autoload.php';

$user = [
	'name' => 'helloworld',
	'topics' => [
		['title' => 'Hi arrays'],
		['title' => 'Bye arrays'],
	], 
	'country' => [
		'name' => 'CA',
		'flag' => [
			'url' => 'path_to_flag.png',
			'size' => 30,
			],
	],
];

$users = [
	['name' => 'Tim', 'score' => 10],
	['name' => 'Kim', 'score' => 200],
	['name' => 'Helen', 'score' => 500],
	['name' => 'Tom', 'score' => 1],
];

/*
//array_get() example
dump(array_get($user, 'country.name'));
*/

/*
//array_first() example
$user = array_first($users, function ($user, $key) {

	return array_get($user, 'score') > 200;
});
dump($user);
*/

/*
//array_last() example
$user = array_last($users, function ($user, $key) {
	return array_get($user, 'score') >= 500;
});
dump($user);
*/

/*
//array_has example
dump(array_has($user, ['topics.1.title', 'country.name']));
*/


/*//array_where
$users = array_where($users, function ($user, $key) {
	return array_get($user, 'score') > 100;
});
dump($users);*/


/*
//array_only example
$user = array_only($user, ['name', 'country']);
$user = array_only($user, ['name', 'country', 'topics']);
dump($user);
*/

/*
//add array_forget() here
array_forget($user, ['name', 'topics.1', 'country.flag.size']);
dump($user);
*/