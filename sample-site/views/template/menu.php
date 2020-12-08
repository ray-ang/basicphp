
<body>
<!-- Navigation -->
    <nav class="navbar navbar-default">
      <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">BasicPHP Starter</a>
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link <?php if (Basic::segment(1) == '') echo 'active'; ?>" href="<?php echo BASE_URL; ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (Basic::segment(1) == 'encryption') echo 'active'; ?>" href="<?php echo BASE_URL; ?>encryption">Encryption</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (Basic::segment(1) == 'request') echo 'active'; ?>" href="<?php echo BASE_URL; ?>request">Request</a>
            </li>
            <li class="dropdown drop-down">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                Posts
              </button>
              <div class="dropdown-menu drop-down-entry">
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>post/list">All Posts</a>
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>post/add">Add Post</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (Basic::segment(1) == 'sample' && Basic::segment(2) == 'route') echo 'active'; ?>" href="<?php echo BASE_URL; ?>sample/route">Sample</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>login">Log In</a>
            </li>
          </ul>
      </div>
    </nav>