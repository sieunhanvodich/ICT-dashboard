<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">

	<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

	<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">	
	<link href="<?php echo base_url() ?>assets/css/researchtopic.css" rel="stylesheet">

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ICTLAB DASHBOARD</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">

	<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<link href='//fonts.googleapis.com/css?family=Catamaran:400,100,300,500,700,600,800,900' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="header" style="padding-top:70px;">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
						<a class="navbar-brand" href="<?= base_url('public_info/all_users')?>">ICTlab dashboard</a>
					<?php else : ?>
						<a class="navbar-brand" href="<?= base_url('login') ?>">ICTlab dashboard</a>
					<?php endif; ?>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">	
						<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>	
							<li>
								<a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <span class="glyphicon glyphicon-calendar" style="color:green;"></span> Calendar </a>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								    <li><a href="<?= base_url() . 'calendar/seminar' ?>">Seminar</a></li>
								    <li><a href="<?= base_url() . 'calendar/meeting'?>">Meeting</a></li>
								    <li><a href="<?= base_url() . 'calendar/discussion'?>">Reserach Discussion</a></li>
								</ul>
							</li>
							<li><a href="<?= base_url('user/' . $_SESSION['username']) ?>"><span class="glyphicon glyphicon-user" style="color:green"></span> Profile</a></li>
							<?php if ($this->session->userdata('is_admin') == 1) : ?>
								<li>
									<a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <span class="glyphicon glyphicon-list-alt" style="color:green;"></span> Management </a>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									    <li><a href="<?= base_url('admin/staffs') ?>">Staffs</a></li>
									    <li><a href="<?= base_url('admin/posts') ?>">News and Events</a></li>
									 </ul>
								</li>
							<?php endif; ?>
							<li><a href="<?= base_url('logout') ?>"><span class="glyphicon glyphicon-log-out" style="color:green"></span> Logout</a></li>
						<?php else : ?>
							<li><a href="<?= base_url('register') ?>"><span class="glyphicon glyphicon-plus-sign" style="color:green"></span> Register</a></li>
							<li><a href="<?= base_url('login') ?>"><span class="glyphicon glyphicon-log-in" style="color:green"></span> Login</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>	
	 <!-- <div class="col-md-12 logo"> -->
		<div class="container" style="margin-top:20px;">
	 		<a href="index.html"><img src="<?php echo base_url() ?>assets/images/logo.png"></a>
	 		&nbsp;&nbsp;&nbsp;
	 		<span class="co-operate">
		 		<a href="http://www.usth.edu.vn/"><img src="<?php echo base_url() ?>assets/images/usthlogo_ictlab.png"></a>
		 		&nbsp;&nbsp;&nbsp;
		 		<a href="http://www.ioit.ac.vn/"><img src="<?php echo base_url() ?>assets/images/IOIT.png" style="width: 50px; height:50px"></a>
		 		&nbsp;&nbsp;&nbsp;
		 		<a href="http://en.vietnam.ird.fr/"><img src="<?php echo base_url() ?>assets/images/IRD.png"></a>
		 		&nbsp;&nbsp;&nbsp;
		 		<a href="http://www.univ-larochelle.fr/"><img src="<?php echo base_url() ?>assets/images/la-rochelle.jpg"></a>
		 	</span>
		 </div>
		
		<div class="nav-top" style="position:relative; margin-top:30px;">
			<div class="container">
				<div class="nav1">
					<div class="navbar1">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" >
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
					</div>
					
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav cl-effect-8">
							<li><a href="#"><span class="glyphicon glyphicon-home" style="color:white"></span> Home </a></li>
							<li><a href="#"><span class="glyphicon glyphicon-question-sign" style="color:white"></span> About</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-pencil" style="color:white"></span> Research Topics</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-tasks" style="color:white"></span> Research Project</a></li>
							<li><a href="<?= base_url('public_info/posts') ?>"><span class="glyphicon glyphicon-triangle-right" style="color:white"></span> News and Events</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-user" style="color:white"></span> Members</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-earphone" style="color:white"></span> Contact</a></li>	
						</ul>
					</div>
				</div>	
					<div class="clearfix"></div>
				</div> 
			</div> 
		</div> 
	</div> 
</body>
</html>