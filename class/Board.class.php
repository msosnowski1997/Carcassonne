<?php

class Board
{
	private $board = array ();

	private $tilesCollection;

	public function __construct( TilesCollection $tilesCollection )
	{
		$this->tilesCollection = $tilesCollection;
	}

	public function getBoardInfo()
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
					'info' => $tile->TileData()
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

	public function setTile( $x, $y, $tile)
	{

		// Sprawdzenie czy można ją tam ustawić...
		$check = empty($this->board[strval($x)][strval($y)]);
		// Ustawienie płytki
		if($check)
		{
			$this->board[strval($x)][strval($y)] = clone $tile;
			return true;
		}
		else
		{
			return false;
		}



	}
}