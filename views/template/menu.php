
<body>
<!-- Navigation -->
    <nav class="navbar navbar-default">
      <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">BasicPHP Starter</a>
          <ul class="nav nav-pills">
            <li class="nav-item <?php if (url_path(1) == '') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a>
            </li>
            <li class="nav-item <?php if (url_path(1) == 'encryption') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>encryption">Encryption</a>
            </li>
            <li class="nav-item <?php if (url_path(1) == 'request') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>request">Request</a>
            </li>
            <li class="dropdown <?php if (url_path(1) == 'post') echo 'active'; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="TRUE" aria-expanded="FALSE">Posts <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo BASE_URL; ?>post/list">All Posts</a></li>
                <li><a href="<?php echo BASE_URL; ?>post/add">Add Post</a></li>
              </ul>
            </li>
            <li class="nav-item <?php if (url_path(1) == 'sample' && url_path(2) == 'route') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>sample/route">Sample</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>login">Log In</a>
            </li>
          </ul>
      </div>
    </nav>