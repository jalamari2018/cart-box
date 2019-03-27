<?php
/*
 * PAGE-USERS.PHP : ADMIN USERS
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<nav class='subnav'>
	<h3 class="float-left">Manage Users</h3>
	<form class="float-right" id="search-form" onsubmit="return users.search()">
		<input type="hidden" id="search-page" value="1">
		<input type="hidden" id="search-user" value="">
		<div class="input-group">
			<input type="text" class="form-control form-control-sm" id="entry-user" placeholder="Name or Email">
			<div class="input-group-append">
				<button type="submit" class="input-group-text">
					<i class="fa fa-search"></i>
				</button>
				<span class="input-group-text" onclick="users.addedit()">
					<i class="fa fa-plus"></i>
				</span>
			</div>
		</div>
	</form>
</nav>
<div id="users-list" class="sublist"></div>
<script>
var users = {
	list : function(){
	// list() : show list of users

		cb.load({
			to : "users-list",
			module : "users",
			data : { 
				req : "list",
				page : $('#search-page').val(),
				search : $('#search-user').val()
			}
		});
	},

	pg : function(pg){
	// pg() : go to selected page

		$('#search-page').val(pg);
		users.list();
	},

	search : function(){
	// search() : search for users

		$('#search-page').val("1");
		$('#search-user').val($('#entry-user').val());
		users.list();
		return false;
	},

	addedit : function(id){
	// addedit() : add/edit user
	// PARAM id : user ID, add new user if none

		cb.page("B");
		cb.load({
			to : "page-B",
			module : "users",
			data : { 
				req : "addedit",
				user_id : id
			}
		});
	},

	save : function(){
	// save() : save user

		cb.api({
			module : "admin/user",
			data : {
				req : ($('#user_id').val()=="" ? "add" : "update"),
				user_id : $('#user_id').val(),
				user_name : $('#user_name').val(),
				user_email : $('#user_email').val(),
				user_level : $('#user_level').val(),
				user_active : $('#user_active').val(),
				user_password : $('#user_password').val(),
				confirm_password : $('#confirm_password').val()
			},
			before : function(){
				var err = $("#user_form .is-invalid");
				if (err.length>0) {
					err.each(function(){
						$(this).removeClass("is-invalid");
					});
				}
			},
			pass : function(res){
				users.list();
				if ($('#user_id').val()=="") {
					users.addedit(res['cb-more']);
				} else {
					users.addedit($('#user_id').val());
				}
			},
			fail : function(res){
				for (var key in res['cb-more']) {
					$('#'+key).addClass("is-invalid");
					$('#e_'+key).html(res['cb-more'][key]);
				}
			}
		});
		return false;
	},

	ctog : function(id,stat){
	// togact() : confirm toggle activate/suspend
	// PARAM id : user ID
	//       stat : current user status

		cb.mshow({
			title : "<i class='fa fa-question-circle'></i> " + (stat==1 ? "Suspend user?" : "Activate user?"),
			body : "Are you sure you want to " + (stat?"suspend":"activate") + " the selected user?",
			footer : '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button> <button type="button" class="btn btn-primary" onclick="users.tog('+id+','+stat+')"><i class="fa fa-check"></i></button>'
		});
	},

	tog : function(id,stat){
	// togact() : toggle activate/suspend
	// PARAM id : user ID
	//       stat : current user status

		cb.mhide();
		cb.api({
			module : "admin/user",
			data : {
				req : (stat?"suspend":"activate"),
				user_id : id
			},
			pass : function(){
				users.list();
			}
		});
	},

	cdel : function(id){
	// cdel() : confirm delete user
	// PARAM id : user ID

		cb.mshow({
			title : "<i class='fa fa-question-circle'></i> Delete user?",
			body : "User data will be lost!",
			footer : '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button> <button type="button" class="btn btn-primary" onclick="users.del('+id+')"><i class="fa fa-check"></i></button>'
		});
	},

	del : function(id){
	// del() : delete user
	// PARAM id : user ID

		cb.mhide();
		cb.api({
			module : "admin/user",
			data : {
				req : "del",
				user_id : id
			},
			pass : function(){
				users.list();
			}
		});
	}
};

$(document).ready(function() {
	users.list();
});
</script>