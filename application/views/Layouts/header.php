<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="" />
	<link rel="icon" type="image/png" href="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?=$title; ?></title>

	<!-- Bootstrap core CSS     -->
	<?php echo link_tag('Assets/css/bootstrap.min.css'); ?>

	<!-- Font Awesome CSS     -->
	<?php echo link_tag('Assets/css/font-awesome.min.css'); ?>
</head>

<body >
<div class="wrapper">
	<div class="container">
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?=base_url()?>">CRUD APP</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="<?=base_url()?>">Home</a></li>
					<li><a href="<?=base_url('product/add')?>">Add Product</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
				</ul>
			</div>
		</nav>
