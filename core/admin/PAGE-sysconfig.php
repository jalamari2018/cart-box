<?php
/*
 * PAGE-SYSCONFIG.PHP : SYSTEM CONFIG
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<form onsubmit="return cfg.save();" id="cfg_form" class="sublist form-limit">
	<div class="form-wrap-head">
		System Settings
	</div>
	<table class="table" id="cfg-table">
		<?php foreach ($cfg as $c) { ?>
		<tr>
			<td>
				<div><?=$c['config_desc']?></div>
				<small class="ckey"><?=$c['config_key']?></small>
			</td>
			<td>
				<input type="text" class="form-control" id="v_<?=$c['config_key']?>" value="<?=$c['config_value']?>" required/>
			</td>
		</tr>
		<?php } ?>
	</table>
	<div class="form-wrap-foot">
		<button type="submit" class="btn btn-primary">
			<i class="fa fa-check"></i>
		</button>
	</div>
</form>
<script>
var cfg = {
	save : function(){
	// cfg.save() : save config

		var data = {
			req : "set-cfg",
			config : {}
		};
		var key = "";
		$('#cfg_form .ckey').each(function(){
			key = $(this).html();
			data.config[key] = $('#v_'+key).val();
		});
		cb.api({
			module : "admin/sys",
			data : data
		});
		return false;
	}
};
</script>