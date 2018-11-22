class Field
{

	constructor( hook )
	{
		this._nextToTile = false;
		this._tile = null;
		this._pattern = 'uuuu';
		this._hook = hook;
	}

	setTile( tile )
	{
		this._tile = new Tile( tile );
		this._pattern = this._tile.getPattern();
		return this;
	}

	getTile()
	{
		return this._tile;
	}

	tile( tile = null )
	{
		if( tile === null )
		{
			return this._tile;
		}
		else
		{
			this._tile = new Tile( tile );
			this._pattern = this._tile.getPattern();
			return this;
		}
	}

	hook()
	{
		return this._hook;
	}

	setPattern( where, letter )
	{
		if(letter.length != 1) return false;

		switch( where )
		{
			case 'top':
				this._pattern = letter + this._pattern[1] + this._pattern[2] + this._pattern[3];
				break;
			case 'right':
				this._pattern = this._pattern[0] + letter + this._pattern[2] + this._pattern[3];
				break;
			case 'bottom':
				this._pattern = this._pattern[0] + this._pattern[1] + letter + this._pattern[3];
				break;
			case 'left':
				this._pattern = this._pattern[0] + this._pattern[1] + this._pattern[2] + letter;
				break;
			default:
				return false;
				break;
		}
		return this;
	}

	getPattern( length = null )
	{
		if( length === null )
		{
			return this._pattern;
		}
		else
		{
			let temp = "";
			for (var i = 0; i < length - 1; i++) {
				temp += this._pattern[i%4];
			}
			return temp;
		}

	}

	isNextToTile( bool = null )
	{
		if( bool != null && ( bool === true || bool === false ) ) 
		{
			this._nextToTile = bool;
			return this;
		}

			
		return this._nextToTile;
	}

	hook()
	{
		return this._hook;
	}

	isFree()
	{
		if( this._tile === null )
			return true;
		else
			return false;
	}


	//----------------//
	// Static methods //
	//----------------//
	/**
	 * field[x][y] = Field
	 * 
	 * orientations[x][y] = []
	 * 
	**/

	static add( x, y, hook )
	{
		if( typeof Field._field == 'undefined' ) Field._field = {};
		if( typeof Field._field[x] == 'undefined' ) Field._field[x] = {};
		if( typeof Field._field[x][y] != 'undefined')
		{
			return false;
		}
		else
		{
			Field._field[x][y] = new Field( hook );
			return true;
		}
	}

	static get( x, y )
	{
		if( typeof Field._field == 'undefined' ) return false;
		if( typeof Field._field[x] == 'undefined' ) return false;
		if( typeof Field._field[x][y] == 'undefined') return false;
		return Field._field[x][y];
	}

	static setOrientations( data )
	{
		Field._orientations = {};

		for( const orientation of data )
		{
			if( typeof Field._orientations[orientation.x] == 'undefined' ) Field._orientations[orientation.x] = {};
			Field._orientations[orientation.x][orientation.y] = orientation.orientations;
		}
	}
}
