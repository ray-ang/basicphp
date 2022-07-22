<?php

class PostController
{

	public function index()
	{
		$this->list();
	}

	public function list()
	{

		if (!isset($_GET['order'])) $_GET['order'] = 0;
		if (!is_numeric($_GET['order'])) {
			$page_title = 'Error in order parameter';
			$error_message = 'Post order value should be numeric.';


			Basic::view('error', compact('page_title', 'error_message'));
		}
		if (isset($_GET['order']) && $_GET['order'] < 0) $_GET['order'] = 0;

		$per_page = 3;
		$order = intval($_GET['order']);

		$post = new PostModel;
		$stmt = $post->list($per_page, $order);
		$total = $post->total();

		if (isset($_GET['order']) && $_GET['order'] > $total) $_GET['order'] = $total;

		$page_title = 'List of Posts';

		Basic::view('post_list', compact('page_title', 'per_page', 'stmt', 'total'));
	}

	public function view()
	{

		if ($this->isPostDelete()) {
			$this->delete();
			header('Location: ' . Basic::baseUrl() . 'post/list');
			exit();
		}

		if (isset($_POST['goto-edit'])) {
			header('Location: ' . Basic::baseUrl() . 'post/edit/' . Basic::segment(3));
			exit();
		}

		$post = new PostModel;
		$row = $post->view(Basic::segment(3));

		if ($row) {
			$page_title = 'View Post';

			Basic::view('post_view', compact('page_title', 'row'));
		} else {
			$error_message = 'The Post ID does not exist.';
			$page_title = 'Error in Post ID';

			Basic::view('error', compact('page_title', 'error_message'));
		}
	}

	public function add()
	{
		if ($this->isPostAdd()) {
			$post = new PostModel;
			$new_id = $post->add();

			header('Location: ' . Basic::baseUrl() . 'post/view/' . $new_id);
			exit();
		}

		$page_title = 'Add a Post';

		Basic::view('post_add', compact('page_title'));
	}

	public function edit()
	{
		$post = new PostModel;

		if ($this->isPostEdit()) {
			$post->edit(Basic::segment(3));

			header('Location: ' . Basic::baseUrl() . 'post/view/' . Basic::segment(3));
			exit();
		}

		$row = $post->view(Basic::segment(3));

		if ($row) {
			$page_title = 'Edit Post';

			Basic::view('post_edit', compact('page_title', 'row'));
		} else {
			$error_message = "The Post ID does not exist.";
			$page_title = 'Error in Post ID';

			Basic::view('error', compact('page_title', 'error_message'));
		}
	}

	public function delete()
	{
		$post = new PostModel;
		$post->delete(Basic::segment(3));
	}

	private function isPostAdd()
	{
		if (isset($_POST['submit-post'])) return TRUE;
	}

	private function isPostEdit()
	{
		if (isset($_POST['edit-post'])) return TRUE;
	}

	private function isPostDelete()
	{
		if (isset($_POST['delete-post'])) return TRUE;
	}
}
