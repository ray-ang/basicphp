<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; handle your
 * database connection like PDO abstraction layer; and load/require
 * files. The variables can then be used in the view file.
 */

use Basic_Condition as Condition;

class PostController
{

	private function conn()
	{

		$conn = pdo_conn('mysql', 'localhost', 'basicphp', 'root', '');
		return $conn;

	}

	public function list()
	{

		$conn = $this->conn();
		$stmt = $conn->prepare("SELECT post_id, post_title, post_content FROM posts ORDER BY post_id DESC");
		$stmt->execute();

		$page_title = 'List of Posts';

		$data = compact('stmt', 'page_title');

		view('post_list', $data);

	}

	public function view()
	{

		if (Condition::isPostDelete()) $this->delete();

		if (isset($_POST['goto-edit'])) {

			header('Location: ' . BASE_URL . SUB_PATH . 'post/edit/' . url_value(3));
			exit();

		}

		$post_id = url_value(3);

		$conn = $this->conn();
		$stmt = $conn->prepare("SELECT post_id, post_title, post_content FROM posts WHERE post_id = :post_id");
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();

		$page_title = 'View Post';

		if ( $stmt->rowCount() > 0 ) {

			$data = compact('stmt', 'page_title');

			view('post_view', $data);

		} else {

			$error_message = "The Post ID does not exist.";

			$data = compact('error_message', 'page_title');

			view('error', $data);

		}

	}

	public function add()
	{

		if (Condition::isPostAdd()) {

			$conn = $this->conn();
			$stmt = $conn->prepare("INSERT INTO posts (post_title, post_content) VALUES (:post_title, :post_content)");
			$stmt->bindParam(':post_title', $_POST['title']);
			$stmt->bindParam(':post_content', $_POST['content']);
			$stmt->execute();

			$new_id = $conn->lastInsertId();

			header('Location: ' . BASE_URL . SUB_PATH . 'post/view/' . $new_id);
			exit();

		}

		$data = ['page_title' => 'Add a Post'];

		view('post_add', $data);

	}

	public function edit()
	{

		$post_id = url_value(3);

		if (Condition::isPostEdit()) {

			$conn = $this->conn();
			$stmt = $conn->prepare("UPDATE posts SET post_title = :post_title, post_content = :post_content WHERE post_id = :post_id");
			$stmt->bindParam(':post_title', $_POST['title']);
			$stmt->bindParam(':post_content', $_POST['content']);
			$stmt->bindParam(':post_id', $post_id);
			$stmt->execute();

			header('Location: ' . BASE_URL . SUB_PATH . 'post/view/' . url_value(3));
			exit();

		}

		$conn = $this->conn();
		$sql = $conn->prepare("SELECT post_title, post_content FROM posts WHERE post_id = :post_id");
		$sql->bindParam(':post_id', $post_id);
		$sql->execute();

		$page_title = 'Edit Post';

		if ( $sql->rowCount() > 0 ) {

			$data = compact('sql', 'page_title');

			view('post_edit', $data);

		} else {

			$error_message = "The Post ID does not exist.";

			$data = compact('error_message', 'page_title');

			view('error', $data);

		}

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