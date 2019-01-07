<?php

namespace Games\Carcassonne;

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
		// Płytki z podstawowej wersji
		$this->addTile( 'classic', 4, 'crfr', 'D' );
		$this->addTile( 'classic', 2, 'ffrf', 'A' );
		$this->addTile( 'classic', 4, 'ffff', 'B' );
		$this->addTile( 'classic', 1, 'cccc', 'C' );
		$this->addTile( 'classic', 5, 'cfff', 'E' );
		$this->addTile( 'classic', 2, 'fcfc', 'F' );
		$this->addTile( 'classic', 1, 'fcfc', 'G' );
		$this->addTile( 'classic', 3, 'cfcf', 'H' );
		$this->addTile( 'classic', 2, 'cffc', 'I' );
		$this->addTile( 'classic', 3, 'crrf', 'J' );
		$this->addTile( 'classic', 3, 'cfrr', 'K' );
		$this->addTile( 'classic', 3, 'crrr', 'L' );
		$this->addTile( 'classic', 2, 'ccff', 'M' );
		$this->addTile( 'classic', 3, 'ccff', 'N' );
		$this->addTile( 'classic', 2, 'crrc', 'O' );
		$this->addTile( 'classic', 3, 'crrc', 'P' );
		$this->addTile( 'classic', 1, 'ccfc', 'Q' );
		$this->addTile( 'classic', 3, 'ccfc', 'R' );
		$this->addTile( 'classic', 2, 'ccrc', 'S' );
		$this->addTile( 'classic', 1, 'ccrc', 'T' );
		$this->addTile( 'classic', 8, 'rfrf', 'U' );
		$this->addTile( 'classic', 9, 'ffrr', 'V' );
		$this->addTile( 'classic', 4, 'frrr', 'W' );
		$this->addTile( 'classic', 1, 'rrrr', 'X' );
	}

	public function getTilesData( $extension )
	{
		if(array_key_exists( $extension, $this->tiles))
		{
			return $this->tiles[ $extension ];
		}
		else
		{
			return array ();
		}
	}

	private function addTile( $extension, $amount, $sides, $type )
	{
		$this->tiles[$extension][] = [
			'amount' => $amount,
			'info' => [
				'sides' => $sides,
				'extension' => $extension,
				'type' => $type
			]
		];
	}

}