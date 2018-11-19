<?php

class TilesArray
{
	public static $instance;

	public static function instance()
	{
		if(empty(self::$instance))
		{
			self::$instance = new TilesArray;
		}
		return self::$instance;
	} 

	private $tiles;

	public function __construct()
	{
		$this->tiles['classic'][] = array ('f', 'f', 'r', 'f', 'A');
		$this->tiles['classic'][] = array ('f', 'f', 'f', 'f', 'B');
		$this->tiles['classic'][] = array ('c', 'c', 'c', 'c', 'C');
		$this->tiles['classic'][] = array ('c', 'r', 'f', 'r', 'D');
		$this->tiles['classic'][] = array ('c', 'f', 'f', 'f', 'E');
		$this->tiles['classic'][] = array ('f', 'c', 'f', 'c', 'F');
		$this->tiles['classic'][] = array ('f', 'c', 'f', 'c', 'G');
		$this->tiles['classic'][] = array ('c', 'f', 'c', 'f', 'H');
		$this->tiles['classic'][] = array ('c', 'f', 'f', 'c', 'I');
		$this->tiles['classic'][] = array ('c', 'r', 'r', 'f', 'J');
		$this->tiles['classic'][] = array ('c', 'f', 'r', 'r', 'K');
		$this->tiles['classic'][] = array ('c', 'r', 'r', 'r', 'L');
		$this->tiles['classic'][] = array ('c', 'f', 'f', 'c', 'M');
		$this->tiles['classic'][] = array ('c', 'f', 'f', 'c', 'N');
		$this->tiles['classic'][] = array ('c', 'r', 'r', 'c', 'O');
		$this->tiles['classic'][] = array ('c', 'r', 'r', 'c', 'P');
		$this->tiles['classic'][] = array ('c', 'c', 'f', 'c', 'Q');
		$this->tiles['classic'][] = array ('c', 'c', 'f', 'c', 'R');
		$this->tiles['classic'][] = array ('c', 'c', 'r', 'c', 'S');
		$this->tiles['classic'][] = array ('c', 'c', 'r', 'c', 'T');
		$this->tiles['classic'][] = array ('r', 'f', 'r', 'f', 'U');
		$this->tiles['classic'][] = array ('f', 'f', 'r', 'r', 'V');
		$this->tiles['classic'][] = array ('f', 'r', 'r', 'r', 'W');
		$this->tiles['classic'][] = array ('r', 'r', 'r', 'r', 'X');
	}

	public function getTilesData( $extension )
	{
		if(array_key_exists( $extension, $this->tiles))
		{
			Dev::print('Wysłano dane płytek rozszerzenia: "'. $extension .'"');
			return $this->tiles[ $extension ];
		}
		else
		{
			Dev::print('Nie znaleziono danych płytek rozszerzenia: "'. $extension .'"');
			return false;
		}
	}

}