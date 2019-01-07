<?php

namespace Games\Carcassonne;

class Board
{
	// Informacje o płytkach na planszy
	private $board;

	public function getInfo()
	{
		$ymax = 0;
		$ymin = 0;
		$xmin = 0;
		$xmax = 0;
		$tiles = array ();

		foreach ($this->board as $x => $column) {
			if( intval( $x ) >= $xmax ) $xmax = intval( $x );
			if( intval( $x ) <= $xmin ) $xmin = intval( $x );

			foreach ($column as $y => $tile) {
				if( intval( $y ) >= $ymax ) $ymax = intval( $y );
				if( intval( $y ) <= $ymin ) $ymin = intval( $y );
				// dostęp do płytki;
				// $this->board[$x][$y];
				$tiles[] = [
					'x' => $x,
					'y' => $y,
					'info' => $tile->getInfo()
				];
			}
		}
		$data['ymax'] = ++$ymax;
		$data['ymin'] = --$ymin;
		$data['xmin'] = --$xmin;
		$data['xmax'] = ++$xmax;
		$data['tiles'] = $tiles;
		return $data;
	}

	public function getTile( $x, $y )
	{
		return ( ! empty( $this->board[strval($x)][strval($y)] ) ) ? $this->board[strval($x)][strval($y)] : false;
	}

	public function setTile( $x, $y, $tile )
	{
		if( $this->isGood( $x, $y, $tile ) )
		{
			$this->board[strval($x)][strval($y)] = clone $tile;
			return true;
		}
		return false;
	}

	private function isGood( $x, $y, $tile )
	{
		// Czy pole jest puste?
		if( ! empty( $this->board[$x][$y] ) ) return false;

		// Czy płytka pasuje do wzoru?

		$fieldPattern  = ( $temp = $this->getTile( $x, $y+1 ) ) ? $temp->getPattern( 'bottom' ) : 'u'; 
		$fieldPattern .= ( $temp = $this->getTile( $x+1, $y ) ) ? $temp->getPattern( 'left'	  ) : 'u'; 
		$fieldPattern .= ( $temp = $this->getTile( $x, $y-1 ) ) ? $temp->getPattern( 'top'    ) : 'u'; 
		$fieldPattern .= ( $temp = $this->getTile( $x-1, $y ) ) ? $temp->getPattern( 'right'  ) : 'u';
		$tilePattern = $tile->getPattern( 'full' );

		for ($i=0; $i < 4; $i++)
		{ 
			if( $fieldPattern[$i] == 'u' || $fieldPattern[$i] == $tilePattern[$i] ) continue;
			return false; 	
		} 

		return true;
	}

}