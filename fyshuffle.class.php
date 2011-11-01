<?php
/**
 *
 * FYShuffle - A Fisher-Yates PHP implementation.
 * 
 * Copyright (C) 2011	Rob van Bentem (http://github.com/robvanbentem/FYShuffle)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.	If not, see <http://www.gnu.org/licenses/>.
 *
 *
 *
 * @date Tuesday, November 01 2011
 * @version 1.0
 **/
class FYShuffle
{
	// Store minimum and maximum range.
	private $min, $max; 

	// Total size ($max-$min) of range.
	private $size;

	// Keep track of the used/unused index posituib
	private $ceiling;

	// The values of our min-max range
	private $values;

	// The user-defined array
	private $user_array = null;

	/**
	 * ctor determines the 'mode' of the shuffle.
	 *
	 * 1. Pass min/max integers to create a range of numbers to pick from.
	 * 2. Pass an array to use your own array to pick from
	 *
	 * @return void
	 **/
	function __construct($min = null, $max = null){
		if(is_numeric($min) && is_numeric($max)){
      if($min >= $max) {
        throw new exception('Max must be greater then min.');
      }
			$this->_init_numeric($min, $max);
		} elseif(is_array($min) && $max === null){
			$this->_init_array($min);
		} else {
			throw new exception('Please provide min/max integers or an array.');
		}

		$this->ceiling = $this->size - 1;
	}

	/**
	 * Initializes the class in 'range' mode.
	 *
	 * @return void
	 **/
	private function _init_numeric($min, $max)
	{
		$this->mode = 'range';

		$this->min = $min;
		$this->max = $max;

		$this->size = $this->max - $this->min + 1;

		// Fill our values array with numbers between min-max.
		for($i = 0 ; $i < $this->size; $i++) {
			$this->values[$i] = $this->min+$i;
		}
	}

	/**
	 * Initializes the class for user-defined array mode.
	 *
	 * @return void
	 **/
	private function _init_array($array)
	{
		$this->mode = 'array';

		$this->user_array = $array;
		$this->size = sizeof($array);

		$this->values = array();

		$this->min = 0;
		$this->max = $this->size-1;

		// Here we will create a lookup array.	
		foreach ($array as $n => $value) {
			$this->values[] = $n;
		}
	}


	/**
	 * Returns a random element from the bag
	 *
	 * @return void
	 **/
	public function fetch()
	{
		if($this->mode === 'range'){
			return $this->_fetch_range();
		} elseif($this->mode === 'array'){
			return $this->_fetch_array();
		}
	}

	/**
	 * Returns a number from the range array
	 *
	 * @return int
	 **/
	private function _fetch_range()
	{
		// Only one element left, return it and reset the bag
		if($this->ceiling === 0){
			$this->ceiling = $this->size-1;
			return reset($this->values);
		}

		// Pick a random index from range [0, $ceiling].
		$index = mt_rand() % $this->ceiling;
		$chosen = $this->values[$index];

		// Swap chosen with the ceiling element
		$this->values[$index] = $this->values[$this->ceiling];
		$this->values[$this->ceiling] = $chosen;

		$this->ceiling--;

		return $chosen;
	}

	/**
	 * Returns a random element from the users provided array
	 *
	 * @return unknown
	 **/
	private function _fetch_array()
	{
		return $this->user_array[$this->_fetch_range()];
	}
} // END class FYShuffle

?>
