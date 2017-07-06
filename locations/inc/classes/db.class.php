<?php

/**
* Database management class
* @author Rodney Ncane
*/

if(!class_exists('Database')) {
	
	class Database extends PDO {
		
	    private $host      = DB_HOST;
	    private $user      = DB_USER;
	    private $pass      = DB_PASS;
	    private $dbname    = DB_NAME;
	 
	    public $dbh;
	    private $error;
		
		private $stmt;
	 
	    public function __construct(){
	        // Set DSN
	        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

	        // Set options
	        $options = array(
	            PDO::ATTR_PERSISTENT    => true,
	            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
	        );

	        // Create a new PDO instanace
	        try{
	            $this->dbh = @new PDO($dsn, $this->user, $this->pass, $options);
	        }	        
	        catch(PDOException $e){
	        	// Catch any errors
	            $this->error = $e->getMessage();
	        }
	    }

	    public function setDBHost($dbh) {
	    	$this->dbh = $dbh;
	    }
		
		
		// Prepare
		public function query($query){
			$this->stmt = $this->dbh->prepare($query);
		}
		
		// Bind
		public function bind($param, $value, $type = null){
			if (is_null($type)) {
				switch (true) {
					case is_int($value):
						$type = PDO::PARAM_INT;
						break;
					case is_bool($value):
						$type = PDO::PARAM_BOOL;
						break;
					case is_null($value):
						$type = PDO::PARAM_NULL;
						break;
					default:
						$type = PDO::PARAM_STR;
				}
			}
			$this->stmt->bindValue($param, $value, $type);
		}
		
		// Execute
		public function execute(){
			return $this->stmt->execute();
		}
		
		// Result Set	
		public function resultset(){
			$this->execute();
			return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		// Single
		public function single(){
			$this->execute();
			return $this->stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		// Row Count
		public function rowCount(){
			return $this->stmt->rowCount();
		}
		
		// Last Insert Id
		public function lastInsertedId(){
			return $this->dbh->lastInsertId();
		}		
		
		// Transactions
		public function beginTransaction(){
			return $this->dbh->beginTransaction();
		}
		
		public function endTransaction(){
			return $this->dbh->commit();
		}
		
		public function cancelTransaction(){
			return $this->dbh->rollBack();
		}		
		
		// Debug Dump Parameters
		public function debugDumpParams(){
			return $this->stmt->debugDumpParams();
		}

		public function select($select) {
			return "SELECT $select";
		}

		public function from($from) {
			return " FROM $from";
		}

		public function join($join, $type = "INNER") {
			return " $type JOIN $join";
		}

		public function where($where) {
			return " WHERE $where";
		}

		public function group($group) {
			return " GROUP BY $group";
		}

		public function having($having) {
			return " HAVING $having";
		}

		public function order($order) {
			return " ORDER BY $order";
		}

		public function limit($start, $limit) {
			return " LIMIT $start, $limit";
		}

		public function insert($table, $values) {
			return "INSERT INTO $table VALUES($values)";
		}

		public function multiple_insert($table, $query) {
			return "INSERT INTO $table VALUES $query";
		}

		public function update($table, $data, $condition) {
			return "UPDATE $table SET $data WHERE $condition";
		}

		public function delete($table, $condition) {
			return "DELETE FROM $table WHERE $condition";
		}
		
	}
}

?>