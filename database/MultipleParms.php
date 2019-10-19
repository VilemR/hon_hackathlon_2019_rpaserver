<?php
class MultipleParms {
	private $args = null;
	public function __construct(...$args) {
		$this->args = $args;
		if (count ( $args ) < 1) {
			throw new Exception ( "Incorrect input to procees with prepred statement" );
		}
	}
	public function getNumberOfArguments() {
		return count ( $this->args );
	}
	public function getSql() {
		return $this->args [0];
	}
	public function getDataType($arg) {
		return gettype ( $arg );
	}
	public function getDataTypeShort($arg) {
		if (is_string ( $arg )) {
			return "s";
		} else {
			switch ($this->getDataType ( $arg )) {
				case 'blob' :
					return "b";
				case 'integer' :
					return "i";
				case 'string' :
					return "s";
				case 'double' :
					return "d";
				default :
					return "s";
			}
		}
	}
	public function getStmDataTypeString() {
		$s = "";
		for($i = 1; $i < count ( $this->args ); $i ++) {
			$s = $s . $this->getDataTypeShort ( $this->args [$i] );
		}
		return $s;
	}
}