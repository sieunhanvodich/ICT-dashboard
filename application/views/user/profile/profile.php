<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1>User profile <small><?= $user->username ?></small> <?= $update_profile_button ?> <?= $edit_button ?>  </h1>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-sm-2 text-center">
					<img class="avatar" src="<?= base_url('uploads/avatars/' . $user->avatar) ?>">
					<h2><?= $user->username ?></h2>
				</div>
				<div class="col-sm-4 col-sm-offset-1">
					<p>Joined: <?= $user->created_at ?></p>
					<p><strong>Full name: </strong><?= $user->fullname ?></p>
					<p><strong>Email: </strong><?= $user->email ?></p>
					<p><strong>Title: </strong><?= $user->title?></p>
				</div>
				<div class="col-sm-5">
					<p><strong>Position: </strong><?= $user->position ?></p>
					<p><strong>Publication: </strong><?= $user->publication ?></p>
					<p><strong>Affiliation: </strong><?= $user->affiliation ?></p>
					<p><strong>Supervised students: </strong><?= $user->sup_student ?></p>
					<p><strong>Project: </strong><?= $user->project?></p>
				</div>
			</div><!-- .row -->
		</div>
	</div><!-- .row -->
</div><!-- .container -->

<?php //var_dump($user); ?>