<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default" style="margin-top:30px;">
				<div class="panel-heading">
					<h1 class="panel-title" style="font-size:2em;">Login</h1>
				</div>
				<?php if (validation_errors()) : ?>
					<div class="alert alert-danger" role="alert">
						<?= validation_errors() ?>
					</div>
				<?php endif; ?>
				<?php if (isset($error)) : ?>
					<div class="alert alert-danger" role="alert">
						<?= $error ?>
					</div>
				<?php endif; ?>
				<?= form_open() ?>
					<div class="panel-body">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Your username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Your password">
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-default" value="Login">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->