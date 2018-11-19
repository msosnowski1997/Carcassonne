<?php

class Dev
{
	private static $dev = FALSE;

	public static function print( $message )
	{
		if( self::$dev ) echo $message.'<br>';
	}
	
}