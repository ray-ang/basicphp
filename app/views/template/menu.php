<body>
  <div class="container">
    <!-- Navigation -->
    <nav class="navbar navbar-default">
      <a class="navbar-brand" href="<?php echo Basic::baseUrl(); ?>">BasicPHP Starter</a>
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link <?php if (Basic::segment(1) == '') echo 'active'; ?>" href="<?php echo Basic::baseUrl(); ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (Basic::segment(1) == 'encryption') echo 'active'; ?>" href="<?php echo Basic::baseUrl(); ?>encryption">Encryption</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (Basic::segment(1) == 'request') echo 'active'; ?>" href="<?php echo Basic::baseUrl(); ?>request">Request</a>
        </li>
        <li class="dropdown drop-down">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            Posts
          </button>
          <div class="dropdown-menu drop-down-entry">
            <a class="dropdown-item" href="<?php echo Basic::baseUrl(); ?>post/list">All Posts</a>
            <a class="dropdown-item" href="<?php echo Basic::baseUrl(); ?>post/add">Add Post</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (Basic::segment(1) == 'sample' && Basic::segment(2) == 'route') echo 'active'; ?>" href="<?php echo Basic::baseUrl(); ?>sample/route">Sample</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Basic::baseUrl(); ?>login">Log In</a>
        </li>
      </ul>
    </nav>