<?php

/**
 * Structure Models using PHP Data Objects (PDO)
 */

class PostModel
{

	private function conn()
	{

		try {
			$conn = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USER, DB_PASS);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}

	public function total()
	{

		$conn = $this->conn();
		$stmt = $conn->prepare("SELECT post_id FROM posts");
		$stmt->execute();
		$result = $stmt->rowCount();

		return $result;
	}

	public function list($per_page, $order)
	{

		$conn = $this->conn();
		$stmt = $conn->prepare("SELECT post_id, post_title, post_content FROM posts ORDER BY post_id DESC LIMIT $per_page OFFSET " . $order);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $result;
	}

	public function view($post_id)
	{

		$conn = $this->conn();
		$stmt = $conn->prepare("SELECT post_id, post_title, post_content FROM posts WHERE post_id = :post_id");
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();
		$result = $stmt->fetch();

		return $result;
	}

	public function add()
	{

		$conn = $this->conn();
		$stmt = $conn->prepare("INSERT INTO posts (post_title, post_content) VALUES (:post_title, :post_content)");
		$stmt->bindParam(':post_title', $_POST['title']);
		$stmt->bindParam(':post_content', $_POST['content']);
		$stmt->execute();

		return $conn->lastInsertId();
	}

	public function edit($post_id)
	{

		$conn = $this->conn();
		$stmt = $conn->prepare("UPDATE posts SET post_title = :post_title, post_content = :post_content WHERE post_id = :post_id");
		$stmt->bindParam(':post_title', $_POST['title']);
		$stmt->bindParam(':post_content', $_POST['content']);
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();
	}

	public function delete($post_id)
	{

		$conn = $this->conn();
		$stmt = $conn->prepare("DELETE FROM posts WHERE post_id = :post_id");
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();
	}
}
