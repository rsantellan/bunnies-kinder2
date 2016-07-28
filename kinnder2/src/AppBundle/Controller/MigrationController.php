<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MigrationController extends Controller
{
    public function updateEstudianteAction($id, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on updateEstudianteAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->updateStudent($id);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function disableEstudianteAction($id, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on disableEstudianteAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->disableEstudiante($id);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function updateParentAction($id, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on updateParentAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->updateParent($id);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function removeParentAction($id, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on removeParentAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->removeParent($id);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function updateUserActivityAction($userId, $activityId, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on updateParentAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->updateUserActivity($userId, $activityId);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function removeUserActivityAction($userId, $activityId, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on removeParentAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->removeUserActivity($userId, $activityId);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function updateUserParentAction($userId, $parentId, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on updateParentAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        try {
            $migrationService->updateUserParent($userId, $parentId);
        } catch (\Exception $ex) {
            $logger = $this->get('logger');
            $logger->error($ex->getMessage());
        }

        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function removeUserParentAction($userId, $parentId, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on removeParentAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->removeUserParent($userId, $parentId);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function updatePaymentAction($paymentId, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on updatePaymentAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->updatePayment($paymentId);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }

    public function cancelBillingAction($account, $month, $year, $hash)
    {
        $today = new \DateTime();
        if ($hash != md5($today->format('Y-m-d'))) {
            $logger = $this->get('logger');
            $logger->error('Access denied on cancelPaymentAction');
            $returnJson = new JsonResponse();
            $returnJson->setData(array('ok' => true));

            return $returnJson;
        }
        $migrationService = $this->get('kinder.migrations');
        $migrationService->cancelBilling($account, $month, $year);
        $returnJson = new JsonResponse();
        $returnJson->setData(array('ok' => true));

        return $returnJson;
    }
}
