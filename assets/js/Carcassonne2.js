class Tile
{
	constructor( data )
	{
		this.schema		= data.schema;
		this.sides		= data.sides
		this.skin		= data.skin;
		this.extension	= data.extension;
		this.orienatation = data.orienatation; 
	}

	rotate( side )
	{
		this.hook.removeClass('tile-rotated-top').removeClass('tile-rotated-right').removeClass('tile-rotated-bottom').removeClass('tile-rotated-left');
		switch( side ) {
		    case 'top':
		    	this.schema = this.sides;
		    	this.orienatation = side;
		        this.hook.addClass('tile-rotated-top')
		        break;
		    case 'right':
		    	this.schema = this.sides[3] + this.sides[0] + this.sides[1] + this.sides[2];
		    	this.orienatation = side;
		        this.hook.addClass('tile-rotated-right')
		        break;
		    case 'bottom':
		    	this.schema = this.sides[2] + this.sides[3] + this.sides[0] + this.sides[1];
		    	this.orienatation = side;
		        this.hook.addClass('tile-rotated-bottom')
		        break;
		    case 'left':
		    	this.schema = this.sides[1] + this.sides[2] + this.sides[3] + this.sides[0];
		    	this.orienatation = side;
		        this.hook.addClass('tile-rotated-left')
		        break;
		}
	}

	getHTML()
	{
		return '<img src="assets/img/tiles/' + this.extension + '/' + this.skin + '.jpg" width="98px" height="98px">';
	}

}


class Board
{
	/* 
	 * int ymin, ymax, xmin, xmax;
	 * 
	 * object field[x][y] = { 'tile' : Tile, 'fieldHook' = jquery.hook, 'status' : string, 'sides' : string }
	 * 
	*/ 
	constructor( data )
	{
		this.xmax = data.xmax;
		this.xmin = data.xmin;
		this.ymax = data.ymax;
		this.ymin = data.ymin;
		this.field = {};
		this.buildBoard();

		for( const tile of data.tiles )
		{
			let tileob = new Tile( tile.info );
			this.pickTileToBoard( tile.x, tile.y, tileob );
		}
	}

	buildBoard( x = null, y = null )  // Zrobione, do przerobienia
	{
		if( x != null && y != null)
		{
			if( this.ymin < y && y < this.ymax && this.xmin < x && x < this.xmax ) return;
			if(x == this.xmax) this.xmax++;
			if(x == this.xmin) this.xmin--;
			if(y == this.ymax) this.ymax++;
			if(y == this.ymin) this.ymin--;
		}
		const boardHook = $( '.game-board' );
		const rowHTML = function( y ) { return '<div class="game-row" position-y=' + y + '></div>'; }
		const rowHook = function( y ) { return $('.game-row[position-y=' + y + ']'); }
		const fieldHTML = function( x, y ) { return '<div class="game-field" position-x=' + x + ' position-y=' + y + '></div>'; }
		const fieldHook = function( x, y ) { return $( '.game-field[position-x=' + x + '][position-y=' + y + ']' ); }
		const exist = function ( hook ) { return hook.length; }

		for (let y = 1 ; y <= this.ymax ; y++ )
		{

			if( !exist( rowHook( y ) ) ) boardHook.prepend( rowHTML( y ) );

			let row = rowHook( y );

			for ( let x = 1 ; x <= this.xmax ; x++ ) 
			{
				let field = fieldHook( x, y );

				if( !exist( field ) )
				{
					row.append( fieldHTML( x, y ) ); 
					let xstr = x.toString();
					let ystr = y.toString();

					if( typeof this.field[ xstr ] == 'undefined' ) this.field[ xstr ] = {};

					this.field[ xstr ][ ystr ] = {};
					this.field[ xstr ][ ystr ]['fieldHook'] = fieldHook( x, y );
					this.field[ xstr ][ ystr ]['schema'] = 'uuuu';
					this.field[x][y].nextToTile = false;
				}
			}
			for ( let x = 0 ; x >= this.xmin ; x-- ) 
			{

				let field = fieldHook( x, y );

				if( !exist( field ) )
				{
					row.prepend( fieldHTML( x, y ) ); 
					let xstr = x.toString();
					let ystr = y.toString();

					if( typeof this.field[ xstr ] == 'undefined' ) this.field[ xstr ] = {};

					this.field[ xstr ][ ystr ] = {};
					this.field[ xstr ][ ystr ]['fieldHook'] = fieldHook( x, y );
					this.field[ xstr ][ ystr ]['schema'] = 'uuuu';
					this.field[x][y].nextToTile = false;
				}
			}
		}

		for (let y = 0; y >= this.ymin ; y-- )
		{
			if( !exist( rowHook( y ) ) ) boardHook.append( rowHTML( y ) );

			let row = rowHook( y );

			for ( let x = 1 ; x <= this.xmax ; x++ ) 
			{

				let field = fieldHook( x, y );

				if( !exist( field ) )
				{
					row.append( fieldHTML( x, y ) ); 
					let xstr = x.toString();
					let ystr = y.toString();

					if( typeof this.field[ xstr ] == 'undefined' ) this.field[ xstr ] = {};

					this.field[ xstr ][ ystr ] = {};
					this.field[ xstr ][ ystr ]['fieldHook'] = fieldHook( x, y );
					this.field[ xstr ][ ystr ]['schema'] = 'uuuu';
					this.field[x][y].nextToTile = false;
				}
			}

			for ( let x = 0 ; x >= this.xmin ; x-- ) 
			{

				let field = fieldHook( x, y );

				if( !exist( field ) )
				{
					row.prepend( fieldHTML( x, y ) ); 
					let xstr = x.toString();
					let ystr = y.toString();

					if( typeof this.field[ xstr ] == 'undefined' ) this.field[ xstr ] = {};

					this.field[ xstr ][ ystr ] = {};
					this.field[ xstr ][ ystr ]['fieldHook'] = fieldHook( x, y );
					this.field[ xstr ][ ystr ]['schema'] = 'uuuu';
					this.field[x][y].nextToTile = false;
				}
			}
		}
	}

