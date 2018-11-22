<?php

class Tile
{
	private $sides;

	private $skin;

	private $extension;

	private $orientation;

	public function __construct($data)
	{
		$this->extension = $data['extension'];
		$this->sides['a'] = $data[0];
		$this->sides['b'] = $data[1];
		$this->sides['c'] = $data[2];
		$this->sides['d'] = $data[3];
		$this->skin = $data[4];
		$this->orientation = ( isset( $data['orienatation'] ) ) ? $data['orienatation'] : 'top';
	}

	public function TileData()
	{
		$data['extension'] = $this->extension;
		$data['skin'] = $this->skin;
		$data['schema'] = $this->sides['a'].$this->sides['b'].$this->sides['c'].$this->sides['d'];
		$data['sides'] = $this->sides['a'].$this->sides['b'].$this->sides['c'].$this->sides['d'];
		$data['orienatation'] = $this->orientation;
		$data['_extension'] = $this->extension;
		$data['_skin'] = $this->skin;
		$data['_pattern'] = $this->sides['a'].$this->sides['b'].$this->sides['c'].$this->sides['d'];
		$data['_sides'] = $this->sides['a'].$this->sides['b'].$this->sides['c'].$this->sides['d'];
		$data['_orientation'] = $this->orientation;
		return $data;
	}

	public function setOrientation( $orientation )
	{
		$this->orientation = $orientation;
	}
}