<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Dear Zend</title>
	<script src="<?=site_url('/assets/jquery-1.2.6.js')?>" type="text/javascript" charset="utf-8"></script>
	
	<script type="text/javascript" charset="utf-8">
		$().ready(function() {
			
			/*
				apply striping to lists
			*/
			$('.letter:even').addClass('even');
			
			/*
				Fadeout flash messages after 3 seconds
			*/
			setTimeout(function() {
				$('div.flash-msg').fadeOut(500);
			}, 3000);
			
			
		});
	</script>
	
	<link rel="stylesheet" href="<?=site_url('/css/site.css')?>" type="text/css" media="screen" title="no title" charset="utf-8">
	
</head>

<body>
	<a href="<?=site_url('')?>"><img id="banner" src="<?=site_url('/images/banner.png')?>" border="0" /></a>
	
	<div id="content">