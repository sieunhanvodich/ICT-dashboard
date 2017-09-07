<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>
	<div class="container">
		
	    <div>
	    	<div class="panel panel-default" style="margin-top:30px; margin-bottom:0;">
				<div class="panel-heading">
					<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
						<?php if ($this->session->userdata('is_admin') == 1) : ?>
							<center><h3 class="panel-title" style="font-size:1.5em;">Staffs Management</h3></center>
						<?php else: ?>
							<center><h3 class="panel-title" style="font-size:1.5em;">Staffs List</h3></center>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
			<?php echo $output; ?>
	    </div>
    </div>
</body>
</html>
