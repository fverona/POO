<?php


class Compteur
{

	private static $compteur;

	public function __construct()
	{
		self::$compteur++;
	}


	public static function affiche_compteur()
	{

		return self::$compteur;
	}



}

$INST1 = new Compteur();
$INST2 = new Compteur();
$INST3 = new Compteur();

echo "Nombre d'instances de la classe = " . Compteur::affiche_compteur();