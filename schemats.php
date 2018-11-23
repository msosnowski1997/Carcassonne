<?php

function show( string $title, array $array )
{
	echo ("<h3>". $title ."</h3>");
	echo ( "<pre>" .print_r( $array, true ). "</pre>" );
	echo ("<hr>"); 
}

$tile = array ();

$tile['pattern'] = 'frcc';
$tile['orientation'] = 'bottom';
$tile['extension'] = 'river';
$tile['skin'] = 'BB6F3';
$tile['properties']['haveGarden'] = 1;
$tile['properties']['haveChurch'] = 0;


$moveInfo = [
	'type' => 'move',
	'move' => [
		'moveID' => 16,
		'moveType' => 'setTile', // setTile | 
		'setTile' => [
			'pos_x' => 13,
			'pos_y' => -8,
			'orientation' => 'left',
			'pawn' => [
				'type' => 'normal', // normal | big | abbot | pig | builder
				'placeID' => 3
			]
		]
	]
];


$loadRequest = [
	'type' => 'load',
	'load' => [
		'expectedMoveID' => 16
	]
];

$loadResponse_with_move = [
	'lastMoveID' => 16,
	'moveType' => 'setTile',
	'setTile' => [
		'pos_x' => 13,
		'pos_y' => -8,
		'orienation' => 'left',
		'pawn' => [
			'type' => 'normal', // normal | big | abbot | pig | builder
			'placeID' => 3
		]
	]
];

$loadResponse_no_move = [
	'lastMoveID' => 15
];


// show( 'Informacje o ruchu z klienta JS do serwera', $jsToServer );
show( 'JSloadRequest', $loadRequest );
show( 'JSloadResponse with-move', $loadResponse_with_move );
show( 'JSloadResponse no-move', $loadResponse_no_move );




















