<?php

class Magicien extends Personnage
{
 private $_magie;

public function lancerUnSort($perso)
{
	$perso->recevoirDegats($this->_magie);
}

public function gagnerExperience()
{

	parent::gagnerExperience();

	if ($this->_magie < 100)
	{
		$this->_magie += 10; 
	}
}