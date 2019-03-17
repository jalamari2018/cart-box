<?php
/*
 * AJAX-USERS.PHP : AJAX USERS HANDLER
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// USER LEVELS & STATUS
$_USR = ["USR"=>"User","ADM"=>"Administrator"];
$_USTAT = array(1=>"Active", 2=>"Pending Activation", 0=>"Suspended");

// MANAGE REQUESTS
$_CB->extend("User");
switch ($_POST['req']){
	/* [DEFAULT] */
	default:
		die("Invalid request");
		break;

	/* [LIST USERS] */
	case "list":
		$pages = $_CB->pages($_CB->User->count($_POST['search']));
		$page = is_numeric($_POST['page']) ? $_POST['page'] : 1 ;
		if ($page > $pages) { $page = $pages; }
		$users = $_CB->User->getAll($_POST['search'], $page); ?>
		<div class="table-responsive">
			<?php if (is_array($users)) { ?>
			<table class="table">
			<?php foreach ($users as $id=>$u) { ?>
			<tr>
				<td>
					<?php if ($u['user_pic']) { ?>
					<img class="nail" src="<?=URL_UPLOADS?><?=$p['user_pic']?>">
					<?php } else { ?>
					<div class="nail"></div>
					<?php } ?>
					<div class="dataA">
						<i class="fa fa-user"></i> <?=$u['user_name']?>
					</div>
					<div class="dataB">
						<i class="fa fa-envelope"></i> <?=$u['user_email']?>
					</div>
					<div class="dataB">
						<i class="fa fa-key"></i> <?=$_USR[$u['user_level']]?>
					</div>
				</td>
				<td style="text-align:right">
					<span class="btn btn-danger" onclick="users.cdel(<?=$id?>);">
						<i class="fa fa-window-close"></i>
					</span>
					<span class="btn btn-<?= $u['user_active'] ? "success" : "danger" ?>" onclick="users.ctog(<?=$id?>,<?=$u['user_active']?>);">
						<i class="fa fa-lock<?= $u['user_active'] ? "-open" : "" ?>"></i>
					</span>
					<span class="btn btn-primary" onclick="users.addedit(<?=$id?>)">
						<i class="fa fa-edit"></i>
					</span>
				</td>
			</tr>
			<?php } ?>
			</table>
			<?php } else { ?>
			<div class="nolist">
				<i class="fa fa-exclamation-circle"></i> No users found.
			</div>
			<?php } ?>
		</div>
		<?php
		if ($pages>1) {
			$_CB->extend("ATheme");
			$_CB->ATheme->paginate($pages,$page,"users.pg");
		}
		break;

	/* [ADD/EDIT USERS] */
	case "addedit":	
		if (is_numeric($_POST['user_id'])) {
			$user = $_CB->User->getID($_POST['user_id']);
		}
		$edit = is_array($user);
		$user['user_active'] = is_numeric($user['user_active']) ? $user['user_active'] : 1 ; ?>
		<form onsubmit="return users.save();" id="user_form" class="form-wrap form-limit">
			<div class="form-wrap-head">
				<?=($edit?"Edit":"Add")?> User
			</div>
			<div class="form-wrap-body">
				<input type="hidden" class="form-control" id="user_id" value="<?=$user['user_id']?>">
				<div class="form-group">
					<label for="user_name">* Name</label>
					<input type="text" class="form-control" id="user_name" placeholder="Full name" value="<?=$user['user_name']?>" required autofocus>
					<div class="invalid-feedback" id="e_user_name"></div>
				</div>
				<div class="form-group">
					<label for="user_email">* Email Address</label>
					<input type="text" class="form-control" id="user_email" placeholder="Email address" value="<?=$user['user_email']?>" required>
					<div class="invalid-feedback" id="e_user_email"></div>
				</div>
				<div class="form-group">
					<label for="user_level">* User Level</label>
					<select class="form-control" id="user_level"><?php
						foreach ($_USR as $lvl=>$txt) {
							printf("<option value='%s'%s>%s</option>", 
								$lvl, $lvl==$user['user_level']?" selected":"", $txt
							);
						}
					?></select>
					<div class="invalid-feedback" id="e_user_level"></div>
				</div>
				<div class="form-group">
					<label for="user_active">* User Status</label>
					<select class="form-control" id="user_active"><?php
						foreach ($_USTAT as $k=>$n) {
							printf("<option value='%s'%s>%s</option>", 
								$k, $k==$user['user_active']?" selected":"", $n
							);
						}
					?></select>
					<div class="invalid-feedback" id="e_user_active"></div>
				</div>
				<div class="form-group">
					<label for="user_password"><?=($edit?"":"* ")?>Password</label>
					<input type="password" class="form-control" id="user_password" placeholder="Password"<?=($edit?"":" required")?>>
					<div class="invalid-feedback" id="e_user_password"></div>
				</div>
				<div class="form-group">
					<label for="confirm_password"><?=($edit?"":"* ")?>Confirm Password</label>
					<input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password"<?=($edit?"":" required")?>>
					<div class="invalid-feedback" id="e_confirm_password"></div>
				</div>
			</div>
			<div class="form-wrap-foot">
				<span class="btn btn-danger" onclick="cb.page('A')">
					<i class="fa fa-reply"></i>
				</span>
				<button type="submit" class="btn btn-primary">
					<i class="fa fa-check"></i>
				</button>
			</div>
		</form>
		<?php
		break;
}
?>