<?php session_start();

function autoLoader($class)
{
	$parts = explode('\\', $class);
    require_once 'class/'. end($parts) .'.class.php';
    return true;
}

spl_autoload_register( 'autoLoader' );


if( isset( $_GET['action'] ) && $_GET['action'] == 'newgame')
{
	unset($_SESSION['save']);
}

// Odczyt ---------------------------------------------------------------------------------------
if( isset( $_GET['id'] ) )
{
	if( is_file( 'saves/game-'. $_GET['id'] ) )
	{
		$game = unserialize( base64_decode( file_get_contents( 'saves/game-'. $_GET['id'] ) ) );
	}
	else
	{
		$players[] = [ 'id' => 1, 'index' => 0, 'name' => 'Player 1', 'color' => 'red' ];
		$players[] = [ 'id' => 2, 'index' => 1, 'name' => 'Player 2', 'color' => 'blue' ];
		$game = new Games\Carcassonne\Core( $_GET['id'], [ 'classic' ], $players );
	}
}
else // Dla gry na sesji
{
	if( isset( $_SESSION[ 'save' ] ) )
	{
		$game = unserialize( base64_decode( $_SESSION['save'] ) );
	}
	else
	{
		$players[] = [ 'id' => 1, 'index' => 0, 'name' => 'Player 1', 'color' => 'red' ];
		$game = new Games\Carcassonne\Core( 1, [ 'classic' ], $players );
	}
}
// Przetwarzanie --------------------------------------------------------------------------------
$request = json_decode($_POST['data'], true );
$game->transferRequest( $request );
echo $game->getAnswer();

// Zapis ----------------------------------------------------------------------------------------
if( isset( $_GET['id'] ) )
{
	file_put_contents( 'saves/game-'. $_GET['id'] , base64_encode( serialize( $game ) ) );
}
else // Dla gry na sesji
{
	$_SESSION['save'] = base64_encode( serialize( $game ) );
}
