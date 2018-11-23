<?php

class Core
{
	public $tilesCollection;

	public $board;

	private $extensions;

	private $answerData;

	private $gameID;

	private $players;

	private $currentPlayerIndex;

	public function __construct( array $extensions , array $players = array ())
	{
		$this->gameID = rand(0, 1000);

		// Dodawanie rozszerzeń do zapisu
		$this->extensions = $extensions;

		// Dodawanie graczy do gry
		$this->players[] = new Player( 1, 'Player 1' );
		$this->currentPlayerIndex = 0;
		$this->players[] = new Player( 2, 'Player 2' );

		// Tworenie kolekcji płytek
		$this->tilesCollection = new TilesCollection;

		// Tworzenie wirtualnej planszy
		$this->board = new Board( $this->tilesCollection );

		// Dodawanie płytek z wybranych rozszerzeń
		$this->tilesCollection->addTiles( $extensions );

		// Stawianie pierwszej płytki
		$this->board->setTile( 0, 0, $this->tilesCollection->getRandomTile() );
		// Pobieranie następnej płytki
		$this->tilesCollection->getRandomTile();

	}

	public function parseRequest( $request )
	{
		switch ($request['action']) {
			case 'getFullGameData':
			// Wysyłka danych do inicjacji...
				$this->getFullGameData();
				break;
			
			case 'moveInfo':
				// Wszystko co związanie z jedną kolejką gracza...
				$this->tilesCollection->getActualTile()->setOrientation( $request['moveInfo']['orientation'] );
				if( $this->board->setTile( $request['moveInfo']['tileX'], $request['moveInfo']['tileY'], $this->tilesCollection->getActualTile() ) )
				{
					$this->addToAnswer( 'currentTile', $this->tilesCollection->getRandomTile()->TileData() );
					$this->ChangeCurrentPlayer();
					$this->addToAnswer( 'currentPlayer', $this->getCurrentPlayerInfo() );
				}

				break;
			default:
				// Reload JS action
				break;
		}
	}

	public function getFullGameData()
	{
		$this->addToAnswer( 'GameInfo', [ 'id' => $this->gameID ] );
		$this->addToAnswer( 'currentTile', $this->tilesCollection->getActualTile()->TileData() );
		$this->addToAnswer( 'extensions', $this->extensions );
		$this->addToAnswer( 'board', $this->board->getBoardInfo() );
		$this->addToAnswer( 'players', $this->getPlayersInfo() );
	}

	public function addToAnswer( $bucket, array $data )
	{
		$this->answerData[$bucket] = $data;
	}

	public function sendAnswer( $format = 'json' )
	{
		if( $format == 'json' )
		{
		echo json_encode( $this->answerData );
		}
		else
		{
			print_r($this->answerData);
		}
	}


	// Funkcje do przeniesienia

	private function ChangeCurrentPlayer()
	{
		if( ( $this->currentPlayerIndex + 1 ) == count( $this->players ) ) 
			$this->currentPlayerIndex = 0;
		else
			$this->currentPlayerIndex++;

		return $this->currentPlayerIndex;
	}

	private function getPlayersInfo()
	{
		$data['currentPlayer'] = $this->getCurrentPlayerInfo();
		
		foreach ($this->players as $index => $player) {
			$data['list'][ $index ] = $player->getPlayerInfo(); 
			$data['list'][ $index ]['index'] = $index;
		}
		return $data;
	}

	private function getCurrentPlayerInfo()
	{
		$data = $this->players[$this->currentPlayerIndex]->getPlayerInfo();
		$data['index'] = $this->currentPlayerIndex;
		return $data;
	}










	public function __wakeup()
	{
		$this->answerData = array ();
		Dev::printIt('Wczytano zapis gry');
	}

}