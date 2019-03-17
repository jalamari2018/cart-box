<?php
/*
 * CLASS DB : PDO DATABASE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

class DB {
	private $pdo = null;
	private $stmt = null;
	public $lastID = null;	// last insert ID

	function __destruct(){
	// __destruct() : close connection when done

		if ($this->stmt!==null) { $this->stmt = null; }
		if ($this->pdo!==null) { $this->pdo = null; }
	}

	function connect(){
	// connect() : connect to the database
	// PARAM : DB_HOST, DB_CHARSET, DB_NAME, DB_USER, DB_PASSWORD

		try {
			$this->pdo = new PDO(
				"mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, 
				DB_USER, DB_PASSWORD, [
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false,
				]
			);
			return true;
		} catch (Exception $ex) {
			$this->CB->verbose(0,"DB",$ex->getMessage(),"",1);
		}
	}

	function start(){
	// start() : auto-commit off

		$this->pdo->beginTransaction();
	}

	function end($commit=1){
	// end() : commit or roll back?

		if ($commit) { $this->pdo->commit(); }
		else { $this->pdo->rollBack(); }
	}

	function select($sql, $cond=null, $key=null, $value=null){
	// select() : perform select query
	// WARNING : DO SANITIZE YOUR CONDITIONS BEFORE PASSING IT IN!
	// PARAM $sql : SQL query
	//       $cond : array of conditions
	//       $key : sort in this $key=>data order, optional
	//       $value : $key must be provided, sort in $key=>$value order

		$result = false;
		try {
			$this->stmt = $this->pdo->prepare($sql);
			$this->stmt->execute($cond);
			if (isset($key)) {
				$result = array();
				if (isset($value)) {
					while ($row = $this->stmt->fetch(PDO::FETCH_NAMED)) {
						$result[$row[$key]] = $row[$value];
					}
				} else {
					while ($row = $this->stmt->fetch(PDO::FETCH_NAMED)) {
						$result[$row[$key]] = $row;
					}
				}
			} else {
				$result = $this->stmt->fetchAll();
			}
		} catch (Exception $ex) {
			$this->CB->verbose(0,"DB", $ex->getMessage());
			return false;
		}

		$this->stmt = null;
		return $result;
	}

	function query($sql, $data=null){
	// query() : perform query - insert/update/delete
	// WARNING : DO SANITIZE YOUR DATA BEFORE PASSING IT IN!
	// PARAM $sql : SQL query
	//       $data : array of data

		try {
			$this->stmt = $this->pdo->prepare($sql);
			$this->stmt->execute($data);
			$this->lastID = $this->pdo->lastInsertId();
		} catch (Exception $ex) {
			$this->CB->verbose(0,"DB", $ex->getMessage());
			return false;
		}
		$this->stmt = null;
		return true;
	}
}
?>