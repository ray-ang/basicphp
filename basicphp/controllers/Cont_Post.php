<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; handle your
 * database connection like PDO abstraction layer; and load/require
 * files. The variables can then be used in the view file.
 */

use Basic_Condition as Condition;
use Basic_Database as Database;
use Basic_View as View;

class Cont_Post

{

	public function conn()

	{

		$database = new Database;
		$conn = $database->conn();

		return $conn;

	}

	public function list()

	{

		$conn = $this->conn();
		$stmt = $conn->prepare("SELECT post_id, post_title, post_content FROM posts ORDER BY post_id DESC");
		$stmt->execute();

		$data = compact('stmt');

		View::page('post_list', $data);

	}

	public function view()

	{

		if (Condition::post_delete()) $this->delete();

		if (isset($_POST['goto-edit'])) {

			header('Location: ' . BASE_URL . SUB_PATH . 'post/edit/' . url_value(3));
			exit();

		}

		$post_id = url_value(3);

		$conn = $this->conn();
		$stmt = $conn->prepare("SELECT post_id, post_title, post_content FROM posts WHERE post_id = :post_id");
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();

		$data = compact('stmt');

		View::page('post_view', $data);

	}

	public function add()

	{

		if (Condition::post_add()) {

			$conn = $this->conn();
			$stmt = $conn->prepare("INSERT INTO posts (post_title, post_content)
			VALUES (:post_title, :post_content)");
			$stmt->bindParam(':post_title', $_POST['title']);
			$stmt->bindParam(':post_content', $_POST['content']);
			$stmt->execute();

			$new_id = $conn->lastInsertId();

			header('Location: ' . BASE_URL . SUB_PATH . 'post/view/' . $new_id);
			exit();

		}

		View::page('post_add');

	}

	public function edit()

	{

	if (Condition::post_edit()) {

		$post_id = url_value(3);

		$conn = $this->conn();
		$stmt = $conn->prepare("UPDATE posts SET post_title = :post_title, post_content = :post_content WHERE post_id = :post_id");
		$stmt->bindParam(':post_title', $_POST['title']);
		$stmt->bindParam(':post_content', $_POST['content']);
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();

		header('Location: ' . BASE_URL . SUB_PATH . 'post/view/' . url_value(3));
		exit();

	}

	$post_id = url_value(3);

	$conn = $this->conn();
	$sql = $conn->prepare("SELECT post_title, post_content FROM posts WHERE post_id = :post_id");
	$sql->bindParam(':post_id', $post_id);
	$sql->execute();

	$data = compact('sql');

	View::page('post_edit', $data);

	}

	public function delete()

	{

		$post_id = url_value(3);

		$conn = $this->conn();
		$stmt = $conn->prepare("DELETE FROM posts WHERE post_id = :post_id");
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();

		header('Location: ' . BASE_URL . SUB_PATH . 'post/list');
		exit();

	}

}