<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title><?php echo $title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>assets/images/favicon.ico">
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
<?php foreach($css as $url): ?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
<?php endforeach; ?>
<script type="text/javascript"> var gesauth_url_close_browser = "<?php echo site_url('login/ajax_close_browser'); ?>";</script>
<?php foreach($js as $url): ?>
		<script type="text/javascript" src="<?php echo $url; ?>"></script>
<?php endforeach; ?>
	</head>
	<body>
		<div id="processing"></div>
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