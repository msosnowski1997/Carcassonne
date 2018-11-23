<?php

class Dev
{
	private static $dev = FALSE;

	public static function printIt( $message )
	{
		if( self::$dev ) echo $message.'<br>';
	}
	
}