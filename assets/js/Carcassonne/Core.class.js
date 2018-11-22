class Core
{
	setActivePlayer( player )
	{
		this._currentPlayer = this._players[ player.index ];
		$( '.game-player' ).removeClass('player-is-active');
		$( '.game-player[player-index=' + player.index + '][player-id=' + player.id + ']' ).addClass('player-is-active');
	}

	/*------------------------------------------------------------------------------*/
	/*------------------------------Metody Zarządzające-----------------------------*/
	/*------------------------------------------------------------------------------*/

	init( data )
	{
		Core.setCurrentTile( data.currentTile );

		this._board = new Board( data.board );

		this._players = {};

		for( const player of data.players.list )
		{
			this._players[ player.index ] = new Player( player );
		}

		this.setActivePlayer( this._players[ data.players.currentPlayer.index ] );

		this._board.findAvaliableFieldsForTile( Core.currentTile );
	}

	responseHandler()
	{

	}

	addToRequest()
	{

	}

	//----------------//
	// Static methods //
	//----------------//

	static setCurrentTile( tileData, gameID = null )
	{
		let tile = Core.currentTile = new Tile( tileData );
		$( '.current-tile' ).html( tile.getHTML() );
	}

	static getCurrentTile()
	{
		return Core.currentTile;
	}

	static setCurrentField( x, y )
	{
		Core.currentField = {};
		Core.currentField['x'] = x;
		Core.currentField['y'] = y;
		Core.currentField['Field'] = Field.get( x, y );
		return Core.currentField['Field'];
	}

	static getCurrentField( pos = null )
	{
		if( pos === null )
		{
			if(typeof Core.currentField == 'undefined' ) Core.currentField = {};
			return Core.currentField['Field'];
		}
		else
		{
			if(pos == "x") return Core.currentField['x'];
			if(pos == "y") return Core.currentField['y'];
		}
	}

	static clearCurrentField()
	{
		delete Core.currentField;
	}
}