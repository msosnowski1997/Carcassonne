class Tile
{
	constructor( data )
	{
		this._sides		= data._sides;
		this._pattern	= data._pattern;
		this._skin		= data._skin;
		this._extension	= data._extension;
		this._orientation = data._orientation; 

		this.rotate( this._orientation );

		// Ustawienie patternu i 
		// Obkręcenie płytki
	}
	rotate( side )
	{
		switch( side ) {
		    case 'top':
		    	this._pattern = this._sides;
		    	this._orientation = side;
		        break;
		    case 'right':
		    	this._pattern = this._sides[3] + this._sides[0] + this._sides[1] + this._sides[2];
		    	this._orientation = side;
		        break;
		    case 'bottom':
		    	this._pattern = this._sides[2] + this._sides[3] + this._sides[0] + this._sides[1];
		    	this._orientation = side;
		        break;
		    case 'left':
		    	this._pattern = this._sides[1] + this._sides[2] + this._sides[3] + this._sides[0];
		    	this._orientation = side;
		        break;
		}
	}

	getHTML()
	{
		return '<img class="tile-rotated-' + this._orientation + '" src="assets/img/tiles/' + this._extension + '/' + this._skin + '.jpg" width="98px" height="98px">';
	}

	getPattern()
	{
		return this._pattern;
	}

}