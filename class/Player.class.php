<?php

class Player
{

	private $id;

	private $name;

	public function __construct( $id, $name )
	{
		$this->id = $id;
		$this->name = $name;
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