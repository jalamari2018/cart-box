<?php
/*
 * PAGE-SYSEMAIL.PHP : SYSTEM EMAIL CONFIG
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<h3>Email Templates</h3>
<form onsubmit="return cfg.save();" class="form-wrap">
	<!-- [SELECT EMAIL] -->
	<div class="form-wrap-head">Select Template</div>
	<div class="form-wrap-body">
		<select id="sel-template" class="form-control" onchange="cfg.change();"><?php
			foreach ($_EMAIL as $i=>$e) {
				printf("<option value='%u'>%s</option>", $i, $e['opt']);
			}
		?></select>
	</div>

	<!-- [SUBJECT] -->
	<div class="form-wrap-head">Subject</div>
	<div class="form-wrap-body">
		<input type="text" class="form-control" id="email-subject" required>
	</div>

	<!-- [BODY] -->
	<div class="form-wrap-head">Message</div>
	<textarea id="cfg-text"></textarea>

	<!-- [EMAIL VARS] -->
	<div id="var-show"><?php
		foreach($_EMAIL as $i=>$e){
			echo "<div id='ev-".$i."' class='evar hide'>";
			printf("<input type='hidden' id='khead-%u' value='%s'>", $i, $e['khead']);
			printf("<input type='hidden' id='kbody-%u' value='%s'>", $i, $e['kbody']);
			foreach ($e['vars'] as $v) {
				echo $v." ";
			}
			echo "</div>";
		}
	?></div>

	<!-- [GO!] -->
	<div class="form-wrap-foot">
		<button class="btn btn-primary" type="submit">
			<i class="fa fa-check"></i>
		</button>
	</div>
</form>
<script src="<?=URL_ROOT?>public/tiny-mce/tinymce.min.js"></script>
<script>
var cfg = {
	sel : "",	// CURRENTLY SELECTED TEMPLATE
	khead : "",	// CUREENT CONFIG KEY FOR SUBJECT
	kbody : "", // CUREENT CONFIG KEY FOR BODY
	change : function(){
	// cfg.change() : change email template

		// SET THE EMAIL VARS
		cfg.sel = $('#sel-template').val();
		cfg.khead = $('#khead-'+cfg.sel).val();
		cfg.kbody = $('#kbody-'+cfg.sel).val();
		$('#var-show .evar').each(function(){
			var el = $(this);
			var id = el.attr("id").substring(3);
			if (id==cfg.sel) {
				el.removeClass("hide");
			} else {
				el.addClass("hide");
			}
		});

		// AJAX CALL TO FETCH SUBJECT & BODY
		cb.api({
			module : "admin/sys",
			data : {
				req : "get-cfg-key",
				config_key : [cfg.khead, cfg.kbody]
			},
			notipass : 0,
			pass : function(res){
				$('#email-subject').val(res['cb-more'][cfg.khead]['config_value']);
				tinymce.get('cfg-text').setContent(res['cb-more'][cfg.kbody]['config_value']);
			}
		});
	},

	save : function(){
	// cfg.save() : save the template

		var data = {
			req : "set-cfg",
			config : {}
		};
		data.config[cfg.khead] = $('#email-subject').val();
		data.config[cfg.kbody] = tinymce.get('cfg-text').getContent();
		cb.api({
			module : "admin/sys",
			data : data
		});
		return false;
	}
};

function elf (callback, value, meta) {
	tinymce.activeEditor.windowManager.open({
		file: cb.admurl+'AJAX/elf',
		title: 'elFinder 2.1',
		width: 900,
		height: 450,
		resizable: 'yes'
	}, { oninsert: function (file, fm) {
		var url, reg, info;
		url = fm.convAbsUrl(file.url);
		info = file.name + ' (' + fm.formatSize(file.size) + ')';
		if (meta.filetype == 'file') {
			callback(url, {text: info, title: info});
		}
		if (meta.filetype == 'image') {
			callback(url, {alt: info});
		}
		if (meta.filetype == 'media') {
			callback(url);
		}
	}});
	return false;
}

$(document).ready(function() {
	tinymce.init({
		selector:'#cfg-text',
		relative_urls: false,
		remove_script_host: false,
		convert_urls: false,
		menubar: 'edit format table',
		toolbar1: 'formatselect | bold italic strikethrough | forecolor backcolor removeformat | image link unlink | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | table code',
		plugins : 'table code lists link textcolor image',
		file_picker_callback : elf
	}).then(cfg.change);
});
</script>
<style>
#var-show{ font-size:14px; padding:10px; }
.evar.hide{display:none;}
</style>	