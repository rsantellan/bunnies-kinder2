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
      $newsletterGroups = $newsletterUser->getUserGroups();
      foreach($newsletterGroups as $group)
      {
        $newsletterUser->removeUserGroup($group);
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
            $newsletterUser->addUserGroup($newsLetterUserGroup);
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
                $newsletterUser->addUserGroup($newsLetterUserGroup);
              }
            }
            else
            {
              $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                  array('name' => 'PADRES')
              );
              if($newsLetterUserGroup)
              {
                $newsletterUser->addUserGroup($newsLetterUserGroup);
              }
              if($estudiante->getClase() && $estudiante->getHorario())
              {
                $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                  array('name' => $estudiante->getClase()->getName() . ' (' . $estudiante->getHorario()->getName() . ')')
                );
                $newsletterUser->addUserGroup($newsLetterUserGroup);
              }
            }
          }
          foreach($estudiante->getActividades() as $actividad)
          {
            $newsletterUser->addUserGroup($actividad->getNewsLetterGroup());
          }  
        }  
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
