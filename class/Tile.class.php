<?php

namespace Games\Carcassonne;

class Tile
{
	// Typ płytki BB6F3 | D | FlugE | ...
	private $type;

	// Rozszerzenie z którego płytka pochodzi
	private $extension;

	// Podstawowy schemat płytki
	private $sides;

	// Orientacja płytki top | right | left | bottom
	private $direction;

	public function __construct( $data )
	{
		$this->type =		$data['type'];
		$this->extension =	$data['extension'];
		$this->sides =		$data['sides'];
		$this->direction =	'top';
	}

	public function setDirection( $direction )
	{
		if( $direction == 'top' || $direction == 'right' || $direction == 'bottom' || $direction == 'left' ) $this->direction = $direction;
	}

	public function getInfo()
	{
		$data['_type'] = $this->type;
		$data['_extension'] = $this->extension;
		$data['_sides'] = $this->sides;
		$data['_pattern'] = $this->sides;
		$data['_direction'] = $this->direction;
		return $data;
	}


	public function getPattern( $side = 'full' )
	{
		$pattern = "";
		$temp = 0;
		switch ( $this->direction ) {
			case 'left':
				$temp = 1;
				break;
			case 'bottom':
				$temp = 2;
				break;
			case 'right':
				$temp = 3;
				break;
		}

		for ( $i = $temp; $i < $temp+4 ; $i++ )	$pattern .= $this->sides[$i % 4];

		switch ( $side ) {
			case 'top':
				return $pattern[0];
				break;
			case 'right':
				return $pattern[1];
				break;
			case 'bottom':
				return $pattern[2];
				break;
			case 'left':
				return $pattern[3];
				break;
			case 'full':
				return $pattern;
				break;
		}
	}
}