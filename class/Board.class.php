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
		$toprow = 0;
		$botrow = 0;
		$leftcol = 0;
		$rightcol = 0;
		$tiles = array ();

		foreach ($this->board as $x => $column) {
			if( intval( $x ) >= $rightcol ) $rightcol = intval( $x );
			if( intval( $x ) <= $leftcol ) $leftcol = intval( $x );

			foreach ($column as $y => $tile) {
				if( intval( $y ) >= $toprow ) $toprow = intval( $y );
				if( intval( $y ) <= $botrow ) $botrow = intval( $y );
				// dostęp do płytki;
				// $this->board[$x][$y];
				$tiles[] = [
					'x' => $x,
					'y' => $y,
					'info' => $tile->TileData()
				];
			}
		}
		$data['toprow'] = ++$toprow;
		$data['botrow'] = --$botrow;
		$data['leftcol'] = --$leftcol;
		$data['rightcol'] = ++$rightcol;
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