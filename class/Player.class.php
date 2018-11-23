<?php

class Player
{

	private $id;

	private $name;

	private $color;

	public function __construct( $id, $name, $color = null )
	{
		$this->id = $id;
		$this->name = $name;
		$this->color = $color;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPlayerInfo()
	{
		$data['id'] = $this->id;
		$data['name'] = $this->name;
		return $data;
	}
	
}