<?php

namespace Games\Carcassonne;

class Player
{

	private $id;

	private $index;

	private $name;

	private $points;

	private $color;

	public function __construct( $id, $index, $name, $color = null )
	{
		$this->id = $id;
		$this->index = $index;
		$this->name = $name;
		$this->color = $color;
		$this->points = 0;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getInfo()
	{
		$data['id'] = $this->id;
		$data['index'] = $this->index;
		$data['name'] = $this->name;
		$data['color'] = $this->color;
		return $data;
	}

	
	
}