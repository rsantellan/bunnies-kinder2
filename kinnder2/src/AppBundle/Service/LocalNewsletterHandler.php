<?php

namespace AppBundle\Service;

use Maith\NewsletterBundle\Service\NewsletterHandler;

class LocalNewsletterHandler extends NewsletterHandler
{

    public function retrieveUsersToSendList($groupUsersLimit = 50)
    {
        $groupData = array('egresados' => array(), 'futuros' => array(), 'noalumnos' => array());
        $thisYear = date('Y');
        $sql = 'select e.id as e_id, e.horario_id, h.name as horario, e.clase_id, c.name as clase, e.nombre, e.apellido, e.egresado, e.anio_ingreso, p.nombre as padre, p.email as pemail, mnu.id as mnu_id, mnu.email from progenitor p left outer join estudiante_progenitor ep on ep.progenitor_id = p.id left join estudiante e on e.id = ep.estudiante_id left outer join clase c on c.id = e.clase_id left outer join horario h on h.id = e.horario_id inner join maith_newsletter_user mnu on mnu.id = p.news_letter_user_id order by p.id, e.egresado, e.anio_ingreso, h.name, c.name';
        $result = $this->em->getConnection()->executeQuery( $sql);
        while($row = $result->fetch())
        {
            if($row['e_id'] === null){
              $groupData['noalumnos'][] = array('identifier' => $row['mnu_id'], 'label' => $row['email']);
            }else{
              if((int)$row['egresado'] == 1){
                $groupData['egresados'][] = array('identifier' => $row['mnu_id'], 'label' => $row['email']);
              }else{
                if((int) $row['anio_ingreso'] <= $thisYear){
                  if(!isset($groupData[$row['horario'].' - '.$row['clase']])){
                    $groupData[$row['horario'].' - '.$row['clase']] = array();
                  }
                  $groupData[$row['horario'].' - '.$row['clase']][] = array('identifier' => $row['mnu_id'], 'label' => $row['email']);
                }else{
                  $groupData['futuros'][] = array('identifier' => $row['mnu_id'], 'label' => $row['email']);
                }
              }
            }
        }
        return $groupData;
    }

}
