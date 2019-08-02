
<body>
<!-- Navigation -->
    <nav class="navbar navbar-default">
      <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">BasicPHP Starter</a>
          <ul class="nav nav-pills">
            <li class="nav-item <?php if (url_value(0) == '') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a>
            </li>
            <li class="nav-item <?php if (url_value(0) == 'welcome') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>welcome">Welcome</a>
            </li>
            <li class="nav-item <?php if (url_value(0) == 'request') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>request">Request</a>
            </li>
            <li class="dropdown <?php if (url_value(0) == 'post') echo 'active'; ?>">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Posts <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="<?php echo BASE_URL; ?>post/list">All Posts</a></li>
	            <li><a href="<?php echo BASE_URL; ?>post/add">Add Post</a></li>
	          </ul>
	        </li>
			<li class="nav-item <?php if (url_value(0) == 'sample' && url_value(2) == 'route') echo 'active'; ?>">
			  <a class="nav-link" href="<?php echo BASE_URL; ?>sample/route">Sample</a>
			</li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>login">Log In</a>
            </li>
          </ul>
      </div>
    </nav>