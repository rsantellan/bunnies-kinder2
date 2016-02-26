<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MigrationController extends Controller
{
    public function migrateActivityAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on migrateActivityAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->updateActivity($id);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
        
    }

    public function removeActivityAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on removeActivityAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->removeActivity($id);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
        
    }

    public function migrateDiscountAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on migrateDiscountAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->updateDiscount($id);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
        
    }
    public function removeDiscountAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on removeDiscountAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->removeDiscount($id);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
        
    }

    public function updateCostosAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on updateCostosAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->updateCostos();
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
        
    }
}
