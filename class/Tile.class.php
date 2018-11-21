<?php

class Tile
{
	private $sides;

	private $skin;

	private $extension;

	private $orienatation;

	public function __construct($data)
	{
		$this->extension = $data['extension'];
		$this->sides['a'] = $data[0];
		$this->sides['b'] = $data[1];
		$this->sides['c'] = $data[2];
		$this->sides['d'] = $data[3];
		$this->skin = $data[4];
		$orienatations = ['top', 'bottom', 'left', 'right'];
		$this->orienatation = $orienatations[ array_rand( $orienatations ) ];
	}

	public function TileData()
	{
		$data['extension'] = $this->extension;
		$data['skin'] = $this->skin;
		$data['schema'] = $this->sides['a'].$this->sides['b'].$this->sides['c'].$this->sides['d'];
		$data['sides'] = $this->sides['a'].$this->sides['b'].$this->sides['c'].$this->sides['d'];
		$data['orienatation'] = $this->orienatation;
		return $data;
	}

	public function setOrientation( $orienatation )
	{
		$this->orienatation = $orientation;
	}
}