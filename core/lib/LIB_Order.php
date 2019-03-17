<?php
/*
 * CLASS ORDER : ORDERS
 * REQUIRES MODULE : DB
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

class Order {
	function count(){
	// count() : count number of orders

		$sql = "SELECT COUNT(*) AS `cnt` FROM `orders`";
		$cond = null;
		$cnt = $this->CB->DB->select($sql, $cond);
		return is_numeric($cnt[0]['cnt']) ? $cnt[0]['cnt'] : 0 ;
	}

	function getAll($page=null){
	// getAll() : get all orders
	// PARAM $page : the current page, will limit number of results - for pagination

		$sql = "SELECT * FROM `orders`";
		if (is_numeric($page)) {
			$sql .= $this->CB->slimit($page);
		}
		$orders = $this->CB->DB->select($sql,null,"order_id");
		return empty($orders) ? false : $orders ;
	}

	function getID($id=""){
	// getID() : get order by ID
	// PARAM $id : order ID

		// MAIN
		$orders = $this->CB->DB->select(
			"SELECT * FROM `orders` WHERE `order_id`=?",
			[$id]
		);
		$order = count($orders)==1 ? $orders[0] : false ;
		if ($order==false) { return false; }

		// ITEMS
		$order['items'] = $this->CB->DB->select(
			"SELECT * FROM `orders_products` WHERE `order_id`=?",
			[$id], "product_id"
		);

		// TOTALS
		$order['totals'] = $this->CB->DB->select(
			"SELECT * FROM `orders_totals` WHERE `order_id`=?",
			[$id]
		);
		return $order;
	}

	function update($id="", $stat=""){
	// update() : update order status
	// PARAM $id : order ID
	//       $stat : status ID

		if (!$this->CB->DB->query(
			"UPDATE `orders` SET `order_status`=? WHERE `order_id`=?",
			[$stat, $id]
		)){ return false; }

		return true;
	}
}
?>