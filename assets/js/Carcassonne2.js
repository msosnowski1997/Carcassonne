class Tile
{

	constructor( data )
	{
		this.sides = {};
		this.sides.a	= data.sides.a;
		this.sides.b	= data.sides.b;
		this.sides.c	= data.sides.c;
		this.sides.d	= data.sides.d;
		this.skin		= data.skin;
		this.extension	= data.extension;
		this.orienatation = data.orienatation; 
	}

	rotate( side )
	{
		console.log('Nie stworzono funkcji');
	}

	getHTML()
	{
		return '<img src="assets/img/tiles/' + this.extension + '/' + this.skin + '.jpg" width="100px" height="100px">';
	}

}


class Board
{
	/* 
	 * int ymin, ymax, xmin, xmax;
	 * 
	 * object fields[x][y] = { 'tile' : Tile, 'fieldHook' = jquery.hook }
	 * 
	*/ 
	constructor( data )
	{
		this.xmax = data.xmax;
		this.xmin = data.xmin;
		this.ymax = data.ymax;
		this.ymin = data.ymin;
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
			if(x == xmax) this.xmax++;
			if(x == xmin) this.xmin--;
			if(y == ymax) this.ymax++;
			if(y == ymin) this.ymin--;
		}
		const boardHook = $( '.game-board' );
		const rowHTML = function( y ) { return '<div class="game-row" position-y=' + y + '></div>'; }
		const rowHook = function( y ) { return $('.game-row[position-y=' + y + ']'); }
		const fieldHTML = function( x, y ) { return '<div class="game-field" position-x=' + x + ' position-y=' + y + '></div>'; }
		const fieldHook = function( x, y ) { return $( '.game-tile[position-x=' + x + '][position-y=' + y + ']' ); }
		const exist = function ( hook ) { return hook.length; }

		for (let y = 1 ; y <= this.ymax ; y++ )
		{

			row = rowHook( y );

			if( !exist( row ) ) boardHook.prepend( rowHTML( y ) );

			for ( let x = 1 ; x <= this.xmax ; x++ ) 
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
				}
			}
		}

		for (let y = 0; y >= this.ymin ; y-- )
		{
			row = rowHook( y );

			if( !exist( row ) ) boardHook.prepend( rowHTML( y ) );

			for ( let x = 1 ; x <= this.xmax ; x++ ) 
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
				}
			}
		}

	}

	findAvaliableFieldsForTile( tile )
	{

	}

	showTileOnBoard()
	{

	}

	pickTileToBoard( x, y, tile )
	{
		this.field[ x ][ y ]['tile'] = Object.assign( {}, tile );
		this.field[ x ][ y ]['fieldHook'].html( '' ); // Trzeba dokończyć. Brak wczytywania obrazka i obrotu
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
	/* Tile currentTile;
	 * 
	 * Board board;
	 * 
	 * Object players of Player
	 * 
	 * ref Player CurrentPlayer
	*/ 

	setCurrentTile( tileData )
	{
		// Tworzenie obiektu
		let tile = this.currentTile = new Tile( tileData );

		let hook = $( '.current-tile' ).html( tile.getHTML() );
		tile.hook = hook.children( 'img' );
		tile.rotate( tile.orienatation );
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