<?php

require_once("Personnage.php");
require_once("PersonnageManager.php");



$db = new PDO('mysql:host=localhost;dbname=personnages;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


//Ajout personnage 

$perso = new Personnage([ 'nom' => 'Arrapao', 'forcePerso' => 5,  'degats' => 1, 'niveau' => 1, 'experience' => 1 ]);

$manager = new PersonnageManager($db);

$manager->add($perso);



// Suppression 

$perso = new Personnage([ 'id' => 1 ]);

$manager->delete($perso);


// lecture -  PersonnageManager fait un "return new Personnage($donnees);"

$id=3;

$perso = $manager->get($id);

echo  $perso->nom(), ' a ', $perso ->forcePerso(), ' de force, ', $perso->degats(), ' de dégâts, ', $perso->experience(), ' d\'expérience et est au niveau ', $perso->niveau() , "<br><br><br>" ;



// lecture -  PersonnageManager fait un "return $persos qui est un tableau contenant tous les objets personnage

$persos=$manager->getlist();

foreach($persos as $perso)
{
    echo  $perso->nom(), ' a ', $perso ->forcePerso(), ' de force, ', $perso->degats(), ' de dégâts, ', $perso->experience(), ' d\'expérience et est au niveau ', $perso->niveau() , "<br>" ;
}


// Update  

$perso = new Personnage([ 'id' => 4, 'forcePerso' => 88,  'degats' => 28, 'niveau' => 38, 'experience' => 48 ]);

$manager->update($perso);