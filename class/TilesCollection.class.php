<?php

namespace Games\Carcassonne;

class TilesCollection
{
	// Przechowuje nieużywane płytki
	private $tiles = array ();

	// Przechowuje aktualną płytkę
	private $currentTile;
	
	
	public function __construct( array $extensions )
	{
		foreach ($extensions as $extension )
		{
			// Pobranie danych o płytkach...
			$tilesBasicData = TilesArray::instance()->getTilesData( $extension );

			foreach ($tilesBasicData as $tileBasicData)
			{
				$this->tiles[$extension][] = new Tile( $tileBasicData['info'] );

				if( $extension == 'classic' && empty($this->currentTile) )
				{
					$this->currentTile = $this->tiles['classic'][0];
				}

				

				for ( $i=1; $i < $tileBasicData['amount']; $i++ )
				{ 
					$this->tiles[$extension][] = new Tile( $tileBasicData['info'] );
				}
			}
		}
	}

	public function getCurrentTile( $unset = false )
	{
		if($unset) $this->setNextTile();
		return $this->currentTile;
	}

	private function setNextTile()
	{
		if( array_key_exists( 'river', $this->tiles ) )
		{
			$extension = 'river';
			$key = array_rand( $this->tiles['river'] );
		}
		else
		{
			$extension = array_rand( $this->tiles );
			$key = array_rand( $this->tiles[$extension] );
		}
		$this->currentTile = clone $this->tiles[$extension][$key];
		unset( $this->tiles[$extension][$key] );
		if( ! count( $this->tiles[$extension] ) ) unset( $this->tiles[$extension] );
	}


}