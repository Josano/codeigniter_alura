<html lang="en">
<head>
	<link rel="stylesheet" href="<?=base_url("css/bootstrap.css");?>">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
  <body>
  	<div class="container">
			<?php if($this->session->flashdata("danger")) : ?>
				<div class="alert alert-danger"><h3><?php echo $this->session->flashdata("danger");?></h3></div>
			<?php endif ?>

			<?php if($this->session->flashdata("sucess")) : ?>
				<div class="alert alert-success"><h3><?php echo $this->session->flashdata("sucess");?></h3></div>
			<?php endif ?>
