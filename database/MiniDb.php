<?php
class MiniDb {
	private $con = null;
	public function connect($dbSettings = null) {
		if ($this->con == null) {
			if ($dbSettings == null) {
				$dbSettings = parse_ini_file ( "dbsettings.ini" );
			}
			$this->con = new mysqli ( $dbSettings ['DB_HOST'], $dbSettings ['DB_USERNAME'], $dbSettings ['DB_PASSWORD'], $dbSettings ['DB_DATABASE'] ); // mysql_connect() with variables defined at the start of Database class
			if (! $this->con->connect_errno) {
				$this->con->set_charset ( "utf8" );
				$this->con->query ( "SET character_set_results=utf8" );
				$this->con->query ( "SET names=utf8" );
				$this->con->query ( "SET character_set_client=utf8" );
				$this->con->query ( "SET character_set_connection=utf8" );
				$this->con->query ( "SET character_set_results=utf8" );
				$this->con->query ( "SET collation_connection=utf8_general_ci" );
				return $this->con;
			} else {
				throw new Exception ( "Database not available." );
			}
		} else {
			return $this->con;
		}
	}
	public function executeSql($sql) {
		try {
			$query = $this->con->query ( $sql );
			return $this->con->affected_rows;
		} catch ( Exception $e ) {
			throw $e;
		}
	}
	public function executePSgeneric(...$parms) {
		$ma = new MultipleParms ( ...$parms );
		$stmt = $this->con->prepare ( $ma->getSql () );
		if (count ( $parms ) > 1) {
			$stmt->bind_param ( $ma->getStmDataTypeString (), ...array_slice ( $parms, 1, count ( $parms ) - 1 ) );
		}
		$stmt->execute ();
		return $stmt;
	}
	public function executePSar(...$parms) {
		return $this->executePSgeneric ( ...$parms )->affected_rows;
	}
	public function executePSid(...$parms) {
		return $this->executePSgeneric ( ...$parms )->insert_id;
	}
	public function getValuePS(...$parms) {
		$ma = new MultipleParms ( ...$parms );
		$stmt = $this->con->prepare ( $ma->getSql () );
		if (count ( $parms ) > 1) {
			$stmt->bind_param ( $ma->getStmDataTypeString (), ...array_slice ( $parms, 1, count ( $parms ) - 1 ) );
		}
		$stmt->execute ();
		if ($stmt->errno) {
			throw new Exception ( "Query error..." );
		}
		$result = $stmt->get_result ();
		if ($result->num_rows > 1) {
			throw new Exception ( "Query error - more results than expected..." );
		} elseif ($result->num_rows == 1) {
			return $result->fetch_row () [0];
		} else {
			return null;
		}
	}
	public function getArrayPS(...$parms) {
		$ma = new MultipleParms ( ...$parms );
		$stmt = $this->con->prepare ( $ma->getSql () );
		if (count ( $parms ) > 1) {
			$stmt->bind_param ( $ma->getStmDataTypeString (), ...array_slice ( $parms, 1, count ( $parms ) - 1 ) );
		}
		$stmt->execute ();
		if ($stmt->errno) {
			throw new Exception ( "Query error..." );
		}
		$result = $stmt->get_result ();
		if ($result->num_rows > 0) {
			return $result->fetch_all ();
		} else {
			return null;
		}
	}
}