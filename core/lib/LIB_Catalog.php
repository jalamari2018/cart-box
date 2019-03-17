<?php
/*
 * CLASS CATALOG : CATALOG
 * REQUIRES MODULE : DB
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

class Catalog {
	/* [CATEGORY] */
	function catCount($search=null){
	// catCount()() : count categories
	// PARAM $search : search category name
		

		$sql = "SELECT COUNT(*) AS `cnt` FROM `categories`";
		$cond = null;
		if ($search) {
			$sql .= " WHERE `category_name` LIKE ?";
			$cond = ["%$search%"];
		}
		$cnt = $this->CB->DB->select($sql, $cond);
		return is_numeric($cnt[0]['cnt']) ? $cnt[0]['cnt'] : 0 ;
	}

	function getAllCat($search=null,$page=null){
	// getAllCat() : get all categories
	// PARAM $search : search category name
	//       $page : the current page, will limit number of results - for pagination

		$sql = "SELECT * FROM `categories`";
		$cond = null;
		if ($search) {
			$sql .= " WHERE `category_name` LIKE ?";
			$cond = ["%$search%"];
		}
		if (is_numeric($page)) {
			$sql .= $this->CB->slimit($page);
		}
		$cat = $this->CB->DB->select($sql,$cond,"category_id");
		return empty($cat) ? false : $cat ;
	}

	function getCat($id=0){
	// getCat() : get category
	// PARAM $id : category ID

		$cat = $this->CB->DB->select(
			"SELECT * FROM `categories` WHERE `category_id`=?",
			[$id]
		);

		return count($cat)==1 ? $cat[0] : false ;
	}

	function getCatSlug($slug="", $excl=""){
	// getCatSlug() : get category by slug
	// PARAM $slug : category slug
	//       $excl : exclude this category ID, good for checking update category

		$sql = "SELECT * FROM `categories` WHERE `category_slug`=?";
		$cond = [$slug];
		if (is_numeric($excl)) {
			$sql .= " AND `category_id`!=?";
			$cond[] = $excl;
		}

		$cat = $this->CB->DB->select($sql, $cond);
		return count($cat)==1 ? $cat[0] : false ;
	}

	function checkCatSlug($slug="", $excl=""){
	// checkCatSlug() : check if given slug is already registered
	// PARAM $slug : category slug
	//       $excl : exclude this category ID, good for checking update category

		if ($slug=="") { return true; }
		$cat = $this->getCatSlug($slug,$excl);
		return is_array($cat);
	}


	function addCat($cat){
	// addCat() : add new category
	// PARAM $cat : category_slug, category_name, category_description, category_image

		if (!$this->CB->DB->query(
			"INSERT INTO `categories` (`category_slug`, `category_name`, `category_description`, `category_image`) VALUES (?,?,?,?)",
			[$cat['category_slug'], $cat['category_name'], $cat['category_description'], $cat['category_image']]
		)){ return false; }

		return true;
	}

	function editCat($cat){
	// editCat() : update category
	// PARAM $cat : category_id, category_name, category_description, category_image

		if (!$this->CB->DB->query(
			"UPDATE `categories` SET `category_slug`=?, `category_name`=?, `category_description`=?, `category_image`=? WHERE `category_id`=?",
			[$cat['category_slug'], $cat['category_name'], $cat['category_description'], $cat['category_image'], $cat['category_id']]
		)){ return false; }

		return true;
	}

	function delCat($id){
	// delCat() : delete category
	// PARAM $id : category ID

		// REMOVE MAIN ENTRY
		$this->CB->DB->start();
		if (!$this->CB->DB->query(
			"DELETE FROM `categories` WHERE `category_id`=?",
			[$id]
		)){
			$this->CB->DB->end(0);
			return false;
		}

		// REMOVE PRODUCTS TO CATEGORY
		if (!$this->CB->DB->query(
			"DELETE FROM `products_categories` WHERE `category_id`=?",
			[$id]
		)){
			$this->CB->DB->end(0);
			return false;
		}

		$this->CB->DB->end(1);
		return true;
	}

	/* [PRODUCTS] */
	function pdtCount($search=null){
	// pdtCount() : get products count
	// PARAM $search : search product name

		$sql = "SELECT COUNT(*) AS `cnt` FROM `products`";
		$cond = null;
		if ($search) {
			$sql .= " WHERE `product_name` LIKE ?";
			$cond = ["%$search%"];
		}
		$cnt = $this->CB->DB->select($sql, $cond);
		return is_numeric($cnt[0]['cnt']) ? $cnt[0]['cnt'] : 0 ;
	}

	function getAllPdt($search=null, $page=null, $cat=null){
	// getAllPdt() : get all products
	// PARAM $search : product name search
	//       $page : the current page, will limit number of results - for pagination
	//       $cat : optional category id => use to check if products are assigned to that category

		if (is_numeric($cat)) {
			$sql = "SELECT p.*, pc.`category_id` FROM `products` p LEFT JOIN `products_categories` pc ON (p.`product_id`=pc.`product_id` AND pc.`category_id`=?)";
			$cond = [$cat];
		} else {
			$sql = "SELECT * FROM `products`";
			$cond = null;
		}

		if ($search) {
			$sql .= " WHERE `product_name` LIKE ?";
			if ($cond==null) { $cond = ["%$search%"]; }
			else { $cond[] = "%$search%"; }
		}

		if (is_numeric($page)) {
			$sql .= $this->CB->slimit($page);
		}

		$pdt = $this->CB->DB->select($sql,$cond,"product_id");
		return empty($pdt) ? false : $pdt ;
	}

	function getPdtCat($id=0){
	// getPdtCat() : get products in category
	// PARAM $id : category ID

		$pdt = $this->CB->DB->select(
			"SELECT p.* FROM `products_categories` pc LEFT JOIN `products` p USING (`product_id`) WHERE `category_id`=?",
			[$id], "product_id"
		);

		return empty($pdt) ? false : $pdt ;
	}

	function getPdt($id=0){
	// getPdt() : get product
	// PARAM $id : product ID

		$pdt = $this->CB->DB->select(
			"SELECT * FROM `products` WHERE `product_id`=?",
			[$id]
		);

		return empty($pdt) ? false : $pdt[0] ;
	}

	function addPdt($pdt){
	// addPdt() : add new product
	// PARAM $pdt : product_name, product_description, product_image, product_price

		if (!$this->CB->DB->query(
			"INSERT INTO `products` (`product_name`, `product_slug`, `product_description`, `product_image`, `product_price`) VALUES (?,?,?,?,?)",
			[$pdt['product_name'], $pdt['product_slug'], $pdt['product_description'], $pdt['product_image'], $pdt['product_price']]
		)){ return false; }

		return true;
	}

	function editPdt($pdt){
	// editPdt() : update product
	// PARAM $pdt : product_id, product_name, product_description, product_image, product_price

		if (!$this->CB->DB->query(
			"UPDATE `products` SET `product_name`=?, `product_slug`=?, `product_description`=?, `product_image`=?, `product_price`=? WHERE `product_id`=?",
			[$pdt['product_name'], $pdt['product_slug'], $pdt['product_description'], $pdt['product_image'], $pdt['product_price'], $pdt['product_id']]
		)){ return false; }

		return true;
	}

	function delPdt($id){
	// delPdt() : delete product
	// PARAM $id : product ID

		// REMOVE MAIN ENTRY
		$this->CB->DB->start();
		if (!$this->CB->DB->query(
			"DELETE FROM `products` WHERE `product_id`=?",
			[$id]
		)){
			$this->CB->DB->end(0);
			return false;
		}

		// REMOVE PRODUCTS TO CATEGORY
		if (!$this->CB->DB->query(
			"DELETE FROM `products_categories` WHERE `product_id`=?",
			[$id]
		)){
			$this->CB->DB->end(0);
			return false;
		}

		$this->CB->DB->end(1);
		return true;
	}

	/* [PRODUCTS TO CATEGORY] */
	function pdtAddCat($data){
	// pdtAddCat() : add products to categories
	// PARAM $data : assignment data - {PRODUCT ID:[CATEGORY IDS], PRODUCT ID:[CATEGORY IDS]}

		if (!is_array($data)) {
			$this->CB->verbose(0,"CAT","Invalid data input");
			return false;
		}

		// DATA JUGGLE
		$sql = "INSERT IGNORE INTO `products_categories` (`product_id`, `category_id`) VALUES ";
		$cond = [];
		foreach ($data as $pid=>$cat) { foreach ($cat as $cid) {
			$sql .= "(?,?),";
			$cond[] = $pid; $cond[] = $cid;
		}}
		$sql = substr($sql,0,-1).";";

		// QUERY
		if (!$this->CB->DB->query($sql, $cond)){ return false; }
		return true;
	}

	function pdtDelCat($data){
	// pdtDelCat() : remove products to categories
	// PARAM $data : assignment data - {PRODUCT ID:[CATEGORY IDS], PRODUCT ID:[CATEGORY IDS]}

		if (!is_array($data)) {
			$this->CB->verbose(0,"CAT","Invalid data input");
			return false;
		}

		// DATA JUGGLE
		foreach ($data as $pid=>$cat) { 
			$sql = "DELETE FROM `products_categories` WHERE `product_id`=? AND `category_id` IN (";
			$cond = array($pid);
			foreach ($cat as $cid) {
				$sql .= "?,";
				$cond[] = $cid;
			}
			$sql = substr($sql,0,-1).");";
		}

		// QUERY
		if (!$this->CB->DB->query($sql, $cond)){ return false; }
		return true;
	}
}
?>