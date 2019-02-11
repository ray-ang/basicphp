	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">Add Post</h1>
			<form class="form-horizontal" action="" method="post">
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="title">Title:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="title" placeholder="Enter title" name="title">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="content">Content:</label>
			    <div class="col-sm-10"> 
			      <textarea class="form-control" rows="5" id="content" placeholder="Enter content" name="content"></textarea>
			    </div>
			  </div>
			  <div class="form-group"> 
			    <div class="col-sm-offset-2 col-sm-10">
	    		  <input type="hidden" name="csrf-token" value="<?= csrf_token() ?>">
			      <button type="submit" class="btn btn-default" name="submit-post">Submit</button>
			    </div>
			  </div>
			</form>
        </div>
      </div>
    </div>