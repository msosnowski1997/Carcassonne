<?php

namespace Games\Carcassonne;

class Core
{
	// Obiekt tilesCollection
	private $tilesCollection; 

	// Obiekt planszy
	private $board;

	// Tablica rozszerzeń dodanych do gry
	private $extensions;

	// Tablica do której wrzucamy odpowiedź dla klienta
	private $answerData;

	// Numer gry
	private $gameID;

	// Tablica z obiektami Player
	private $players;

	// Index aktualnego gracza
	private $currentPlayerIndex;

	// tablica ruchów graczy
	private $movesList;

	// index ostatniego ruchu
	private $lastMoveID;

	public function __construct( $id, array $extensions, array $players = [] )
	{
		// Tymczasowe tworzenie gry
		$this->gameID = $id;

		// Dodawanie rozszerzeń do zapisu
		$this->extensions = $extensions;

		// Dodawanie graczy do gry
		foreach ($players as $player) {
			$this->players[] = new Player( $player['id'], $player['index'], $player['name'], $player['color'] );
			if( empty( $this->currentPlayerIndex ) ) $this->currentPlayerIndex = 0;
		}

		// Tworenie kolekcji płytek
		$this->tilesCollection = new TilesCollection( $extensions );

		// Tworzenie wirtualnej planszy
		$this->board = new Board( $this->tilesCollection );

		// Przekręcanie pierwszej płytki
		$temp = [ 'top', 'right', 'bottom', 'left' ];
		$this->tilesCollection->getCurrentTile()->setDirection( $temp[array_rand( $temp )] );

		// Stawianie pierwszej płytki
		$this->board->setTile( 0, 0, $this->tilesCollection->getCurrentTile() );
		$this->tilesCollection->getCurrentTile( true );
	}

	public function transferRequest( $request )
	{
		// Resetowanie aktualnej odpowiedzi
		$this->answerData = array ();


		switch ( $request['type'] ) {
			case 'move':
				switch ( $request['move']['moveType'] )
				{
					case 'setTile':
						$this->parseMoveSetTile( $request['move']['setTile'] );
						break;
				}
				break;
			case 'load':
				$this->addToAnswer( 'lastMoveID', $this->lastMoveID );
				$this->addToAnswer( 'movesList', $this->getMoveData( $request['load']['expectedMoveID'] ) );
				break;
			case 'build':
				$this->addToAnswer( 'GameInfo', $this->gameID );
				$this->addToAnswer( 'currentTile', $this->tilesCollection->getCurrentTile()->getInfo() );
				$this->addToAnswer( 'extensions', $this->extensions );
				$this->addToAnswer( 'board', $this->board->getInfo() );
				$this->addToAnswer( 'players', $this->getPlayersInfo() );
				
				// $this->addToAnswer( 'players', $this->getPlayersInfo() );
			default:
				// Wysyłanie pełnej informacji o grze
				break;
		}
		// Wysłanie odpowiedzi...
	}

	public function getAnswer()
	{
		return json_encode( $this->answerData );
	}

	private function addToAnswer( $case, $data )
	{
		$this->answerData[$case] = $data;
	}

	private function getPlayersInfo()
	{
		$data['list'] = [];

		foreach ($this->players as $player) {
			$data['list'][] = $player->getInfo();
		}
		$data['currentPlayerIndex'] = $this->currentPlayerIndex;
		return $data;
	}

	private function setCurrentPlayer( $direction = 'next' )
	{
		if( $direction == 'next' )
		{
			( array_key_exists($this->currentPlayerIndex+1, $this->players) ) ? $this->currentPlayerIndex++ : $this->currentPlayerIndex = 0;
		}
		return $this->currentPlayerIndex;
	}

	private function addMoveData( $data )
	{
		$this->movesList[] = $data;
		$this->lastMoveID++;
	}

	private function getMoveData( $expected )
	{
		$data = array ();
		for ( $i = $expected; $i < $this->lastMoveID; $i++ )
		{ 
			$data[] = [ 'index' => $i, 'info' => $this->movesList[$i] ];
		}
		return $data;
	}

	private function parseMoveSetTile( $data )
	{
		$this->tilesCollection->getCurrentTile()->setDirection( $data['direction'] );
		if( $this->board->setTile( $data['pos_x'], $data['pos_y'], $this->tilesCollection->getCurrentTile() ) )
		{
			// Jeśli dodanie płytki się powiodło
			// Dodaj informacje o ruchu dla pobierających
			$data['tile'] = $this->tilesCollection->getCurrentTile();
			$this->addMoveData( [ 'moveType' => 'setTile', 'setTile' => $data ] );
			// wyślij informacje do wysyłającego request gracza
			$this->addToAnswer( 'currentPlayerIndex', $this->setCurrentPlayer() );
			$this->addToAnswer( 'currentTile', $this->tilesCollection->getCurrentTile( true )->getInfo() );
			// Informacje o zdobytych punktach...
		}
		else
		{
			echo 'Przebudowa gry. Coś nie działa w kliencie JS.';
		}
	}
}