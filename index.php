<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Posts and comments</title>
</head>
<body>

<div class="container">
    <form action="parseJsonplaceholder.php" method="POST">
        <button type="submit"> Получить данные с Jsonplaceholder</button>
    </form>
    <form action="" method="POST" class="form">
        <input type="text" name="valueData" minlength="3" required>
        <button type="submit">Найти</button>
    </form>

	<?php
	require 'createDB.php';


	try {
		require 'dbConfig.php';
		$valueData = $_POST['valueData'];                                          //get value from input
		$sql = "SELECT * FROM comments WHERE body LIKE '%$valueData%'";

		foreach ($conn->query($sql) as $item) {

			$postId = $item['postId'];
			$stmt = $conn->prepare("SELECT title FROM posts WHERE postId=?");
			$stmt->execute([$postId]);
			$post = $stmt->fetch();

			echo "<h3>{$post['title']}</h3>";
//            echo "<p>id post: {$postId}</p>";
			echo "<p>Комментарий: {$item['body']} </p> <hr>";
		}

		$conn->exec($sql);
	} catch (PDOException $e) {
		echo $sql . $e->getMessage();
	}

	try {
		require 'dbConfig.php';                                        //get last post id
		$post = $conn->prepare("SELECT MAX(id) FROM posts");
		$post->execute();
		$postData = $post->fetch();
		$maxPostId = $postData['MAX(id)'];

		$comments = $conn->prepare("SELECT MAX(id) FROM comments");       //get last comments id
		$comments->execute();
		$commentsData = $comments->fetch();
		$maxCommentsId = $commentsData['MAX(id)'];

		echo "<script type='text/javascript'>console.log( 'Загружено: $maxPostId записей и $maxCommentsId комментариев')</script>";

	} catch (PDOException $e) {
		echo $sql . $e->getMessage();
	}

	?>
</div>
</body>
</html>