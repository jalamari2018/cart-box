<?php
/*
 * INDEX.PHP : WHERE IT ALL STARTS
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

class CartBoxx {
	/* [SYSTEM BASICS] */
	public $url = "";
	public $udepth = 1;
	function init(){
	// init() : kick start the cart boxx engine

		/* [SET THE BASE PATHS] */
		// MANUALLY DEFINE THESE IF YOU HAVE TROUBLES
		define('PATH_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
		define('PATH_CORE', PATH_ROOT . "core" . DIRECTORY_SEPARATOR);
		define('PATH_UPLOAD', PATH_ROOT . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR);
		define('PATH_LIB', PATH_CORE . "lib" . DIRECTORY_SEPARATOR);
		define('PATH_API', PATH_CORE . "api" . DIRECTORY_SEPARATOR);
		define('PATH_HOOK', PATH_CORE . "hook" . DIRECTORY_SEPARATOR);
		define('PATH_ADMIN', PATH_CORE . "admin" . DIRECTORY_SEPARATOR);

		/* [LOAD CONFIG FILE] */
		if (!file_exists(PATH_CORE . "config.php")) {
			$this->verbose(0,"CB","Cannot load config file!","",1);
		}
		require PATH_CORE . "config.php";

		/* [START COOKIE SESSION] */
		if (session_start()==false) {
			$this->verbose(0,"CB","Failed to start cookie session!","",1);
		}

		/* [LOAD DATABASE MODULE] */
		if (!file_exists(PATH_LIB."LIB_DB.php")) {
			$this->verbose(0,"CB","Failed to load database module!","",1);
		}
		$this->extend("DB");
		$this->DB->connect();

		/* [URL & SLUGS & PATHS] */
		$this->getCFG(array(0,1));
		define('URL_UPLOADS', URL_ROOT . (substr(URL_ROOT,-1)=="/"?"":"/") . "uploads/");
		define('URL_API', URL_ROOT . (substr(URL_ROOT,-1)=="/"?"":"/") . SLUG_API. "/");
		define('URL_ADMIN', URL_ROOT . (substr(URL_ROOT,-1)=="/"?"":"/") . SLUG_ADMIN . "/");
		define('URL_THEME', URL_ROOT . (substr(URL_ROOT,-1)=="/"?"":"/") . "themes/" . SITE_THEME . "/");
		define('PATH_THEME', PATH_ROOT . "themes" . DIRECTORY_SEPARATOR . SITE_THEME . DIRECTORY_SEPARATOR);

		/* [THE CURRENT URL PATH] */
		// YOU CAN USE $this->url IN THEMES OR API ENDPOINT DEVELOPMENT
		// E.G. if($this->url[$this->url.length-1] == "cart")
		$this->url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$this->url = strtok($this->url,'?');
		if (strpos($this->url,URL_ROOT)===false) {
			$this->verbose(0,"CB","URL mismatch, please configure the base URL properly","",1);
		} else {
			$this->url = substr($this->url, strlen(URL_ROOT));
			if (substr($this->url,0,1)=="/") { $this->url = substr($this->url,1,strlen($this->url)); }
			if (substr($this->url,-1)=="/") { $this->url = substr($this->url,0,-1); }
			$this->url = explode("/", $this->url);
		}
	}

	public $sysmsg="";
	function verbose($status=0,$module="",$msg="",$more="",$halt=0){
	// verbose() : system message handler
	// PARAM $status : process status - 1 pass, 0 fail
	//       $module : related module
	//       $msg : system message
	//       $more : extra messages
	//       $halt : halt the system & throw message?

		$this->sysmsg = json_encode(array(
			"cb-status" => $status,
			"cb-mod" => $module,
			"cb-msg" => $msg,
			"cb-more" => $more
		));
		if ($halt) { die($this->sysmsg); }
	}

	function extended($branch=""){
	// extended() : check if branch is already extended
	// PARAM $branch : branch to check

		if (!isset($this->$branch)) { return false; }
		return gettype($this->$branch)=="object";
	}

	function extend($branch=""){ 
	// extend() : extend the specified branch
	// PARAM $branch : which branch to extend?

		// JOKER. NO BRANCH DEFINED.
		if ($branch=="") {
			$this->verbose(0,"CB", "No branch defined");
		}

		// ALREADY EXTENDED
		if ($this->extended($branch)) { return true; }

		// LOOK FOR LIBRARY PHYSICAL PATH
		$target = PATH_LIB . "LIB_" . $branch . ".php";
		if (!file_exists($target)) { 
			$this->verbose(0,"CB", "'$branch' library not found!");
			return false;
		}

		// EXTEND BRANCH
		require $target;
		$this->$branch = new $branch($this);

		// LINK BRANCH TO MAIN OBJECT
		$this->$branch->CB =& $this;
		$this->$branch->sysmsg =& $this->sysmsg;

		return true;
	}

	/* [CONFIG STORED IN DB] */
	function getCFG($group=0, $set=true){
	// getCFG() : get the config values within the given group
	// PARAM $key : config key (single int or array of group ids)
	//       $set : define the config key/value?

		// FORM THE SQL
		$sql = sprintf("SELECT %s FROM `config` WHERE `config_group`", $set?"`config_key`, `config_value`":"*");
		if (is_array($group)) {
			$sql .= " IN (";
			$cond = [];
			foreach ($group as $gid) {
				$sql .= "?,";
				$cond[] = $gid;
			}
			$sql = substr($sql,0,-1).");";
		} else {
			$sql .= "=?";
			$cond = [$group];
		}

		if ($set) {
			$cfg = $this->DB->select($sql,$cond,"config_key", "config_value");
			foreach ($cfg as $k=>$v) { define($k,$v); }
			return true;
		} else {
			return $this->DB->select($sql,$cond,is_array($group)?"config_key":null);
		}
	}

	function getCFGKey($key=""){
	// getCFGKey() : get config by key
	// PARMA $key : key

		$sql = "SELECT * FROM `config` WHERE `config_key`";
		if (is_array($key)) {
			$sql .= " IN (";
			$cond = [];
			foreach ($key as $k) {
				$sql .= "?,";
				$cond[] = $k;
			}
			$sql = substr($sql,0,-1).");";
		} else {
			$sql .= "=?";
			$cond = [$key];
		}

		return $this->DB->select($sql,$cond,is_array($key)?"config_key":null);
	}

	function setCFG($cfg){
	// setCFG() : set given config
	// PARAM $cfg : array of config [KEY=>VALUE]

		$this->DB->start();
		$pass = true;
		foreach ($cfg as $k=>$v) {
			$pass = $this->DB->query(
				"UPDATE `config` SET `config_value`=? WHERE `config_key`=?",
				[$v,$k]
			);
			if (!$pass) { break; }
		}
		$this->DB->end($pass);
		return $pass;
	}

	/* [CRYPTO] */
	function crypt($plain="", $cipher="AES-128-ECB", $key=SECRET_KEY){
	// crypt() : encode given string
	// PARAM $plain : data to be coded
	//       $cipher : encryption method, see http://php.net/manual/en/function.openssl-get-cipher-methods.php
	//       $key : secret key

		return openssl_encrypt($plain, $cipher, $key);
	}

	function decrypt($locked="", $cipher="AES-128-ECB", $key=SECRET_KEY){
	// decrypt() : decode given string
	// PARAM $locked : data to be decoded
	//       $cipher : encryption method, see http://php.net/manual/en/function.openssl-get-cipher-methods.php
	//       $key : secret key

		return openssl_decrypt($locked, $cipher, $key);
	}

	/* [EMAIL] */
	function mail($to="",$subject="",$msg="",$debug=false){
	// mail() : send mail
	// PARAM $to : email to
	//       $subject : subject
	//       $msg : email message
	//       $debug : save to file instead

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: <".MAIL_FROM.">" . "\r\n";
		$msg = "<html><body>" . $msg . "</body></html>";

		if ($debug) {
			$contents = $headers . "\r\n";
			$contents .= "TO: " . $to . "\r\n";
			$contents .= $msg;
			file_put_contents('email.txt', $contents);
			return true;
		} else {
			if(@mail($to,$subject,$msg,$headers)){ return true; }
			else {
				$this->verbose(0,"CB","Failed to send email");
				return false;
			}
		}
	}

	/* [RANDOM CONVINIENCE] */
	function random($length=8){
	// random() : generate a random string
	// PARAM $length : length of string

		// CREDITS : https://www.thecodedeveloper.com/generate-random-alphanumeric-string-with-php/
		return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	}

	function pages($total){
	// pages() : calculate the total number of pages
	// PARAM $total - total number of entries

		if (!is_numeric($total)) { return 0; }
		$pages = CEIL($total / PER_PAGE);
		return $pages;
	}

	function slimit($pg=1){
	// slimit() : generate LIMIT X,Y trailing sql
	// PARAM $pg : current page

		$start = PER_PAGE * ($pg-1);
		return " LIMIT " . $start . "," . PER_PAGE;
	}
}

