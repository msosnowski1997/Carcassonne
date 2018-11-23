<?php

class TilesCollection
{
	
	private $tiles = array ();
	
	private $usedTiles = array ();

	private $actualTile;

	public function __construct()
	{
		
	}

	public function addTiles( array $extensions )
	{
		foreach ($extensions as $extension) 
		{
			if($tilesData = TilesArray::instance()->getTilesData( $extension ))
			{
				foreach ($tilesData as $tile) 
				{
					$tile['extension'] = $extension;
					$this->tiles[] = new Tile($tile);
				}
				Dev::printIt( 'Wczytano dodatek: "'. $extension .'"' );
			}
		}
	}

	// Pobieranie losowej dostępnej płytki
	public function getRandomTile()
	{
		// Generowanie klucza dostępnej płytki
		$random_key = array_rand($this->tiles);

		// Kopiowanie obiektu płytki do tablicy zużytch i przypisanie jej do tymczasowej zmiennej
		$return = $this->actualTile = clone $this->tiles[ $random_key ];

		// Usuwanie płytki kolekcji dostępnych
		unset( $this->tiles[ $random_key ] );

		Dev::printIt('Pozostało: '. count($this->tiles) .' płytek');

		// Wysłanie płytki
		return $return;
	}

	public function getActualTile()
	{
		return $this->actualTile;
	}
}