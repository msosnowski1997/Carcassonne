function checkPattern( field, tile )
{
	for ( var i = 0 ; i < 4 ; i++ )
	{
		if( field[i] == 'u' || field[i] == tile[i] ) continue;
		return false;
	}
	return true;
}