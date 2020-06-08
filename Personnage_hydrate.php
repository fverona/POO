<?php


class Personnage
{

private $_id;
private $_nom;
private $_forcePerso;
private $_degats;
private $_niveau;	
private $_experience;




public function __construct($donnees)
    {
      $this->hydrate($donnees);
    }



public function hydrate(array $donnees) 
{

	foreach ($donnees as $key => $value) 
	{
		$method="set".ucfirst($key);

		if (method_exists($this, $method))
		{
			$this->$method($value);
		}
	}



}

public function id()  		 {return $this->_id;}
public function nom() 		 {return $this->_nom;}
public function forcePerso() {return $this->_forcePerso;}
public function degats()	 {return $this->_degats;}
public function niveau()	 {return $this->_niveau;}
public function experience() {return $this->_experience;}

public function setId($id)
{
	$id = (int) $id;

	if ($id > 0)
	{
		$this->_id = $id;
	}

}
public function setNom($nom)
{
	if(is_string($nom))
	{
		$this->_nom = $nom;
	}

}
public function setForcePerso($forcePerso)
{
	$forcePerso = (int) $forcePerso;

	if ($forcePerso > 0 && $forcePerso <= 100 )
	{
		$this->_forcePerso = $forcePerso;
	}
}

public function setDegats($degats)
{

	$degats = (int) $degats;

	if ($degats > 0 && $degats <=100)
	{
		$this->_degats = $degats;
	}

}


public function setNiveau($niveau)
{
	$niveau = (int) $niveau;

	if ($niveau > 0 && $niveau <= 100)
	{
		$this->_niveau = $niveau;		
	}
}


public function setExperience($experience)
{

	$experience = (int) $experience;

	if ($experience > 0 && $experience <=100)
	{
		$this->_experience = $experience;
	}

}


}

$db = new PDO('mysql:host=localhost;dbname=personnages;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$request = $db->query('select id, nom, forcePerso, degats, niveau, experience FROM personnages');

while ($donnees = $request->fetch(PDO::FETCH_ASSOC))
{

	$perso = new personnage($donnees);

    echo  $perso->nom(), ' a ', $perso ->forcePerso(), ' de force, ', $perso->degats(), ' de dégâts, ', $perso->experience(), ' d\'expérience et est au niveau ', $perso->niveau() , "<br>" ;

}
