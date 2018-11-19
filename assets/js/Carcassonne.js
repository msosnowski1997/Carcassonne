class Tile
{
	constructor( data )
	{
		this.sides = [];
		this.sides.a	= data.sides.a;
		this.sides.b	= data.sides.b;
		this.sides.c	= data.sides.c;
		this.sides.d	= data.sides.d;
		this.skin		= data.skin;
		this.extension	= data.extension;
		this.orienatation = data.orienatation; 
	}

	getHTML()
	{
		return '<img src="assets/img/tiles/' + this.extension + '/' + this.skin + '.jpg" width="100px" height="100px">';
	}

	rotate( side )
	{
		this.hook.removeClass('tile-rotated-top').removeClass('tile-rotated-right').removeClass('tile-rotated-bottom').removeClass('tile-rotated-left');
		switch( side ) {
		    case 'top':
		    	this.orienatation = side;
		        this.hook.addClass('tile-rotated-top')
		        break;
		    case 'right':
		    	this.orienatation = side;
		        this.hook.addClass('tile-rotated-right')
		        break;
		    case 'bottom':
		    	this.orienatation = side;
		        this.hook.addClass('tile-rotated-bottom')
		        break;
		    case 'left':
		    	this.orienatation = side;
		        this.hook.addClass('tile-rotated-left')
		        break;
		}
	}
}

class Board
{

	constructor( data )
	{
		this.tiles = {};
		this.toprow = data.toprow;
		this.botrow = data.botrow;
		this.leftcol = data.leftcol;
		this.rightcol = data.rightcol;

		this.buildBoard( this.botrow, this.toprow, this.leftcol, this.rightcol );

		for (const tile of data.tiles) 
		{
			let x = tile.x.toString();
			let y = tile.y.toString();


			if (typeof this.tiles[x] == 'undefined') {
				this.tiles[x] = {};
			}

			this.tiles[x][y] = new Tile( tile.info );
			this.setTile( x, y, this.tiles[x][y] );
		}
	}

	setTile( x, y, tile )
	{
		let hook = $( '.game-tile[position-x=' + x + '][position-y=' + y + ']' )
			.html( tile.getHTML() )
			.removeClass('tile-possible-to-play');
		tile.hook = hook.children( 'img' );
		tile.rotate( tile.orienatation );
		

		if(y == this.botrow)
		{
			this.botrow--
			this.buildBoard( this.botrow, this.botrow, this.leftcol, this.rightcol );
		}
		if(y == this.toprow)
		{
			this.toprow++;
			this.buildBoard( this.toprow, this.toprow, this.leftcol, this.rightcol );
		} 
		if(x == this.leftcol)
		{
			this.leftcol--;
			this.buildBoard( this.botrow, this.toprow, this.leftcol, this.leftcol);
		} 
		if(x == this.rightcol)
		{
			this.rightcol++;
			this.buildBoard( this.botrow, this.toprow, this.rightcol, this.rightcol);
		} 
	}

	buildBoard( botrow, toprow, leftcol, rightcol )
	{
		for (let y = 0; y <= toprow; y++) {

			let row = $('.game-row[position-y=' + y + ']');
			if(!row.length)
			{
				$('.game-board').prepend('<div class="game-row" position-y=' + y + '></div>');
			}

			row = $('.game-row[position-y=' + y + ']');

			for (let x = 0; x <= rightcol; x++) {
				if( !( $( '.game-tile[position-x=' + x + '][position-y=' + y + ']').length ) )

					row.append('<div class="game-tile tile-possible-to-play" position-x="' + x + '" position-y="' + y + '">' + x + 'x' + y + '</div>');
			}
			for (let x = -1; x >= leftcol; x--) {
				if( !( $( '.game-tile[position-x=' + x + '][position-y=' + y + ']').length ) )
					row.prepend('<div class="game-tile tile-possible-to-play" position-x="' + x + '" position-y="' + y + '">' + x + 'x' + y + '</div>');
			}
		}
		for (let y = -1; y >= botrow; y--) {

			let row = $('.game-row[position-y=' + y + ']');
			if(!row.length)
			{
				$('.game-board').append('<div class="game-row" position-y=' + y + '></div>');
			}

			row = $('.game-row[position-y=' + y + ']');

			for (let x = 0; x <= rightcol; x++) {
				if( !( $( '.game-tile[position-x=' + x + '][position-y=' + y + ']').length ) )
					row.append('<div class="game-tile tile-possible-to-play" position-x="' + x + '" position-y="' + y + '">' + x + 'x' + y + '</div>');
			}
			for (let x = -1; x >= leftcol; x--) {
				if( !( $( '.game-tile[position-x=' + x + '][position-y=' + y + ']').length ) )
					row.prepend('<div class="game-tile tile-possible-to-play" position-x="' + x + '" position-y="' + y + '">' + x + 'x' + y + '</div>');
			}
		}
	}
}

class Game
{
	// $board
	// $currentTile

	init( data )
	{
		this.currentTile = new Tile( data.nexttile );

		this.board = new Board( data.board );

		this.setCurrentTile( this.currentTile );

		this.buildPlayersList( data.players )
	}

	setCurrentTile( tiledata )
	{
		let tile = this.currentTile = new Tile ( tiledata );
		let hook = $( '.current-tile' ).html( tile.getHTML() );
		tile.hook = hook.children( 'img' );
		tile.rotate( tile.orienatation );
	}

	buildPlayersList( players )
	{
		for(const player of players.list )
		{
			$( '.game-players-list' ).append('<div class="game-player" player-index="' + player.index + '" player-id="' + player.id + '">' + player.name + '</div>');
		}
		this.setActivePlayer( players.currentPlayer );
	}

	setActivePlayer( player )
	{
		$( '.game-player' ).removeClass('player-is-active');
		$( '.game-player[player-index=' + player.index + '][player-id=' + player.id + ']' ).addClass('player-is-active');
	}

}

// $( document )
// .ready( 
// 	function() 
// 	{
// 		const game = new Game;
// 	}
// );