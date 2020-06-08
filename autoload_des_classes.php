<?php

function chargerClasse($classe)
{
	
 require $classe . '.php';

}

spl_autoload_register('chargerClasse');


$perso1 = new Personnage(40, 10);
$perso2 = new Personnage(55, 17);

$perso1->frapper($perso2);
$perso2->frapper($perso1);
$perso2->frapper($perso1);
$perso1->frapper($perso2);
$perso2->frapper($perso1);



Echo "Le premier personnage " . $perso1->experience() . " expérience et " . $perso1->degats() . " dégats <BR>";
Echo "Le second personnage a " . $perso2->experience() . " expérience et " . $perso2->degats() . " dégats <BR>";



$persoA = new Personnage_v2(Personnage_v2::FORCE_GRANDE, Personnage_v2::EXPERIENCE_FAIBLE);
$persoB = new Personnage_v2(Personnage_v2::FORCE_FAIBLE, Personnage_v2::EXPERIENCE_MOYENNE);


$persoA->frapper($persoA);
$persoB->frapper($persoB);
$persoB->frapper($persoB);
$persoA->frapper($persoA);
$persoB->frapper($persoB);


Echo "Le premier personnage " . $persoA->experience() . " expérience et " . $persoA->degats() . " dégats <BR>";
Echo "Le second personnage a " . $persoB->experience() . " expérience et " . $persoB->degats() . " dégats <BR>";