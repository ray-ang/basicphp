<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

class PostController
{

	public function index()
	{
		$this->list();
	}
	
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

		if (isset($_GET['order']) && $_GET['order'] > $total) $_GET['order'] = $total;

		$page_title = 'List of Posts';

		$data = compact('stmt', 'total', 'per_page', 'page_title');
		view('post_list', $data);

	}

	public function view()
	{

		if ($this->isPostDelete()) {
			$this->delete();
			header('Location: ' . BASE_URL . 'post/list');
			exit();
		}

		if (isset($_POST['goto-edit'])) {

			header('Location: ' . BASE_URL . 'post/edit/' . url_path(3));
			exit();

		}

		$post = new PostModel;
		$row = $post->view( url_path(3) );

		if ($row) {

			$page_title = 'View Post';

			$data = compact('row', 'page_title');
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

		if ($this->isPostAdd()) {

			$post = new PostModel;
			$new_id = $post->add();

			header('Location: ' . BASE_URL . 'post/view/' . $new_id);
			exit();

		}

		$data = ['page_title' => 'Add a Post'];
		view('post_add', $data);

	}

	public function edit()
	{

		$post = new PostModel;

		if ($this->isPostEdit()) {

			$post->edit( url_path(3) );

			header('Location: ' . BASE_URL . 'post/view/' . url_path(3));
			exit();

		}

		$row = $post->view( url_path(3) );

		if ($row) {

			$page_title = 'Edit Post';

			$data = compact('row', 'page_title');
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
		$post->delete( url_path(3) );

	}

	private function isPostAdd()
	{

		if ( isset($_POST['submit-post']) && isset($_POST['csrf-token']) && isset($_SESSION['csrf-token']) && $_POST['csrf-token'] == $_SESSION['csrf-token'] ) return TRUE;

	}

	private function isPostEdit()
	{

		if ( isset($_POST['edit-post']) && isset($_POST['csrf-token']) && isset($_SESSION['csrf-token']) && $_POST['csrf-token'] == $_SESSION['csrf-token'] ) return TRUE;

	}

	private function isPostDelete()
	{

		if ( isset($_POST['delete-post']) && isset($_POST['csrf-token']) && isset($_SESSION['csrf-token']) && $_POST['csrf-token'] == $_SESSION['csrf-token'] ) return TRUE;

	}

}