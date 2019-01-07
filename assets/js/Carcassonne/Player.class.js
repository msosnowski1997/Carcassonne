class Player
{

	constructor( data )
	{
		this.id = data.id;
		this.index = data.index;
		this.name = data.name;
		this.index = data.index;
		$( '.game-players-list' ).append('<div class="game-player" player-index="' + this.index + '" player-id="' + this.id + '">' + this.name + '</div>');
	}
	
}