<?php


// $num = 10;
// $last = null;
// $array = [ '\/', '\/', '\/', '\/', '\/', '\/', '<<<', '<<<', '>>>', '>>>' ];

// for ($i=0; $i < 10; $i++) { 
	
// 	$key = array_rand( $array );
// 	if( $array[$key] == '>>>' || $array[$key] == '<<<' )
// 	{
// 		if( $array[$key] == $last ) echo 'Powtorzenie!!!<br>';
// 		$last = $array[$key];
// 	}

// 	echo $array[$key]. '<br>';
// 	unset($array[$key]);
// }





// die;

function show( string $title, array $array )
{
	echo ("<h3>". $title ."</h3>");
	echo ( "<pre>" .print_r( $array, true ). "</pre>" );
	echo ("<hr>"); 
}

$tile = array ();
$tile['amount'] = 4;
$tile['info']['pattern'] = 'frcc';
$tile['info']['extension'] = 'river';
$tile['info']['type'] = 'BB6F3';


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
	'movesList' => [
		15 => [
			'moveType' => 'setTile',
			'setTile' => [
				'tileData' => [

				],
				'pos_x' => 13,
				'pos_y' => -8,
				'orienation' => 'left',
				'pawn' => [
					'type' => 'normal', // normal | big | abbot | pig | builder
					'placeID' => 3
				]
			]
		],
		16 => [
			'moveType' => 'setTile',
			'setTile' => [
				'tileData' => [

				],
				'pos_x' => 4,
				'pos_y' => 7,
				'orienation' => 'top',
				'pawn' => [
					'type' => 'abbot', // normal | big | abbot | pig | builder
					'placeID' => 3
				]
			]
		]
	]
];

$loadResponse_no_move = [
	'lastMoveID' => 15
];

show( 'Basic Tile Data', $tile );
// show( 'Informacje o ruchu z klienta JS do serwera', $jsToServer );
show( 'Move info from JS', $moveInfo );
show( 'JSloadRequest', $loadRequest );
show( 'JSloadResponse with-move', $loadResponse_with_move );
// show( 'JSloadResponse no-move', $loadResponse_no_move );




















