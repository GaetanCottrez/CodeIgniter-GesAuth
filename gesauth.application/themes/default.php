<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title><?php echo $title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="<?php base_url()?>/favicon.ico">
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
<?php foreach($css as $url): ?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
<?php endforeach; ?>
<?php foreach($js as $url): ?>
		<script type="text/javascript" src="<?php echo $url; ?>"></script>
<?php endforeach; ?>
	</head>
	<body>
		<div class="container-fluid">
			<header class="row-fluid">
				<?php echo $menu; ?>
			</header>
			<!-- <h3><?php echo $title; ?></h3> -->
			<?php echo $output; ?>
		</div>
	</body>
	<footer class="row-fluid"></footer>
	<?php $this->output->enable_profiler(ACTIVATE_PROFILTER); ?>
</html>