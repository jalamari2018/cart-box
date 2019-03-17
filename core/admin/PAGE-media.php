<?php
/*
 * PAGE-MEDIA.PHP : ADMIN MEDIA
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// ELFINDER PERVERSION TRAIL
// https://github.com/Studio-42/elFinder/wiki
// js, css, img, sounds move to public folder
// php move to core/elfinder
// rename connector.minimal.php -> change autoload.php location -> change file path and URL path
// api-elf -> require elfinder connector
// admin/index.php >> ONE SORE THUMB ELF-PICKER
// admin/elfpicker.php >> Modified version to return vars
// ELF is also used in page-sysemail.php, page-aecat.php, page-aepdt.php
?>
<link href="<?=URL_ROOT?>public/jquery/jquery-ui.css" rel="stylesheet">
<link href="<?=URL_ROOT?>public/elfinder/css/elfinder.min.css" rel="stylesheet">
<script src="<?=URL_ROOT?>public/jquery/jquery-ui.min.js"></script>
<script src="<?=URL_ROOT?>public/elfinder/js/elfinder.min.js"></script>
<script>
$(document).ready(function() {
	$('#elfinder').elfinder({
		url  : '<?=URL_API?>admin/elf',
		lang : 'en',
		cssAutoLoad : false,
		rememberLastDir : false
	});
});
</script>
<h3>Manage Files</h3>
<div id="elfinder"></div>