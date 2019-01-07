class Tile
{
	constructor( data )
	{
		this._sides		= data._sides;
		this._type		= data._type;
		this._extension	= data._extension;
		this._direction = data._direction; 

		this.rotate( this._direction );

		// Ustawienie patternu i 
		// Obkręcenie płytki
	}
	rotate( side )
	{
		switch( side ) {
		    case 'top':
		    	this._pattern = this._sides;
		    	this._direction = side;
		        break;
		    case 'right':
		    	this._pattern = this._sides[3] + this._sides[0] + this._sides[1] + this._sides[2];
		    	this._direction = side;
		        break;
		    case 'bottom':
		    	this._pattern = this._sides[2] + this._sides[3] + this._sides[0] + this._sides[1];
		    	this._direction = side;
		        break;
		    case 'left':
		    	this._pattern = this._sides[1] + this._sides[2] + this._sides[3] + this._sides[0];
		    	this._direction = side;
		        break;
		}
	}

	getHTML()
	{
		return '<img class="tile-rotated-' + this._direction + '" src="assets/img/tiles/' + this._extension + '/' + this._type + '.png" width="98px" height="98px">';
	}

	getPattern()
	{
		return this._pattern;
	}

}