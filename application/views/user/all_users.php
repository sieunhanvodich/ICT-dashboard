<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php $users = $this->db->query("select * from users"); ?>
			<?php foreach($users->result() as $row) { ?> 
				<div class="row" style="margin-top:30px;">
					<div class="col-sm-2 text-center">
						<img class="avatar" src="<?= base_url('uploads/avatars/' . $row->avatar) ?>">
						<h2><?= $row->username ?></h2>
					</div>
					<div class="col-sm-4 col-sm-offset-1">
						<p style="color:green;">Joined: <?= $row->created_at ?></p>
						<p><strong>Full name: </strong><?= $row->fullname ?></p>
						<p><strong>Email: </strong><?= $row->email ?></p>
						<p><strong>Title: </strong><?= $row->title?></p>
						<br>
						<a class="btn btn-success" href="<?= base_url('user/' . $row->username) ?>"> Read more </a>	
					</div>	
				</div><!-- .row -->
			<?php } ?>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
