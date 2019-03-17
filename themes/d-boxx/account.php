<?php
/*
 * ACCOUNT.PHP : NEW/UPDATE ACCOUNT
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// THEME PATHS
require PATH_THEME."lib".DIRECTORY_SEPARATOR."site_def.php";

// HTML
require T_LIB."site_top.php"; ?>
<div class="spacer"></div>
<div class="container" dir="rtl"><div class="row"><div class="col-md-8 offset-md-2">
<form onsubmit="return user.save();" id="user_form" class="form-wrap">
	<div class="form-wrap-head">
		<?=$_PAGE['edit']?"My Account":"تسجيل حساب جديد"?>
	</div>
	<div class="form-wrap-body">
		<input type="hidden" class="form-control" id="user_id" value="<?=$_SESSION['user']['user_id']?>">
		<div class="form-group">
			<label for="user_name">* اسمك</label>
			<input type="text" class="form-control" id="user_name" placeholder="الاسم" value="<?=$_SESSION['user']['user_name']?>" required autofocus>
			<div class="invalid-feedback" id="e_user_name"></div>
		</div>
		<div class="form-group">
			<label for="user_email">* البريد الالكتروني</label>
			<input type="text" class="form-control" id="user_email" placeholder="البريد الالكتروني" value="<?=$_SESSION['user']['user_email']?>" required>
			<div class="invalid-feedback" id="e_user_email"></div>
		</div>
		<div class="form-group">
			<label for="user_password"><?=($_PAGE['edit']?"":"* ")?>كلمة المرور</label>
			<input type="password" class="form-control" id="user_password" placeholder="كلمة المرور"<?=($_PAGE['edit']?"":" required")?>>
			<div class="invalid-feedback" id="e_user_password"></div>
		</div>
		<div class="form-group">
			<label for="confirm_password"><?=($_PAGE['edit']?"":"* ")?>تأكيد كلمة المرور</label>
			<input type="password" class="form-control" id="confirm_password" placeholder="تأكيد كلمة المرور"<?=($_PAGE['edit']?"":" required")?>>
			<div class="invalid-feedback" id="e_confirm_password"></div>
		</div>
	</div>
	<div class="form-wrap-foot">
		<button type="submit" class="btn btn-primary">
			<i class="fa fa-check"></i> حفظ
		</button>
	</div>
</form>
</div></div></div>
<script>
var user = {
	save : function(){
	// save() : save user

		// SOME SETUP...
		var userID = $('#user_id').val();
		var notipass = 2;
		var pass = null;

		// NEW REGISTRATION ONLY - REDIRECT ON SUCESSFUL REGISTRATION
		if (userID=="") {
			notipass = 0;
			pass = function(res){
				location.href = cb.rooturl+"regsuccess";
			};
		}

		cb.api({
			module : "user",
			data : {
				req : (userID=="" ? "reg" : "update") ,
				user_id : $('#user_id').val(),
				user_name : $('#user_name').val(),
				user_email : $('#user_email').val(),
				user_password : $('#user_password').val(),
				confirm_password : $('#confirm_password').val()
			},
			notipass : notipass,
			before : function(){
				var err = $("#user_form .is-invalid");
				if (err.length>0) {
					err.each(function(){
						$(this).removeClass("is-invalid");
					});
				}
			},
			pass : pass,
			fail : function(res){
				for (var key in res['cb-more']) {
					$('#'+key).addClass("is-invalid");
					$('#e_'+key).html(res['cb-more'][key]);
				}
			}
		});
		return false;
	}
};
</script>
<?php require T_LIB."site_bottom.php"; ?>