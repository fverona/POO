<?php

class Personaggio
{
	private $_id;
	private $_degats;
	private $_nom;
	private $_force;

	const frase_id ="A me ID all'é quescta ";
	const frase_nome ="Me ciamu ";
	const frase_forza ="Go in'a forsa de ";
	const frase_danni ="Man scalau a ";
	const forza_media = 50;
	const forza_debole = 10;
	const forza_massima = 80;


public function __construct($caracteres)
{

	$this->hydrate($caracteres);
}	


public function hydrate(array $caracteres)
{

	foreach($caracteres as $key => $value )
	{
		
		$method="set".ucfirst($key);

		if (method_exists($this, $method))
		{
			$this->$method($value);
		}
	}


}


public function id()
{
	return $this->_id;
}

public function degats()
{
	return $this->_degats;
}

public function nom()
{
	return $this->_nom;
}

public function force()
{
	return $this->_force;
}

public function setId($id)
{
	
 if (!is_int($id))
    {
     $id = (int) $id;
    }  

	$this->_id = $id;
}

public function setDegats($degats)
{
	if (!is_int($degats))
    {
     $degats = (int) $degats;
    }  

	$this->_degats = $degats;
}

public function setNom($nom)
{
	if(is_string($nom))
	{
		$this->_nom = $nom;
	}
}

public function setForce($force)
{
    if (in_array($force, [self::forza_debole, self::forza_media, self::forza_massima]))
     {
 	    $this->_force = $force; 
     }
}

public function frapper(Personaggio $personage)
{

	if ($personage->id() == $this->_id)
	{

		$this->_degats = $this->_degats + $this->_force;

		$this->recevoir_degats(); 


	}
	else
	{

		$personage->setDegats( $personage->degats() + $this->_force); 
		echo "<br>U " . $this->nom() . " u la piccau " . $personage->nom() . " e u l'ha descrutu a " . $personage->degats(); 
	}	
} 

private function recevoir_degats()
{

 echo "Aia porc'accidente ! Me sun feto mo da sulu, sun desctrutu a " . $this->_degats;

} 


}

/*
$perso1 = new Personaggio(["id" => "1", "degats" => "2", "nom" => "Totino",  "force"=> Personaggio::forza_massima ]); 
$perso2 = new Personaggio(["id" => "2", "degats" => "5", "nom" => "Billola", "force"=> Personaggio::forza_debole ]); 

echo Personaggio::frase_nome  . $perso1->nom()    . "<br>";
echo Personaggio::frase_id    . $perso1->id()     . "<br>";
echo Personaggio::frase_forza . $perso1->force()  . "<br>";
echo Personaggio::frase_danni . $perso1->degats() . "<br>";


echo Personaggio::frase_nome  . $perso2->nom()    . "<br>";
echo Personaggio::frase_id    . $perso2->id()     . "<br>";
echo Personaggio::frase_forza . $perso2->force()  . "<br>";
echo Personaggio::frase_danni . $perso2->degats() . "<br>";


//echo "<br>" . $perso1->degats();
$perso1->frapper($perso1);
$perso1->frapper($perso2);
*/