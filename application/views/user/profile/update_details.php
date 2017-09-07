<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Update your details <small><?= $user->username ?></small></h1>
			</div>
		</div>
		<?php if (isset($_SESSION['flash'])) : ?>
			<div class="col-md-12">
				<div class="alert alert-success" role="alert">
					<p><?= $_SESSION['flash'] ?></p>
					<?php unset($_SESSION['flash']); ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="row">
				<?= form_open_multipart() ?>
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Manage your information</h3>
							</div>
							<?= form_open('user/profile') ?>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-7 ">
										<div class="form-group">
											<label for="fullname">Your full name</label>
											<input type="text" class="form-control" id="fullname" name="fullname" placeholder="<?= $user->fullname ?>">
										</div>
										<div class="form-group">
											<label for="title">Your current title</label>
											<input type="text" class="form-control" id="title" name="title" placeholder="<?= $user->title ?>">
										</div>
										<div class="form-group">
											<label for="position">Your current position</label>
											<input type="text" class="form-control" id="position" name="position" placeholder="<?= $user->position ?>">
										</div>
										<div class="form-group">
											<label for="affiliation">Affiliation</label>
											<input type="text" class="form-control" id="affiliation" name="affiliation" placeholder="<?= $user->affiliation ?>">
										</div>
										<div class="form-group">
											<label for="publication">Your publication</label>
											<textarea class="form-control" id="publication" name="publication" placeholder="<?= $user->publication ?>"></textarea>
										</div>
										<div class="form-group">
											<label for="sup_student">Your supervised students</label>
											<textarea class="form-control" id="sup_student" name="sup_student" placeholder="<?= $user->sup_student ?>"></textarea>
										</div>
										<div class="form-group">
											<label for="project">Project</label>
											<textarea class="form-control" id="project" name="project" placeholder="<?= $user->project ?>"></textarea>
										</div>
										<input type="submit" class="btn btn-primary" style="background-color:green;" value="Update your profile">
									</div>
								</div><!-- .row -->
							</div>
						</div>
					</div>			
					
				</form>
			</div><!-- .row -->
		</div>
	</div><!-- .row -->
</div><!-- .container -->

<?php //var_dump($user); ?>