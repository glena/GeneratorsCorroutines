<?php

interface IterableCollection extends Iterator {

	public function push($item);
	public function clean(Closure $filter);
	public function count();
	
}