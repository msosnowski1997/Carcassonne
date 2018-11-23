<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="Description" content="Tu wpisz opis zawartości strony" />
		<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<link rel="Stylesheet" type="text/css" href="assets/css/style.css?ver=<?php echo uniqid(); ?>" />
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/Carcassonne/functions.js?ver=<?php echo uniqid(); ?>"></script>
		<script src="assets/js/Carcassonne/Tile.class.js?ver=<?php echo uniqid(); ?>"></script>
		<script src="assets/js/Carcassonne/Field.class.js?ver=<?php echo uniqid(); ?>"></script>
		<script src="assets/js/Carcassonne/Board.class.js?ver=<?php echo uniqid(); ?>"></script>
		<script src="assets/js/Carcassonne/Player.class.js?ver=<?php echo uniqid(); ?>"></script>
		<script src="assets/js/Carcassonne/Core.class.js?ver=<?php echo uniqid(); ?>"></script>
		<title>Carcassonne2 Alpha</title>

	</head>
	<body>
		<div class="game-players-list"></div>
		<div class="game-current-tile">
				<div class="current-tile"></div>
				<button id="confrim" disabled="disabled">ZATWIERDZ</button>
				<button id="rotate" disabled="disabled">PRZEKRĘĆ</button>
			<span>
		</div>
		<h1><strong>Carcassonne <a href="changelog.txt"> Alpha </a></strong></h1>

		<div class="game-board"></div>
<hr>
<button id="newgame">NOWA GRA</button></p>


<!-- Test temp scripts -->
<script type="text/javascript">

const game = new Core;
// Ładowanie gry
$.ajax({
    url			: "api.php", //wymagane, gdzie się łączymy
    method		: 'post', //typ połączenia, domyślnie get
    dataType	: 'json', //typ danych jakich oczekujemy w odpowiedzi
    data		: {
    	data	: '{"action":"getFullGameData"}' 
    }
})
.done( function( res ) 
	{
		game.init( res );
	}
)
.fail(function( xhr ) {
	console.log('Failed response');
    console.log(xhr.responseText);
    alert("Nie udało się wczytać gry");
});


// Wysyłanie swojego ruchu
$( document ).on(
	'click',
	'.field-possible-to-play',
	function()
	{

		var x = parseInt($(this).attr('position-x'), 10);
		var y = parseInt($(this).attr('position-y'), 10);
		game._board.showTileOnBoard( x, y );
		
	}
);



$( document )
.on(
	'click', 
	'button#rotate', 
	function() 
	{
		let tile = Core.getCurrentTile();
		tile._orientation = Core.currentOrientations[ tile._orientation ];
		Core.getCurrentField().hook().html( tile.getHTML() );
	}
);

$( document ).on(
	'click',
	'button#confrim',
	function()
	{
		let data = {};
		data['action'] = 'moveInfo';
		data['moveInfo'] = {};
		data['moveInfo']['type'] = 'setTile';
		var x = data['moveInfo']['tileX'] = Core.getCurrentField('x');
		var y = data['moveInfo']['tileY'] = Core.getCurrentField('y');
		data['moveInfo']['orientation'] = Core.getCurrentTile()._orientation;

		let jsondata = JSON.stringify( data );
		$.ajax({
		    url			: "api.php", //wymagane, gdzie się łączymy
		    method		: 'post', //typ połączenia, domyślnie get
		    dataType	: 'json', //typ danych jakich oczekujemy w odpowiedzi
		    data		: {
		    	data	: jsondata
		    }
		})
		.done( function( res ) 
			{

				Core.getCurrentField().hook().removeClass("highlight-black");
				game.setActivePlayer( res.currentPlayer );

				game._board.pickTileToBoard( x, y, Core.getCurrentTile() );
				Core.setCurrentTile( res.currentTile );
				game._board.findAvaliableFieldsForTile( Core.getCurrentTile() );
				$( 'button#rotate' ).attr("disabled","disabled");
				$( 'button#confrim' ).attr("disabled","disabled");
			}
		)
		.fail(function( xhr ) {
			console.log('Failed response');
		    console.log(xhr.responseText);
		});

	}
);



























$( document )
.on(
	'click', 
	'button#newgame', 
	function() 
	{
		$.ajax({
		    url         : "http://localhost/Carcassonne/api.php", //wymagane, gdzie się łączymy
		    method      : "get", //typ połączenia, domyślnie get
		    data        : { //dane do wysyłki
		        action : 'newgame'
		    }
		})
		.done( 
			function( res ) 
			{
				location.reload();
			}
		)
		.fail(function() {
		    alert("Wystąpił błąd w połączeniu");
		});
	}
);

</script>

	</body>
</html>