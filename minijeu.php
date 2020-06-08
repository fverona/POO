<?php

function chargerClasse($classe)
{
 require $classe . '.php';
}

spl_autoload_register('chargerClasse');

session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.



if (isset($_GET['deconnexion']))
{
  session_destroy();
  header('Location:./minijeu.php');
  exit();
}



$db = new PDO('mysql:host=localhost;dbname=personnages;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$manager = new PersonnageManager($db);




if (isset($_SESSION['perso'])) // Si la session perso existe, on restaure l'objet.
{
  $perso = $_SESSION['perso'];
}

$nbcoupsmax = 6;


if (isset($_POST['nom'])  &&  isset($_POST['creer']))
{


          $perso = new Personnage([ 'nom' => $_POST['nom'], 'forcePerso' => $_POST['force'], 'niveau' => $_POST['niveau'], 'experience'  => $_POST['experience'] ]);


          if ($manager->exist($_POST['nom']) == TRUE )
          {
            $message = "Le personnage " . $_POST['nom'] . " existe déjà";
            unset($perso);
          }  
          elseif ( $manager->nomvalide($_POST['nom']) == TRUE )
          {
            $message = "Le nom saisi est invalide";
            unset($perso);
          }
          elseif ( $manager->add($perso) == TRUE )
          {
            $message = "Le personnage " . $_POST['nom'] . " a été crée";
          }    
          else
          {
            $message = "Problème pendant la création du personnage" . $_POST['nom']; 
          }
}

elseif (isset($_POST['nom'])  &&  isset($_POST['utiliser']))
{

          if ($manager->exist($_POST['nom']) == FALSE )
          {
            $message = "Le personnage " . $_POST['nom'] . " n'existe pas";
          }

          else
          {
            
            $perso = $manager->get($_POST['nom']); 
        
            $datejour=date('Y-m-j');
            
            if ( $datejour != $perso->date())
            {

             if ( $perso->degats() > 10 )   
             {
              $degats=$perso->degats() - 10;
             } 
             else
             {
              $degats = 0;
             } 

             $perso->setDegats($degats); 
             $perso->setFdate(date('Y-m-j'));
             $perso->setCoups(0);
             $manager->update($perso);
            }
          }

}  

elseif (isset($_GET['frapper']))
{

         if (!isset($perso))
         {

           $message = "Merci de choisir le personnage qui doit frapper !";
         }

 elseif ($manager->exist((int) $_GET['frapper']))
 {


        if ( $perso->coups() >= $nbcoupsmax )
        {

          $message2 = $perso->nom() . "! Vous avez utilisé tous les coups pour aujourd'hui"; 

        }  
 
        else
        {

             
             $persoafrapper = $manager->get((int) $_GET['frapper']);

             $result = $perso->frapper($persoafrapper);

             switch ($result)
             {

              case Personnage::CESTMOI : 
                $message = "Aia porc'accidente !";
                $manager->update($perso);
                $manager->update($persoafrapper);
                break;

              case Personnage::FRAPPE:
                $message = $persoafrapper->nom() . " a été frappé méchament par " . $perso->nom() . " !"; 
                $manager->update($perso);
                $manager->update($persoafrapper);
                $message2 = $perso->nom() . "! Il vous reste " . ($nbcoupsmax - $perso->coups()) . " coup(s) pour aujourd'hui"; 
                break;



              case Personnage::TUE:
                $message = $persoafrapper->nom() . " a été tué par " . $perso->nom() . " !"; 
                $manager->delete($persoafrapper);
                $message2 = $perso->nom()  .  "! Il vous reste " . ($nbcoupsmax - $perso->coups()) . " coup(s) pour aujourd'hui"; 
                break;
             } 
        }  

 } 

 else
         {

          $message = "Le personnage a frapper n'existe pas";

         } 

}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>TP : Mini jeu de combat</title>
    
    <meta charset="utf-8" />
  </head>
  <body>
    <p> Nombre de personnages crées : <?= $manager->count()?> </p>   

<?php

if (isset($message)) // On a un message à afficher ?
{
  echo '<p>', $message, '</p>'; // Si oui, on l'affiche.
}

if (isset($message2)) // On a un message à afficher ?
{
  echo '<p>', $message2, '</p>'; // Si oui, on l'affiche.
}


if (isset($perso) && !isset($_POST['creer']))
{


?>
   <p><a href="?deconnexion=1">Déconnexion</a></p>

    <fieldset>

      <legend> Mes informations </legend>

      <p>

         - Nom : <?=  htmlspecialchars($perso->nom());?> 
         - Force  : <?= $perso->forcePerso();?>
         - Niveau : <?= $perso->niveau();?>
         - Expérience : <?= $perso->experience();?>
         - Nombre de coups du jour : <?=$perso->coups();?>    
         - Nombre de coups encore disponbles : <?=$nbcoupsmax - $perso->coups();?>    
         - Dégats : <?= $perso->degats();?>
         - Date de: <?= $perso->date();?>

      </p>

    </fieldset>

  <fieldset>
    
    <legend> Qui frapper </legend>

   <?php

    $persos = $manager->getList(); 

    if (empty($persos))
    {
      $message =  "Pas de personnages à frapper";
    }

    else
    
    {
    
       foreach ($persos as $unperso)
       {
        echo '<a href="?frapper=' . $unperso->id() . '">' . htmlspecialchars($unperso->nom()) . '</a> (dégâts : ' . $unperso->degats() . ')<br />';
       }
    }
?>
  </fieldset>
<?php
}

else
{
?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>TP : Mini jeu de combat</title>
      
      <meta charset="utf-8" />
    </head>
    <body>
      <form action="" method="post">
        <p>
          Nom :   <input type="text"   name="nom"   maxlength="50" />
          Force : <input type="number" name="force" step="1" value="1" min="1" max="5"/>
          Niveau: <input type="number" name="niveau" step="1" value="1" min="1" max="5"/>
          Expérience: <input type="number" name="experience" step="1" value="0" min="0" max="100"/>
          <input type="submit" value="Créer ce personnage" name="creer" />
          <input type="submit" value="Utiliser ce personnage" name="utiliser" />
        </p>
      </form>
<?php
}
?>
  </body>
</html>

<?php
if (isset($perso)) // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
{
  $_SESSION['perso'] = $perso;
}