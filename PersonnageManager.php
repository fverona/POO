<?php


class PersonnageManager
{

	private $_db; // inqtance de PDO

	const existe = ": ce personnage existe bien ";
	const nexiste_pas = ": ce personnage n'existe pas du tout ";

	public function __construct($db)
	{

		$this->setDb($db);

	}


	public function setDb(PDO $db)
	{

		$this->_db = $db;
	}


	public function add(Personnage $perso)
	{

		$q = $this->_db->prepare('INSERT INTO personnages(nom, forcePerso, degats, niveau, experience, fdate, coups) VALUES(:nom, :forcePerso, :degats, :niveau, :experience, fdate = NOW(), coups = 0)');


	    $q->bindValue(':nom', $perso->nom());
	    $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
	    $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
	    $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
	    $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);

	    return (bool) $q->execute();

	    $q->closeCursor();


	}

	public function delete(Personnage $perso)
	{

		 $this->_db->exec('DELETE FROM personnages WHERE id = '.$perso->id());
	    
	}


	public function get($id)
	{

		if (is_int($id))
		{
			$id = (int) $id;

   			$q = $this->_db->query('SELECT id, nom, forcePerso, degats, niveau, experience, coups, fdate FROM personnages WHERE id = '. $id);
    	}	
	  
    	else
    	{
   			$q = $this->_db->query('SELECT id, nom, forcePerso, degats, niveau, experience, coups, fdate FROM personnages WHERE nom = "'.$id.'"');
    	}

    	$donnees = $q->fetch(PDO::FETCH_ASSOC);

	    $q->closeCursor();
    	
    	return new Personnage($donnees);
	}


	public function getlist()
	{

		$persos = [];

    	$q = $this->_db->query('SELECT id, nom, forcePerso, degats, niveau, experience, coups, fdate FROM personnages ORDER BY nom');

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
      	
      		$persos[] = new Personnage($donnees);
      	
      	}

	    $q->closeCursor();
   		
   		return $persos;

	}

	public function update(Personnage $perso)
	{

		$q = $this->_db->prepare('UPDATE personnages SET forcePerso = :forcePerso, degats = :degats, niveau = :niveau, experience = :experience, coups = :coups, fdate = NOW() WHERE id = :id');

	    $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
	    $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
	    $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
	    $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);
	    $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);
	    $q->bindValue(':coups', $perso->coups(), PDO::PARAM_INT);

	    $q->execute();

	    $q->closeCursor();
	}

	public function count()
	{

		$q = $this->_db->prepare('select count(*) from personnages');

		$q->execute();

		return  $q->fetchColumn();
	}	


	public function exist($idperso)
	{

		if (is_int($idperso))
		{

			$q = $this->_db->prepare('select count(*) from personnages where id = :id ');
			
	    	$q->bindValue(':id', $idperso, PDO::PARAM_INT);

		}

		else

		{
			$q = $this->_db->prepare('select count(*) from personnages where nom = :nom ');

	    	$q->bindValue(':nom', $idperso);

		}

		$q ->execute();

		return (bool) $q ->fetchColumn();

	}	

	public function nomvalide($nom)
	{
		return (bool) empty($nom);
	}

}