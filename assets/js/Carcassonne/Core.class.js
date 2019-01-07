class Core
{
	setActivePlayer( index )
	{
		this._currentPlayer = this._players[ index ];
		$( '.game-player' ).removeClass('player-is-active');
		$( '.game-player[player-index=' + index + ']' ).addClass('player-is-active');
	}

	/*------------------------------------------------------------------------------*/
	/*------------------------------Metody Zarządzające-----------------------------*/
	/*------------------------------------------------------------------------------*/

	init( data )
	{
		Core._moveID = data.lastMoveID;

		Core.setCurrentTile( data.currentTile );

		this._board = new Board( data.board );

		this._players = [];

		for( const player of data.players.list )
		{
			console.log(player);
			this._players.push( new Player( player ) );
		}

		this.setActivePlayer( data.players.currentPlayerIndex );

		this._board.findAvaliableFieldsForTile( Core.currentTile );
	}

	// responseHandler( data )
	// {
	// 	switch(  )
	// 	{
			
	// 	}
	// }

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