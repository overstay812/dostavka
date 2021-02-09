<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client as Client;

class PostsLoader
{
	private $link;

	public function __construct($link)
	{
		$this->link = $link;
	}

	public function posts()
	{
		// get posts from jsonplaceholder
		try {
			$httpClient = new Client(['base_uri' => 'https://jsonplaceholder.typicode.com/' . $this->link]);
			$response = $httpClient->request('GET');
			$data = $response->getBody();

			$dataArray = json_decode($data, true);
			//record posts in database
			require 'dbConfig.php';
			foreach ($dataArray as $item) {
				$postId = $item['id'];
				$title = $item['title'];
				$body = $item['body'];
				$sql = "INSERT INTO posts (postId, title, body)
                VALUES('$postId', '$title', '$body')";
				$conn->exec($sql);
			}
		} catch (PDOException $e) {
			echo $sql . $e->getMessage();
		}
		$conn = null;
	}

	public function comments()
	{
		//get comments from jsonplaceholder
		try {
			$httpClient = new Client(['base_uri' => 'https://jsonplaceholder.typicode.com/' . $this->link]);
			$response = $httpClient->request('GET');
			$data = $response->getBody();

			$dataArray = json_decode($data, true);
			//record comments in database
			require 'dbConfig.php';
			foreach ($dataArray as $item) {
				$postId = $item['postId'];
				$name = $item['name'];
				$email = $item['email'];
				$body = $item['body'];
				$sql = "INSERT INTO comments (postId, name,	email, body)
                VALUES('$postId', '$name',	'$email','$body')";
				$conn->exec($sql);
			}

			header("Location: /index.php");
			exit;
		} catch (PDOException $e) {
			echo $sql . $e->getMessage();
		}
		$conn = null;
	}
}

$getPosts = new PostsLoader("posts");
$getPosts->posts();

$getComments = new PostsLoader("comments");
$getComments->comments();
