class Board
{
	/** 
	 * int _ymin;
	 * int _ymax;
	 * int _xmin;
	 * int _xmax;
	**/ 

	constructor( data )
	{
		this._xmax = data.xmax;
		this._xmin = data.xmin;
		this._ymax = data.ymax;
		this._ymin = data.ymin;
		this.buildBoard();

		// Dodawanie istniejących płytek 
		for( const tile of data.tiles )
		{
			let tileob = new Tile( tile.info );
			this.pickTileToBoard( tile.x, tile.y, tileob );
		}
	}

	buildBoard( x = null, y = null )
	{

		const boardHook = $( '.game-board' );
		const rowHTML = function( y ) { return '<div class="game-row" position-y=' + y + '></div>'; }
		const rowHook = function( y ) { return $('.game-row[position-y=' + y + ']'); }
		const fieldHTML = function( x, y ) { return '<div class="game-field" position-x=' + x + ' position-y=' + y + '></div>'; }
		const fieldHook = function( x, y ) { return $( '.game-field[position-x=' + x + '][position-y=' + y + ']' ); }
		const exist = function ( hook ) { return hook.length; }
		if( x != null && y != null)
		{
			if( this._ymin < y && y < this._ymax && this._xmin < x && x < this._xmax ) return;
			if(y == this._ymax) this._ymax++;
			if(y == this._ymin) this._ymin--;
			if(x == this._xmax) this._xmax++;
			if(x == this._xmin) this._xmin--;
		}
		for (let y = 1 ; y <= this._ymax ; y++ )
		{
			if( !exist( rowHook( y ) ) ) boardHook.prepend( rowHTML( y ) );
			let row = rowHook( y );

			for ( let x = 1 ; x <= this._xmax ; x++ ) 
			{
				let field = fieldHook( x, y );

				if( !exist( field ) )
				{
					row.append( fieldHTML( x, y ) ); 
					Field.add( x, y, fieldHook( x, y ) );
				}
			}

			for ( let x = 0 ; x >= this._xmin ; x-- ) 
			{
				let field = fieldHook( x, y );

				if( !exist( field ) )
				{
					row.prepend( fieldHTML( x, y ) ); 
					Field.add( x, y, fieldHook( x, y ) );
				}
			}

		}

		for (let y = 0; y >= this._ymin ; y-- )
		{
			if( !exist( rowHook( y ) ) ) boardHook.append( rowHTML( y ) );
			let row = rowHook( y );

			for ( let x = 1 ; x <= this._xmax ; x++ ) 
			{
				let field = fieldHook( x, y );

				if( !exist( field ) )
				{
					row.append( fieldHTML( x, y ) ); 
					Field.add( x, y, fieldHook( x, y ) );
				}
			}

			for ( let x = 0 ; x >= this._xmin ; x-- ) 
			{
				let field = fieldHook( x, y );

				if( !exist( field ) )
				{
					row.prepend( fieldHTML( x, y ) ); 
					Field.add( x, y, fieldHook( x, y ) );
				}
			}
		}
	}

	findAvaliableFieldsForTile( tile )
	{
		const findOrientations = function( field, tile )
		{
			let orienatations = [];
			for ( var i = 3 ; i >= 0 ; i-- )
			{
				orienatations[i] = true;
				if( ! checkPattern( field.slice( i, i+4 ), tile ) ) orienatations[i] = false;
			}
			return orienatations;
		}

		const parser1 = function( orientations )
		{
			let temp1 = false;
			for (var i = 0; i < orientations.length; i++)
			{
				
				if(orientations[i]) temp1 = true;
			}
			return temp1;
		}


		$( '.field-possible-to-play' ).removeClass( 'field-possible-to-play' );

		let orientationsData = [];

		for( let y = this._ymax ; y >= this._ymin ; y-- )
		{
			for( let x = this._xmin ; x <= this._xmax ; x++ )
			{
				let field = Field.get( x, y );

				if( ! ( field.isNextToTile() && field.isFree() ) ) continue;
				let orientations = findOrientations( field.getPattern(8), tile.getPattern() );

				let temp = {};
				temp['x'] = x;
				temp['y'] = y;
				temp['orientations'] = orientations;
				orientationsData.push( temp );

				if( ! parser1( orientations ) ) continue;

				Field.get( x, y ).hook().addClass('field-possible-to-play');

			}
		}

		Field.setOrientations( orientationsData );
	}

	pickTileToBoard( x, y, tile )
	{
		let field = Field.get( x, y );

		tile = field.tile( tile );
		field.hook().html( field.getTile().getHTML() );
		// Obrot
		this.buildBoard( x, y );

		Field.get( x, y-1 ).isNextToTile( true ).setPattern( 'top',		tile.getPattern()[2] );
		Field.get( x-1, y ).isNextToTile( true ).setPattern( 'right',	tile.getPattern()[3] );
		Field.get( x, y+1 ).isNextToTile( true ).setPattern( 'bottom',	tile.getPattern()[0] );
		Field.get( x+1, y ).isNextToTile( true ).setPattern( 'left',	tile.getPattern()[1] );

		Core.clearCurrentField();
	}

	showTileOnBoard( x, y )
	{
		if( typeof Core.getCurrentField() != 'undefined')
		{
			Core.getCurrentField().hook().addClass('field-possible-to-play').removeClass('highlight-black').html('');
		}
		let field = Core.setCurrentField( x, y ).hook();

		field.removeClass('field-possible-to-play').addClass('highlight-black');



		///////////////////////////////////////////////////////////////////////////////
		let orientations = [];
		if(Field._orientations[x][y][0]) orientations.push('top'); 
		if(Field._orientations[x][y][1]) orientations.push('right'); 
		if(Field._orientations[x][y][2]) orientations.push('bottom'); 
		if(Field._orientations[x][y][3]) orientations.push('left'); 
		let loop = {};
		for ( let i = 0 ; i < orientations.length ; i++ ) 
		{
			loop[ orientations[i] ] = orientations[ (i+1) % (orientations.length) ];
		}

		Core.currentOrientations = loop;

		Core.getCurrentTile().rotate( orientations[0] );

		$( 'button#confrim' ).removeAttr("disabled");
		$( 'button#rotate' ).attr("disabled","disabled");
		if( orientations.length > 1 ) $( 'button#rotate' ).removeAttr("disabled");


		Field.get( x, y ).hook().html( Core.getCurrentTile().getHTML() );

	}
}