<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		.form-signin{
			max-width:40%;
			min-width:258px;
			margin:150px auto;
			padding:15px;
			box-shadow: 5px 5px #2b2d2f;
		}
	</style>

    <title><?=$page_title?></title>
  </head>
  <body class="bg-secondary">
	<div class="container">
	<!-- Content here -->
			<?=form_open('login/forgot','class="form-signin"')?>
			<?=validation_errors()?>
			<?=$msg?>
				<div class="text-center text-white">
					<h1 class="mb-3">eArsip <i class="fa fa-folder-open-o"></i></h1>
					<span class="iconic iconic-folder" title="folder" aria-hidden="true"></span>				  
				</div>
				  <div class="form-group">
					<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
				  </div>
				  <button type="submit" class="btn btn-warning btn-block text-dark font-weight-bold">Reset Password</button>
				  <a href="<?=site_url('login')?>" class="text-warning">Sign In</a>
			<?=form_close()?>
	</div>
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>