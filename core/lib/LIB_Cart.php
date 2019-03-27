<?php
/*
 * CLASS CART : SHOPPING CART
 * REQUIRES MODULE : DB
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

class Cart {
	function __construct(){
		if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = array(); }
	}

	function count(){
	// count() : get total number of items in cart

		$c = 0;
		if (!empty($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $id=>$qty) {
				$c += $qty;
			}
		}
		return $c;
	}

	function show(){
	// show() : show the cart in details

		// EMPTY CART
		if (empty($_SESSION['cart'])) {
			$this->CB->verbose(0,"CART","سلة التسوق فارغة");
			return false;
		}

		// GET PRODUCTS
		$sql = "SELECT `product_id`, `product_name`, `product_image`, `product_price` FROM `products` WHERE `product_id` IN (";
		$cond = [];
		$show = ["cart"=>array(),"total"=>0];
		foreach ($_SESSION['cart'] as $pid=>$qty) {
			$sql .= "?,";
			$cond[] = $pid;
		}
		$sql = substr($sql,0,-1).");";
		$show['cart'] = $this->CB->DB->select($sql, $cond, "product_id");

		foreach ($_SESSION['cart'] as $pid=>$qty) {
			$show['cart'][$pid]['qty'] = $qty;
			$show['cart'][$pid]['total'] = $qty * $show['cart'][$pid]['product_price'];
			$show['total'] += $show['cart'][$pid]['total'];
		}
		return $show;
	}

	function add($id=0,$qty=0){
	// add() : add item to cart
	// PARAM $id : product ID
	//       $qty : quantity

		// CHECK VALID ID AND QTY
		if (!is_numeric($id) || !is_numeric($qty)) {
			$this->CB->verbose(0,"CART","خطأ في الكمية");
			return false;
		}

		// ADD TO CART
		if (isset($_SESSION['cart'][$id])) { $_SESSION['cart'][$id] += $qty; }
		else { $_SESSION['cart'][$id] = $qty; }
		if ($_SESSION['cart'][$id] > CART_MAX) { $_SESSION['cart'][$id] = CART_MAX; }

		return true;
	}

	function change($id=0,$qty=1){
	// change() : change item in cart
	// PARAM $id : product ID
	//       $qty : quantity

		// CHECK VALID ID AND QTY
		if (!is_numeric($id) || !is_numeric($qty)) {
			$this->CB->verbose(0,"CART","خطأ في الكمية");
			return false;
		}

		// CHANGE QUANTITY
		if ($qty==0) {
			unset($_SESSION['cart'][$id]);
		} else {
			$_SESSION['cart'][$id] = $qty;
			if ($_SESSION['cart'][$id] > CART_MAX) { $_SESSION['cart'][$id] = CART_MAX; }
		}

		return true;
	}

	function remove($id=0,$qty=0){
	// remove() : remove item from cart
	// PARAM $id : product ID
	//       $qty : quantity (if 0, will remove all)

		// CHECK VALID ID AND QTY
		if (!is_numeric($id) || !is_numeric($qty)) {
			$this->CB->verbose(0,"CART","خطأ في الكمية");
			return false;
		}

		// REMOVE FROM CART
		if ($qty==0) {
			unset($_SESSION['cart'][$id]);
		} else {
			if (isset($_SESSION['cart'][$id])) { $_SESSION['cart'][$id] -= $qty; }
			if ($_SESSION['cart'][$id] <= 0) { unset($_SESSION['cart'][$id]); }
		}

		return true;
	}

	function nuke(){
	// nuke() : empty all

		$_SESSION['cart'] = array();
		return true;
	}

	function checkout(){
	// checkout() : checkout the cart

		// EMPTY CART!?
		if (empty($_SESSION['cart'])) {
			$this->CB->verbose(0,"CART","سلة التسوق فارغة");
			return false;
		}

		// NO USER SESSION
		if (!is_array($_SESSION['user'])) {
			$this->CB->verbose(0,"CART","الرجاء تسجيل الدخول أولا");
			return false;
		}

		// GET CART IN DETAILS
		$show = $this->show();

		// CREATE ORDER
		$this->CB->DB->start();
		if (!$this->CB->DB->query(
			"INSERT INTO `orders` (`user_id`, `order_name`) VALUES (?,?)",
			[$_SESSION['user']['user_id'], $_SESSION['user']['user_name']]
		)){ 
			$this->CB->DB->end(0);
			return false;
		}

		// INSERT ITEMS - MIGHT NEED TO BREAK THIS UP INTO MULTIPLE QUERIES IF TOO MANY PRODUCTS
		$orderID = $this->CB->DB->lastID;
		$sql = "INSERT INTO `orders_products` (`order_id`,`product_id`,`product_name`,`product_image`,`product_price`,`quantity`) VALUES ";
		$cond = array();
		foreach ($show['cart'] as $pid=>$p) {
			$sql .= "(?,?,?,?,?,?),";
			$cond[] = $orderID;
			$cond[] = $pid;
			$cond[] = $p['product_name'];
			$cond[] = $p['product_image'];
			$cond[] = $p['product_price'];
			$cond[] = $p['qty'];
		}
		$sql = substr($sql,0,-1).";";
		if (!$this->CB->DB->query($sql,$cond)){
			$this->CB->DB->end(0);
			return false;
		}

		// INSERT TOTALS
		$sql = "INSERT INTO `orders_totals` (`order_id`, `total_text`, `total_value`) VALUES (?,?,?)";
		$cond = [$orderID,'Grand Total',$show['total']];
		if (!$this->CB->DB->query($sql,$cond)){
			$this->CB->DB->end(0);
			return false;
		}

		// ALL GREEN - COMMIT
		$this->CB->DB->end(1);
		$this->nuke();
		return true;
	}
}
?>