	findAvaliableFieldsForTile( tile )
	{
		const CheckSchema = function( field, tile )
		{
			for (var i = 0; i < 4; i++) {
				if( field[i] == 'u' || field[i] == tile[i] ) continue;
				return false;
			}
			return true;
		}


		$( '.tile-possible-to-play' ).removeClass( 'tile-possible-to-play' );
		for( let y = this.ymax ; y >= this.ymin ; y-- )
		{
			for( let x = this.xmin ; x <= this.xmax ; x++ )
			{
				if( this.field[x][y].status == 'used' ) continue;
				if( ! this.field[x][y].nextToTile ) continue;
				if( ! CheckSchema( this.field[x][y].schema, tile.schema ) ) continue;
				this.field[x][y].fieldHook.addClass('tile-possible-to-play');
			}
		}
	}

	showTileOnBoard()
	{

	}

	pickTileToBoard( x, y, tile )
	{
		const updateSchema = function( side, field, tile )
		{
			switch( side )
			{
				case 'top':
					return field[0] + field[1] + tile[0] + field[3];
					break;
				case 'right':
					return field[0] + field[1] + field[2] + tile[1];
					break;
				case 'bottom':
					return tile[2] + field[1] + field[2] + field[3];
					break;
				case 'left':
					return field[0] + tile[3] + field[2] + field[3];
					break;
			}
		}

		this.field[ x ][ y ]['tile'] = new Tile( tile );
		this.field[ x ][ y ]['fieldHook'].html( this.field[ x ][ y ]['tile'].getHTML() );
		this.field[ x ][ y ]['tile'].hook = this.field[ x ][ y ]['fieldHook'].children( 'img' );
		this.field[ x ][ y ]['tile'].rotate( this.field[ x ][ y ]['tile'].orienatation );
		this.field[ x ][ y ]['status'] = 'used';

		this.buildBoard( x, y );

		this.field[x][y].schema = this.field[x][y].tile.schema;

		this.field[x][y+1].schema = updateSchema( 'top',	this.field[x][y+1].schema, this.field[x][y].tile.schema );
		this.field[x+1][y].schema = updateSchema( 'right',	this.field[x+1][y].schema, this.field[x][y].tile.schema );
		this.field[x][y-1].schema = updateSchema( 'bottom',	this.field[x][y-1].schema, this.field[x][y].tile.schema );
		this.field[x-1][y].schema = updateSchema( 'left',	this.field[x-1][y].schema, this.field[x][y].tile.schema );

		this.field[x][y+1].nextToTile = true;
		this.field[x+1][y].nextToTile = true;
		this.field[x][y-1].nextToTile = true;
		this.field[x-1][y].nextToTile = true;
	}

	highlightField( x, y, color )
	{
		this.field[x][y].fieldHook.addClass( 'is-highlighted' ).addClass( 'highlight-' + color );
	}
}


class Player
{

	constructor( data )
	{
		this.id = data.id;
		this.index = data.index;
		this.name = data.name;
	}

}


class Core
{

	setCurrentTile( tileData )
	{
		
		let tile = this.currentTile = new Tile( tileData );

		$( '.current-tile' ).html( tile.getHTML() );
	}

	setActivePlayer( player )
	{
		this.CurrentPlayer = this.players[ player.index ];
		$( '.game-player' ).removeClass('player-is-active');
		$( '.game-player[player-index=' + player.index + '][player-id=' + player.id + ']' ).addClass('player-is-active');
	}

	/*------------------------------------------------------------------------------*/
	/*------------------------------Metody Zarządzające-----------------------------*/
	/*------------------------------------------------------------------------------*/

	init( data )
	{
		this.setCurrentTile( data.currentTile );	
		
		this.board = new Board( data.board );

		this.players = {};

		for( const player of data.players.list )
		{
			// Dodawanie gracza do tablicy graczy
			let hook = this.players[ player.index ] = new Player( player );

			// Generowanie widoku listy graczy - wersja prymitywna
			$( '.game-players-list' ).append('<div class="game-player" player-index="' + player.index + '" player-id="' + player.id + '">' + player.name + '</div>');

		}
		// Ustawienia aktywnego gracza
		this.setActivePlayer( this.players[ data.players.currentPlayer.index ] );


	}

	responseHandler()
	{

	}

	addToRequest()
	{

	}


}