/* [LAUNCH!] */
$_CB = new CartBoxx();
$_CB->init();

/* [HANDLE URL REQUESTS] */
switch ($_CB->url[0]) {
	// SHOW THEME
	default :
		// EXPECTING ONLY 1 LEVEL OF URL BY DEFAULT - I.E. HTTP://SITE.COM/PRODUCTS/
		// OVERRIDE THIS IN THE PAGE PRE-LOAD BELOW IF YOU MUST
		// E.G. PRODUCT/SLUG > ALLOW DEPTH 2, USE $_CB->URL[1] AS THE SLUG
		$_CB->udepth = 1;
		$page = $_CB->url[0] ? $_CB->url[0] : "index" ;

		// PAGE PRE-LOAD
		if (file_exists(PATH_THEME . "PRE-" . $page . ".php")) {
			require PATH_THEME . "PRE-" . $page . ".php";
		}

		// FILE & URL CHECKS
		$load = count($_CB->url) <= $_CB->udepth;
		if ($load) {
			$load = file_exists(PATH_THEME . $page . ".php");
		}

		// LOAD OR 404
		if ($load) {
			require PATH_THEME . $page . ".php";
		} else {
			header("HTTP/1.0 404 Not Found");
			// SHOW THE THEME 404
			if (file_exists(PATH_THEME . "404.php")) {
				require PATH_THEME . "404.php";
			}
			// USE THE DEFAULT ADMIN 404
			else {
				echo "<!DOCTYPE html><html><body>";
				require PATH_ADMIN."PAGE-404.php";
				echo "</body></html>";
			}
		}
		break;

	// USER FORGOT EMAIL & ACTIVATION
	case SLUG_ACTIVATE:
		/* [PART 1 - PROCESS REQUEST] */
		if (is_array($_SESSION['user'])) {
			// ALREADY SIGNED IN
			$_CB->verbose(0,"CB", "You are already signed in.","");
		}
		else {
			// FORGOT PASSWORD
			if ($_GET['t']=="f") {
				$_CB->extend("User");
				if ($_CB->User->forgotB($_GET['i'], $_GET['h'])) {
					$_CB->verbose(1,"CB", "تم ارسال كلمة السر الى بريدك");
				}
			}

			// ACTIVATE ACCOUNT & LOGIN
			else if ($_GET['t']=="a") {
				$_CB->extend("User");
				if ($_CB->User->activate($_GET['i'], $_GET['h'])) {
					$_SESSION['user'] = $_CB->User->getID($_GET['i']);
					$_CB->verbose(1,"CB", "تم تنشيط الحساب");
				}
			}

			// WHAT!?
			else { $_CB->verbose(0,"CB","Invalid request."); }
		}

		/* [PART 2 - DISPLAY RESULT/MESSAGE] */
		// REDIRECT SLUG IS PROVIDED
		if (isset($_GET['r'])) {
			header('Location: ' . URL_ROOT . $_GET['r']);
			die();
		}
		// DISH OUT HTML
		else {
			// SHOW THEME ACTIVATE IF EXIST
			if (file_exists(PATH_THEME . "activate.php")) {
				require PATH_THEME . "activate.php";
			}
			// FALL BACK TO SPARTAN ADMIN ACTIVATE PAGE
			else {
				require PATH_ADMIN . "PAGE-activate.php";
			}
		}
		break;

	// ADMIN MODE
	case SLUG_ADMIN :
		// AJAX MODE
		if ($_CB->url[1]=="AJAX") {
			// NO PERMISSION
			if (is_array($_SESSION['user']) && $_SESSION['user']['user_level']!="ADM") {
				die("You do not have permission to access this function");
			}

			// NOT SIGNED IN
			if (!is_array($_SESSION['user'])) {
				die("Please sign in first");
			}

			// EXPECTING ONLY 2 LEVELS OF URL BY DEFAULT - I.E. ADMIN/AJAX/MODULE
			if (count($_CB->url) > 3) {
				die("Invalid request");
			}

			// FIND THE HANDLER FILE
			if (!file_exists(PATH_ADMIN . "AJAX-" . $_CB->url[2] . ".php")) {
				die("Invalid request");
			}

			// LOAD
			require PATH_ADMIN . "AJAX-" . $_CB->url[2] . ".php";
		}

		// NORMAL ADMIN PAGE LOAD
		else {
			// KICK THOSE USERS BACK
			if (is_array($_SESSION['user']) && $_SESSION['user']['user_level']!="ADM") {
				header('Location: '.URL_ROOT);
				die();
			}

			// LOGIN PAGE
			if (!is_array($_SESSION['user']) && $_CB->url[1]!="login") {
				header('Location: '.URL_ADMIN."login");
				die();
			}
			if (is_array($_SESSION['user']) && $_CB->url[1]=="login") {
				header('Location: '.URL_ADMIN);
				die();
			}

			/* -------------------------------
			 * [ADMIN PAGE LOAD SEQUENCE]
			 * META => HOOK => ACTUAL PAGE
			 --------------------------------*/

			// EXPECTING ONLY 2 LEVELS OF URL BY DEFAULT - I.E. ADMIN/PAGE
			// OVERRIDE THIS IN THE PAGE META BELOW IF YOU MUST
			// E.G. ADMIN/COUPONS/CODE-HERE > ALLOW DEPTH 3, USE $_CB->URL[2] AS A VARIABLE
			$_CB->udepth = 2;

			// LOAD PAGE META INFORMATION + CHECK PAGE FILES EXIST
			$loadOK = file_exists(PATH_ADMIN . "META-" . ($_CB->url[1]?$_CB->url[1]:"home") . ".php") && file_exists(PATH_ADMIN . "PAGE-" . ($_CB->url[1]?$_CB->url[1]:"home") . ".php");
			if ($loadOK) {
				require PATH_ADMIN . "META-" . ($_CB->url[1]?$_CB->url[1]:"home") . ".php";
			}

			// CHECK ALLOWED URL DEPTH
			if (count($_CB->url) > $_CB->udepth) {
				$loadOK = false;
			}

			// LOAD HOOK - USE THIS TO DO PRE-PROCESSING
			if ($loadOK && file_exists(PATH_ADMIN . "HOOK-" . ($_CB->url[1]?$_CB->url[1]:"home") . ".php")) {
				require PATH_ADMIN . "HOOK-" . ($_CB->url[1]?$_CB->url[1]:"home") . ".php";
			}

			// LOAD THE HTML: THROW 404 IF NOT FOUND OR ILLEGAL URL
			if ($loadOK==false) {
				header("HTTP/1.0 404 Not Found");
				$_PAGE = array(
					"title" => "404 Not Found",
					"desc" => "File not found"
				);
				$_CB->url[1] = "404";
			}
			$_PAGE['adm'] = $_SESSION['user']['user_level'] == "ADM"; // KIND OF STUPID, BUT A FLAG TO SHOW/HIDE MENU ITEMS IN TEMPLATE
			require PATH_ADMIN . "SITE-top.php";
			require PATH_ADMIN . "PAGE-" . ($_CB->url[1]?$_CB->url[1]:"home") . ".php";
			require PATH_ADMIN . "SITE-bottom.php";
		}
		break;

	// API MODE
	case SLUG_API :
		// THE API JSON RESPONSE HEADERS
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: access");
		header("Access-Control-Allow-Methods: POST, GET");
		header("Access-Control-Allow-Credentials: true");
		header('Content-Type: application/json');

		// ADMIN API CALL
		if ($_CB->url[1]=="admin") {
			// PERMISSION CHECK
			if ($_SESSION['user']['user_level']!="ADM") {
				$_CB->verbose(0,"CB","You don't have permission to access this module","",1);
			}

			// EXPECTING ONLY 3 LEVELS OF URL BY DEFAULT -> API/ADMIN/MODULE
			$_CB->udepth = 3;

			// TARGET API LIBRARY FILE
			$loadfile = PATH_API . "API_ADMIN_" . $_CB->url[2] . ".php";
		}

		// "REGULAR USER API"
		else {
			// EXPECTING ONLY 2 LEVELS OF URL BY DEFAULT -> API/MODULE
			$_CB->udepth = 2;

			// TARGET API LIBRARY FILE
			$loadfile = PATH_API . "API_" . $_CB->url[1] . ".php";
		}

		// THROW A "NOT FOUND" ERROR IF URL DEPTH IS MORE THAN EXPECTED
		if (count($_CB->url) > $_CB->udepth) {
			$_CB->verbose(0,"CB", "Specified API is not found","",1);
		}

		// CHECK THE API LIBRARY FILE
		if (!file_exists($loadfile)) {
			$_CB->verbose(0,"CB", "Specified API is not found","",1);
		}

		// LOAD API HANDLER
		require $loadfile;
		break;
}
?>