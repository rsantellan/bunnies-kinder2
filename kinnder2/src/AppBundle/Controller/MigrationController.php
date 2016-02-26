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
    
    public function updateEstudianteAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on updateEstudianteAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->updateStudent($id);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
    }
    
    public function disableEstudianteAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on disableEstudianteAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->disableEstudiante($id);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
    }
    
    public function updateParentAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on updateParentAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->updateParent($id);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
    }
    
    public function removeParentAction($id, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on removeParentAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->removeParent($id);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
    }
    
    public function updateUserActivityAction($userId, $activityId, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on updateParentAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->updateUserActivity($userId, $activityId);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
    }
    
    public function removeUserActivityAction($userId, $activityId, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on removeParentAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->removeUserActivity($userId, $activityId);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
    }
    
    public function updateUserParentAction($userId, $parentId, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on updateParentAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->updateUserParent($userId, $parentId);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
    }
    
    public function removeUserParentAction($userId, $parentId, $hash)
    {
      $today = new \DateTime();
      if($hash != md5($today->format('Y-m-d'))){
      	$logger = $this->get('logger');
    	$logger->error('Access denied on removeParentAction');
      	$returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));
        return $returnJson;
      }	
      $migrationService = $this->get('migrations');
      $migrationService->removeUserParent($userId, $parentId);
      $returnJson = new JsonResponse();
      $returnJson->setData(array('ok' => true));
      return $returnJson;
    }
}
