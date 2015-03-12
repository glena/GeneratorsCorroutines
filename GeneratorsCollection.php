<?php

class GeneratorsCollection implements IterableCollection {
	
	protected $key = 0;
	protected $values = [];
	
	public function __construct($values = null) {
	
		$this->key = 0;
		if ($values) {
			$this->values = $values;
		}
		
	}

	public function current() {
		return $this->values[$this->key];
	}
	
	public function key() {
		return $this->key;
	}
	
	public function next() {
		++$this->key;
	}
	
	public function rewind() {
		$this->key = 0;
	}
	
	public function valid() {
		return isset($this->values[$this->key]);
	}
	
	public function push($item) {
		array_push($this->values, $item);
	}
	
	public function clean(Closure $filter) {
		$this->values = array_values(array_filter($this->values, $filter));
		$this->rewind();
	}
	
	public function count() {
		return count($this->values);
	}
	
}