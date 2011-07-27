<?php
/**
 *
 * FYShuffle - A Fisher-Yates PHP implementation.
 * 
 * Copyright (C) 2011  Rob van Bentem (http://github.com/robvanbentem/FYShuffle)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * Fisher-Yates shuffle implementation
 **/
class FYShuffle
{
  // Used to store minimum and maximum range.
  private $min, $max; 

  // Total size ($max-$min) of range.
  private $size;

  // Cursor is the ceiling of the 'left-over' values.
  private $ceiling;

  // The values of our min-max range
  private $values;

  // The user-defined array
  private $user_array = null;

  /**
   * Ctor determines the 'mode' of the shuffle.
   *
   * 1. Pass min/max integers to create a range of numbers to pick from.
   * 2. Pass an array to use your own array to pick from
   *
   * @return void
   * @author Rob van Bentem <robvanbentem@gmail.com>
   **/
  function __construct($min = null, $max = null){
    if(is_numeric($min) && is_numeric($max)){
      $this->_init_numeric($min, $max);
    } elseif(is_array($min) && $max === null){
      $this->_init_array($min);
    }

    $this->ceiling = $this->size - 1;
  }

  /**
   * Initializes the class in 'range' mode.
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
   **/
  private function _init_array($array)
  {
    $this->mode = 'array';

    $this->user_array = $array;
    $this->size = sizeof($array);

    $this->values = array();
    
    // Here we will create a lookup array.  
    foreach ($array as $n => $value) {
      $this->values[] = $n;
    }
  }

} // END class FYShuffle

?>
