<?php
/*
 * CLASS USER : USER
 * REQUIRES MODULE : DB
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

class User {
	function signin($email="", $password=""){
	// signin() : check given email & password
	// PARAM $email : email
	//       $password : password

		// GET USER
		$user = $this->getEmail($email);

		// NOT FOUND
		if ($user==false) {
			$this->CB->verbose(0,"USER","المستخدم غير موجود");
			return false;
		}

		// SUSPENDED OR NOT ACTIVATED
		if ($user['user_active']!=1) {
			$this->CB->verbose(0,"USER","عفوا الحساب ليس نشط");
			return false;
		}

		// CHECK PASSWORD
		if ($this->CB->decrypt($user['user_password'])!=$password) {
			$this->CB->verbose(0,"USER","خطأ في اسم المستخدم او كلمة المرور");
			return false;
		}

		// SIGN IN SESSION
		$_SESSION['user'] = $user;
		return true;
	}

	function getAll($search=null, $page=null){
	// getAll() : get all users
	// PARAM $search : email/name search
	//       $page : the current page, will limit number of results - for pagination

		$sql = "SELECT * FROM `users`";
		$cond = null;
		if ($search) {
			$sql .= " WHERE `user_name` LIKE ? OR `user_email` LIKE ?";
			$cond = ["%$search%", "%$search%"];
		}
		if (is_numeric($page)) {
			$sql .= $this->CB->slimit($page);
		}
		$user = $this->CB->DB->select($sql,$cond,"user_id");
		return empty($user) ? false : $user ;
	}

	function count($search){
	// count() : count total number of users
	// PARAM $search : email/name search

		$sql = "SELECT COUNT(*) AS `cnt` FROM `users`";
		$cond = null;
		if ($search) {
			$sql .= " WHERE `user_name` LIKE ? OR `user_email` LIKE ?";
			$cond = ["%$search%", "%$search%"];
		}
		$cnt = $this->CB->DB->select($sql, $cond);
		return is_numeric($cnt[0]['cnt']) ? $cnt[0]['cnt'] : 0 ;
	}

	function getID($id=""){
	// getID() : get user by ID
	// PARAM $id : user ID

		$user = $this->CB->DB->select(
			"SELECT * FROM `users` WHERE `user_id`=?",
			[$id]
		);

		return count($user)==1 ? $user[0] : false ;
	}

	function getEmail($email="", $excl=""){
	// getEmail() : get user by email
	// PARAM $email : user email
	//       $excl : exclude this user ID, good for checking update account

		$sql = "SELECT * FROM `users` WHERE `user_email`=?";
		$cond = [$email];
		if (is_numeric($excl)) {
			$sql .= " AND `user_id`!=?";
			$cond[] = $excl;
		}

		$user = $this->CB->DB->select($sql, $cond);
		return count($user)==1 ? $user[0] : false ;
	}

	function checkReg($email="", $excl=""){
	// checkReg() : check if given email is already registered
	// PARAM $email : user email
	//       $excl : exclude this user ID, good for checking update account

		if ($email=="") { return true; }
		$user = $this->getEmail($email,$excl);
		return is_array($user);
	}

	function add($user,$redirect=""){
	// add() : add new user
	// PARAM $user : array - user_name, user_email, user_password (in plain text), user_level, user_active
	//       $redirect : redirect user to this slug after activation > for activation email

		// ADD USER
		$this->CB->DB->start();
		$sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_active`, `user_password`, `user_level`) VALUES (?,?,?,?,?)";
		$cond = array($user['user_name'], $user['user_email'], $user['user_active'], $this->CB->crypt($user['user_password']), $user['user_level']);
		$pass = $this->CB->DB->query($sql, $cond);

		// EMAIL ACTIVATION FOR NEW REGISTRATION
		if ($pass && ($user['user_active']=="2" || $user['user_active']==2)) {
			// GENERATE HASH
			$user['user_id'] = $this->CB->DB->lastID;
			$hash = $this->CB->random(24);
			$link = URL_ROOT.SLUG_ACTIVATE."/?t=a&i=".$user['user_id']."&h=".$hash;
			if ($redirect!="") { $link .= "&r=".$redirect; }
			$subject = $this->CB->getCFGKey("TITLE_USER_ACTIVATE");
			$subject = $subject[0]['config_value'];
			$msg = $this->CB->getCFGKey("EMAIL_USER_ACTIVATE");
			$msg = $msg[0]['config_value'];
			$msg = str_replace("{user_name}",$user['user_name'],$msg);
			$msg = str_replace("{user_email}",$user['user_email'],$msg);
			$msg = str_replace("{link}",$link,$msg);
			$msg = str_replace("{expire}",ACTIVATE_EXPIRE,$msg);

			// SEND MAIL
			$pass = $this->CB->mail($user['user_email'],$subject,$msg);

			// UPDATE HASH
			if ($pass) {
				$pass = $this->CB->DB->query(
					"UPDATE `users` SET `user_hash`=?, `hash_date`=? WHERE `user_id`=?",
					[$hash, date("Y-m-d H:i:s"), $user['user_id']]
				);
			}
		}

		// COMMIT ON PASS / ROLLBACK ON FAILURE
		$this->CB->DB->end($pass);
		return $pass;
	}

	function edit($user){
	// edit() : upate user
	// PARAM $user : array - user_id, user_name, user_email, user_password (optional, in plain text) | admin ONLY -> user_lvl, user_active

		$sql = "UPDATE `users` SET `user_name`=?, `user_email`=?";
		$cond = array($user['user_name'], $user['user_email']);
		if (isset($user['user_password']) && $user['user_password']!="") {
			$sql .= ", `user_password`=?";
			$cond[] = $this->CB->crypt($user['user_password']);
		}
		if (isset($user['user_level'])) {
			$sql .= ", `user_level`=?";
			$cond[] = $user['user_level'];
		}
		if (isset($user['user_active'])) {
			$sql .= ", `user_active`=?";
			$cond[] = $user['user_active'];
		}
		$sql .= " WHERE `user_id`=?";
		$cond[] = $user['user_id'];
		if (!$this->CB->DB->query($sql, $cond)){ return false; }
		return true;
	}

	function togstat($id=0,$stat=1){
	// togstat() : toggle user active/suspended
	// PARAM $id : user ID
	//       $stat : user status

		if (!$this->CB->DB->query(
			"UPDATE `users` SET `user_active`=? WHERE `user_id`=?",
			[$stat,$id]
		)){ return false; }
		return true;
	}

	function del($id=0){
	// del() : delete user
	// PARAM $id : user ID

		if (!$this->CB->DB->query(
			"DELETE FROM `users` WHERE `user_id`=?",
			[$id]
		)){ return false; }
		return true;
	}

	function forgotA($email,$redirect=""){
	// forgot() : forgot password part A  - generate hash and send email
	// PARAM $email : user email
	//       $redirect : optional, redirect to this slug after success

		// GET AND CHECK USER
		$user = $this->getEmail($email);
		if ($user==false) { 
			$this->CB->verbose(0,"USER"," عفوا انت لست مسجل  ");
			return false;
		}

		if ($user['user_active']==0) {
			$this->CB->verbose(0,"USER","عفوا تم تعليق عضويتك لدينا.");
			return false;
		}

		// GENERATE HASH & EMAIL
		$hash = $this->CB->random(24);
		$link = URL_ROOT.SLUG_ACTIVATE."/?t=f&i=".$user['user_id']."&h=".$hash;
		if ($redirect!="") { $link .= "&r=".$redirect; }
		$subject = $this->CB->getCFGKey("TITLE_USER_FORGOT");
		$subject = $subject[0]['config_value'];
		$msg = $this->CB->getCFGKey("EMAIL_USER_FORGOT");
		$msg = $msg[0]['config_value'];
		$msg = str_replace("{user_name}",$user['user_name'],$msg);
		$msg = str_replace("{user_email}",$user['user_email'],$msg);
		$msg = str_replace("{link}",$link,$msg);
		$msg = str_replace("{expire}",ACTIVATE_EXPIRE,$msg);

		// UPDATE HASH
		$this->CB->DB->start();
		$pass = $this->CB->DB->query(
			"UPDATE `users` SET `user_hash`=?, `hash_date`=? WHERE `user_id`=?",
			[$hash, date("Y-m-d H:i:s"), $user['user_id']]
		);

		// SEND MAIL
		if ($pass) {
			$pass = $this->CB->mail($user['user_email'],$subject,$msg);
		}

		// COMMIT ON PASS, ROLLBACK ON FAIL
		$this->CB->DB->end($pass);
		return $pass;
	}

	function forgotB($id=0,$hash=""){
	// forgotB() : verify and complete password reset
	// PARAM $id : user ID
	//       $hash : hash

		// GET AND CHECK
		$user = $this->getID($id);
		if ($user==false) { 
			$this->CB->verbose(0,"USER","المستخدم غير مسجل في النظام");
			return false;
		}

		if ($user['user_active']==0) {
			$this->CB->verbose(0,"USER","عفوا تم تعليق عضويتكم لدينا");
			return false;
		}

		if ($user['hash_date']=="") {
			$this->CB->verbose(0,"USER","لايوجد طلب تغيير كلمة مرور لدينا");
			return false;
		}

		if (strtotime("now") > strtotime($user['hash_date']) + (ACTIVATE_EXPIRE * 3600)) {
			$this->CB->verbose(0,"USER","انتهت صلاحية طلب استعادة كلمة المرور");
			return false;
		}

		if ($user['user_hash']!=$hash) {
			$this->CB->verbose(0,"USER","Provided hash does not match");
			return false;
		}

		// GENERATE NEW PASSWORD & EMAIL
		$password = $this->CB->random(12);
		$subject = $this->CB->getCFGKey("TITLE_USER_RESET");
		$subject = $subject[0]['config_value'];
		$msg = $this->CB->getCFGKey("EMAIL_USER_RESET");
		$msg = $msg[0]['config_value'];
		$msg = str_replace("{user_name}",$user['user_name'],$msg);
		$msg = str_replace("{user_email}",$user['user_email'],$msg);
		$msg = str_replace("{password}",$password,$msg);

		// REMOVE HASH & UPDATE PASSWORD
		$this->CB->DB->start();
		$pass = $this->CB->DB->query(
			"UPDATE `users` SET `user_active`=1, `user_hash`=NULL, `hash_date`=NULL, `user_password`=? WHERE `user_id`=?",
			[$this->CB->crypt($password), $id]
		);

		// SEND EMAIL
		if ($pass) {
			$pass = $this->CB->mail($user['user_email'],$subject,$msg);
		}

		// COMMIT ON PASS, ROLLBACK ON FAIL
		$this->CB->DB->end($pass);
		return $pass;
	}

	function activate($id=0,$hash=""){
	// activate() : verify and complete account activation
	// PARAM $id : user ID
	//       $hash : hash

		// GET AND CHECK
		$user = $this->getID($id);
		if ($user==false) { 
			$this->CB->verbose(0,"USER","المستحدم غير موجود");
			return false;
		}

		if ($user['user_active']==0) {
			$this->CB->verbose(0,"USER","تم تعليق عضويتك لدينا");
			return false;
		}

		if ($user['hash_date']=="") {
			$this->CB->verbose(0,"USER","لم يتم العثور على طلب التنشيط");
			return false;
		}

		if (strtotime("now") > strtotime($user['hash_date']) + (ACTIVATE_EXPIRE * 3600)) {
			$this->CB->verbose(0,"USER","عفوا انتهت صلاحية رابط التنشيط ");
			return false;
		}

		if ($user['user_hash']!=$hash) {
			$this->CB->verbose(0,"USER","Provided hash does not match");
			return false;
		}

		// WELCOME EMAIL
		$subject = $this->CB->getCFGKey("TITLE_USER_REG");
		$subject = $subject[0]['config_value'];
		$msg = $this->CB->getCFGKey("EMAIL_USER_REG");
		$msg = $msg[0]['config_value'];
		$msg = str_replace("{user_name}",$user['user_name'],$msg);
		$msg = str_replace("{user_email}",$user['user_email'],$msg);
		$msg = str_replace("{password}",$this->CB->decrypt($user['user_password']),$msg);

		// REMOVE HASH
		$this->CB->DB->start();
		$pass = $this->CB->DB->query(
			"UPDATE `users` SET `user_active`=1, `user_hash`=NULL, `hash_date`=NULL WHERE `user_id`=?",
			[$id]
		);

		// SEND MAIL
		if ($pass) {
			$pass = $this->CB->mail($user['user_email'],$subject,$msg);
		}

		// COMMIT ON PASS, ROLLBACK ON FAIL
		$this->CB->DB->end($pass);
		return $pass;
	}
}
?>