<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;

use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Progenitor;


use Maith\NewsletterBundle\Entity\UserGroup;

/**
 * Description of NewsletterSyncService
 *
 * @author Rodrigo Santellan
 */
class NewsletterSyncService {
  
  protected $em;
  
  protected $logger;
  
  public function __construct(EntityManager $em, Logger $logger) {
    $this->em = $em;
    $this->logger = $logger;
    $this->logger->addDebug("Starting newsletter sync service");
  }

  public function updateOrCreateActivityGroup($name)
  {
    $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                array('name' => $name)
            );
    if(!$newsLetterUserGroup){
      $newsLetterUserGroup = new UserGroup();
      $newsLetterUserGroup->setName($name);
      $this->em->persist($newsLetterUserGroup);
      $this->em->flush();
    }
    return $newsLetterUserGroup;
  }
  
  public function updateEstudianteRelations(Estudiante $estudiante, $updateBrothers = false)
  {
    foreach($estudiante->getProgenitores() as $progenitor)
    {
      $newsletterUser = $progenitor->getNewsletterUser();
      $toRemoveGroups = array();
      $toAddGroups = array();
      $newsletterGroups = $newsletterUser->getUserGroups();
      foreach($newsletterGroups as $group)
      {
        //$newsletterUser->removeUserGroup($group);
        $toRemoveGroups[] = $group;
      }
      if($estudiante->getActive())
      {
        if($estudiante->getEgresado())
        {
          $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                  array('name' => 'EGRESADOS')
              );
          if($newsLetterUserGroup)
          {
            $toAddGroups[] = $newsLetterUserGroup;
            //$newsletterUser->addUserGroup($newsLetterUserGroup);
          }
        }
        else
        {
          if($estudiante->getAnioIngreso())
          {
            $today = new \DateTime();
            if($today->format('Y') <= $estudiante->getAnioIngreso())
            {
              $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                  array('name' => 'Futuros')
              );
              if($newsLetterUserGroup)
              {
                //$newsletterUser->addUserGroup($newsLetterUserGroup);
                $toAddGroups[] = $newsLetterUserGroup;
              }
            }
            else
            {
              $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                  array('name' => 'PADRES')
              );
              if($newsLetterUserGroup)
              {
                //$newsletterUser->addUserGroup($newsLetterUserGroup);
                $toAddGroups[] = $newsLetterUserGroup;
              }
              if($estudiante->getClase() && $estudiante->getHorario())
              {
                $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                  array('name' => $estudiante->getClase()->getName() . ' (' . $estudiante->getHorario()->getName() . ')')
                );
                //$newsletterUser->addUserGroup($newsLetterUserGroup);
                $toAddGroups[] = $newsLetterUserGroup;
              }
            }
          }
          foreach($estudiante->getActividades() as $actividad)
          {
            //$newsletterUser->addUserGroup($actividad->getNewsLetterGroup());
            $toAddGroups[] = $actividad->getNewsLetterGroup();
          }  
        }  
      }
      $dontChangeKeys = array();
      $dontAddKeys = array();
      foreach($toRemoveGroups as $keyRemove => $removeGroup)
      {
        foreach($toAddGroups as $keyAdd => $addGroup)
        {
          if($removeGroup->getId() == $addGroup->getId())
          {
            $dontChangeKeys[] = $keyRemove;
            $dontAddKeys[] = $keyAdd;
            break 1;
          }
        }
      }
      foreach($dontChangeKeys as $key)
      {
        unset($toRemoveGroups[$key]);
      }
      foreach($dontAddKeys as $key)
      {
        unset($toAddGroups[$key]);
      }
      foreach($toRemoveGroups as $group)
      {
        $newsletterUser->removeUserGroup($group);
      }
      foreach($toAddGroups as $group)
      {
        $newsletterUser->addUserGroup($group);
      }
      $this->em->persist($newsletterUser);
      $this->em->flush();
    }
    if($updateBrothers)
    {
      foreach($estudiante->getMyBrothers() as $brother)
      {
        $this->updateEstudianteRelations($brother, false);
      }  
    }
    
  }
  
}
