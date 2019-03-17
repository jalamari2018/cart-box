<?php
/*
 * PAGE-LOGIN.PHP : LOGIN PAGE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<div class="container"><div class="row"><div class="col-md-8 offset-md-2">
	<form id="login-form" onsubmit="return user.signin();">
		<div id="login-title">
			Please Sign in
		</div>
		<img id="login-img" src="<?= URL_ROOT ?>public/img/box.jpg">
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">
					<i class="fa fa-envelope"></i>
				</span>
			</div>
			<input type="text" class="form-control" id="user_email" placeholder="Email" required autofocus>
		</div>
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">
					<i class="fa fa-key"></i>
				</span>
			</div>
			<input type="password" class="form-control" id="user_password" placeholder="Password" required>
		</div>
		<button class="btn btn-danger btn-block" type="submit">Sign in</button>
		<p id="login-links">
			<a href="#" onclick="user.forgot();">&rarr; Forgot your password?</a><br>
			<a href="<?= URL_ROOT ?>">&rarr; Back to shop</a>
		</p>
	</form>
</div></div></div>

<style>
#page-content{
	background: #f1ebc6;
}

#login-form{
	background: #353535;
	max-width: 500px;
	padding: 40px 50px 10px 50px;
	margin: 50px auto 0 auto;
	border-radius: 10px;
}

#login-title{
	color:#fff;
	text-transform: uppercase;
	text-align:center;
	font-size:24px;
	font-weight:500;
}

#login-img {
	width: 150px;
	height: 150px;
	margin: 15px auto 20px auto;
	display: block;
	-moz-border-radius: 50%;
	-webkit-border-radius: 50%;
	border-radius: 50%;
}

#login-form .input-group{
	margin-bottom:20px;
}

#login-form .input-group-text{
	background:#dc3545;
	color:#fff;
}

#login-links{
	margin-top:15px;
}

#login-links a{
	color:#fff;
}
</style>

<script>
var user = {
	signin : function(){
	// signin() : process sign in

		cb.api({
			module : "user",
			data : {
				req : "login",
				user_email : $('#user_email').val(),
				user_password : $('#user_password').val()
			},
			notipass : 0,
			pass : function(){
				location.href = cb.admurl;
			}
		});
		return false;
	},

	forgot : function(){
	// forgot() : forgot password

		var email = $('#user_email').val();
		if (email=="") {
			cb.mshow({
				title : "Please enter your email",
				body : "Enter your email into the login box above, and we will send you the reset request."
			});
		} else {
			cb.api({
				module : "user",
				data : {
					req : "forgot",
					user_email : $('#user_email').val()
				}
			});
		}
	}
};
</script>