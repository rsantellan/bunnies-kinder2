<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Progenitor;
use Maith\NewsletterBundle\Entity\UserGroup;

/**
 * Description of NewsletterSyncService.
 *
 * @author Rodrigo Santellan
 */
class NewsletterSyncService
{
    protected $em;

    protected $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->addDebug('Starting newsletter sync service');
    }

    public function updateOrCreateActivityGroup($name)
    {
        $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                array('name' => $name)
            );
        if (!$newsLetterUserGroup) {
            $newsLetterUserGroup = new UserGroup();
            $newsLetterUserGroup->setName($name);
            $this->em->persist($newsLetterUserGroup);
            $this->em->flush();
        }

        return $newsLetterUserGroup;
    }

    public function updateProgenitorRelations(Progenitor $progenitor)
    {
        $newsletterUser = $progenitor->getNewsletterUser();
        $toRemoveGroups = array();
        $toAddGroups = array();
        $newsletterGroups = $newsletterUser->getUserGroups();
        foreach ($newsletterGroups as $group) {
            $toRemoveGroups[$group->getId()] = $group;
        }
        foreach ($progenitor->getEstudiantes() as $estudiante) {
            $toAddGroupsAux = $this->getNewsletterGroupsOfStudent($estudiante);
            foreach ($toAddGroupsAux as $key => $value) {
                $toAddGroups[$key] = $value;
            }
        }
        $addKeys = array_keys($toAddGroups);
        foreach ($addKeys as $key) {
            if (isset($toRemoveGroups[$key])) {
                unset($toRemoveGroups[$key]);
                unset($toAddGroups[$key]);
            }
        }
        foreach ($toRemoveGroups as $group) {
            $newsletterUser->removeUserGroup($group);
        }
        foreach ($toAddGroups as $group) {
            $newsletterUser->addUserGroup($group);
        }
        $this->em->persist($newsletterUser);
        $this->em->flush();
    }

    private function getNewsletterGroupsOfStudent(Estudiante $estudiante)
    {
        $toAddGroups = array();
        if ($estudiante->getActive()) {
            if ($estudiante->getEgresado()) {
                $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                array('name' => 'EGRESADOS')
            );
                if ($newsLetterUserGroup) {
                    $toAddGroups[$newsLetterUserGroup->getId()] = $newsLetterUserGroup;
                }
            } else {
                if ($estudiante->getAnioIngreso()) {
                    $today = new \DateTime();
                    if ($today->format('Y') <= $estudiante->getAnioIngreso()) {
                        $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                array('name' => 'Futuros')
            );
                        if ($newsLetterUserGroup) {
                            $toAddGroups[$newsLetterUserGroup->getId()] = $newsLetterUserGroup;
                        }
                    } else {
                        $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                array('name' => 'PADRES')
            );
                        if ($newsLetterUserGroup) {
                            $toAddGroups[$newsLetterUserGroup->getId()] = $newsLetterUserGroup;
                        }
                        if ($estudiante->getClase() && $estudiante->getHorario()) {
                            $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                array('name' => $estudiante->getClase()->getName().' ('.$estudiante->getHorario()->getName().')')
              );
              //$newsletterUser->addUserGroup($newsLetterUserGroup);
              $toAddGroups[$newsLetterUserGroup->getId()] = $newsLetterUserGroup;
                        }
                    }
                }
                foreach ($estudiante->getActividades() as $actividad) {
                    $toAddGroups[$actividad->getNewsLetterGroup()->getId()] = $actividad->getNewsLetterGroup();
                }
            }
        }

        return $toAddGroups;
    }

    public function updateEstudianteRelations(Estudiante $estudiante, $updateBrothers = false)
    {
        foreach ($estudiante->getProgenitores() as $progenitor) {
            $newsletterUser = $progenitor->getNewsletterUser();
            $toRemoveGroups = array();
            $newsletterGroups = $newsletterUser->getUserGroups();
            foreach ($newsletterGroups as $group) {
                $toRemoveGroups[$group->getId()] = $group;
            }
            $toAddGroups = $this->getNewsletterGroupsOfStudent($estudiante);

            $addKeys = array_keys($toAddGroups);
            foreach ($addKeys as $key) {
                if (isset($toRemoveGroups[$key])) {
                    unset($toRemoveGroups[$key]);
                    unset($toAddGroups[$key]);
                }
            }
            foreach ($toRemoveGroups as $group) {
                $newsletterUser->removeUserGroup($group);
            }
            foreach ($toAddGroups as $group) {
                $newsletterUser->addUserGroup($group);
            }
            $this->em->persist($newsletterUser);
            $this->em->flush($newsletterUser);
        }
        if ($updateBrothers) {
            foreach ($estudiante->getMyBrothers() as $brother) {
                $this->updateEstudianteRelations($brother, false);
            }
        }
    }
}
