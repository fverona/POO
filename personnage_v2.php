<?php


class Personnage_v2
{

  private $_force;
  private $_experience;
  private $_degats=0;

  const FORCE_FAIBLE  = 10; 
  const FORCE_MOYENNE = 50; 
  const FORCE_GRANDE  = 100; 

  const EXPERIENCE_FAIBLE  = 10; 
  const EXPERIENCE_MOYENNE = 50; 
  const EXPERIENCE_GRANDE  = 100; 


    public function __construct($force, $experience)
    {
      $this->setForce($force);
      $this->setExperience($experience);
      echo "<BR> Je vais tout casser ! <BR>";
    }


    public function frapper(Personnage_v2 $personnage)
    {

      $this ->_experience++;

      $personnage->_degats = $personnage->_degats + $this->_force;

    }

    public function experience()
    {

      return $this->_experience;

    }

    public function degats()
    {
      return $this->_degats;
    }

    public function setExperience($experience)
    {
      if (in_array($experience,[ self::EXPERIENCE_FAIBLE, self::EXPERIENCE_MOYENNE, self::EXPERIENCE_GRANDE ]))
      {
         $this->_experience = $experience;
      }  
    }  

    public function setForce($force)
    {
      if (in_array($force,[ self::FORCE_FAIBLE, self::FORCE_MOYENNE, self::FORCE_GRANDE ]))
      {
         $this->_force = $force;
      }
    }

}

