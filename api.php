<?php session_start();

function autoLoader($class)
{
	require_once( 'class/'. $class .'.class.php' );
	Dev::print( 'Wczytano klase "'. $class .'"' );
}

spl_autoload_register( 'autoLoader' );

if( isset( $_GET['action'] ) && $_GET['action'] == 'newgame')
{
	Dev::print('Usuwanie zapisu gry');
	unset($_SESSION['save']);
}

// $timedelay = 1;
// for ($i=0; $i < 10000000; $i++) { 
// 	$timedelay++;
// }


if( isset( $_SESSION[ 'save' ] ) )
{
	$game = unserialize( base64_decode( $_SESSION['save'] ) );
}
else
{
	$extensions[] = 'classic';
	$game = new Core( $extensions );
}

if( isset($_POST['data']) )
{
	$request = json_decode($_POST['data'], true );
	$game->parserequest( $request );
	$game->sendAnswer();
}
else
{
	if( !isset( $_GET['action'] ) ) $_GET['action'] = 'nav';

	switch ($_GET[ 'action' ]) {
		case 'parserequest':
			$game->parserequest( json_decode($_POST['data'], true ) );
			$game->sendAnswer();
			break;

		case 'getTile':
			$game->addToAnswer( "nexttile", $game->tilesCollection->getRandomTile()->TileData() );
			$game->sendAnswer();
			break;
		
		case 'getFullData':
			$game->getFullGameData();
			$game->sendAnswer();
			break;
		case 'setUser':
		$_SESSION['username'] = $_GET['name'];
		$_SESSION['userid'] = $_GET['id'];
			break;
		case 'test':
			echo $_SESSION['save'];
			break;
		case 'nav':

			// $game->getFullGameData();
			// $game->sendAnswer();
			header('Location: nav.html');
			break;
	}
}



$_SESSION['save'] = base64_encode( serialize( $game ) );