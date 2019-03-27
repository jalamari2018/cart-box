<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
	<title>elFinder 2.1.x</title>
	<link href="<?=URL_ROOT?>public/jquery/jquery-ui.css" rel="stylesheet">
	<link href="<?=URL_ROOT?>public/elfinder/css/elfinder.min.css" rel="stylesheet">
	<script src="<?=URL_ROOT?>public/jquery/jquery.min.js"></script>
	<script src="<?=URL_ROOT?>public/jquery/jquery-ui.min.js"></script>
	<script src="<?=URL_ROOT?>public/elfinder/js/elfinder.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#elfinder').elfinder({
			url  : '<?=URL_API?>admin/elf',
			lang : 'en',
			cssAutoLoad : false,
			rememberLastDir : false,
			getFileCallback : function(file, fm) {
				parent.tinymce.activeEditor.windowManager.getParams().oninsert(file, fm);
				parent.tinymce.activeEditor.windowManager.close();
			}
		});
	});
	</script>
</head>
<body>
	<div id="elfinder"></div>
</body>
</html>