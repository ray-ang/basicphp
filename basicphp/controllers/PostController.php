<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

use Basic_Condition as Condition;

class PostController
{

	public function list()
	{

		if (! isset($_GET['order'])) $_GET['order'] = 0;
		if (! is_numeric($_GET['order'])) {
			$error_message = 'Post order value should be numeric.';
			$page_title = 'Error in order parameter';

			$data = compact('error_message', 'page_title');
			view('error', $data);
		}
		if (isset($_GET['order']) && $_GET['order'] < 0) $_GET['order'] = 0;

		$per_page = 3;
		$order = intval($_GET['order']);

		$post = new PostModel;
		$stmt = $post->list( $per_page, $order );
		$total = $post->total();

		if (isset($_GET['order']) && $_GET['order'] > $total->rowCount()) $_GET['order'] = $total->rowCount();

		$page_title = 'List of Posts';

		$data = compact('stmt', 'total', 'per_page', 'page_title');
		view('post_list', $data);

	}

	public function view()
	{

		if (Condition::isPostDelete()) $this->delete();

		if (isset($_POST['goto-edit'])) {

			header('Location: ' . BASE_URL . SUB_PATH . 'post/edit/' . url_value(3));
			exit();

		}

		$post = new PostModel;
		$stmt = $post->view( url_value(3) );

		if ( $stmt->rowCount() == 1 ) {

			$page_title = 'View Post';

			$data = compact('stmt', 'page_title');
			view('post_view', $data);

		} else {

			$error_message = 'The Post ID does not exist.';
			$page_title = 'Error in Post ID';

			$data = compact('error_message', 'page_title');
			view('error', $data);

		}

	}

	public function add()
	{

		if (Condition::isPostAdd()) {

			$post = new PostModel;
			$new_id = $post->add();

			header('Location: ' . BASE_URL . SUB_PATH . 'post/view/' . $new_id);
			exit();

		}

		$data = ['page_title' => 'Add a Post'];
		view('post_add', $data);

	}

	public function edit()
	{

		$post = new PostModel;

		if (Condition::isPostEdit()) {

			$post->edit( url_value(3) );

			header('Location: ' . BASE_URL . SUB_PATH . 'post/view/' . url_value(3));
			exit();

		}

		$sql = $post->editView( url_value(3) );

		if ( $sql->rowCount() > 0 ) {

			$page_title = 'Edit Post';

			$data = compact('sql', 'page_title');
			view('post_edit', $data);

		} else {

			$error_message = "The Post ID does not exist.";
			$page_title = 'Error in Post ID';

			$data = compact('error_message', 'page_title');
			view('error', $data);

		}

	}

	public function delete()
	{

		$post = new PostModel;
		$post->delete( url_value(3) );

		header('Location: ' . BASE_URL . SUB_PATH . 'post/list');
		exit();

	}

}