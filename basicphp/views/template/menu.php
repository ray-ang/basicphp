
<body>
<!-- Navigation -->
    <nav class="navbar navbar-default">
      <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL . SUB_PATH; ?>">BasicPHP Starter</a>
          <ul class="nav nav-pills">
            <li class="nav-item <?php if (url_value(1) == '') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL . SUB_PATH; ?>">Home</a>
            </li>
            <li class="nav-item <?php if (url_value(1) == 'welcome') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL . SUB_PATH; ?>welcome">Welcome</a>
            </li>
            <li class="nav-item <?php if (url_value(1) == 'request') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL . SUB_PATH; ?>request">Request</a>
            </li>
            <li class="dropdown <?php if (url_value(1) == 'post') echo 'active'; ?>">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Posts <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="<?php echo BASE_URL . SUB_PATH; ?>post/list">All Posts</a></li>
	            <li><a href="<?php echo BASE_URL . SUB_PATH; ?>post/add">Add Post</a></li>
	          </ul>
	        </li>
			<li class="nav-item <?php if (url_value(1) == 'sample' && url_value(2) == 'route') echo 'active'; ?>">
			  <a class="nav-link" href="<?php echo BASE_URL . SUB_PATH; ?>sample/route">Sample</a>
			</li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL . SUB_PATH; ?>login">Log In</a>
            </li>
          </ul>
      </div>
    </nav>