<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/** Newsletter includes **/

use Maith\NewsletterBundle\Entity\User;
use Maith\NewsletterBundle\Entity\UserGroup;

class ReactNewsletterController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:ReactNewsletter:index.html.twig', array(
                // ...
            ));
    }

    public function userCounterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quantitySql = "select count(id) as quantity from maith_newsletter_user where active = 1";
        $stmt = $em->getConnection()->executeQuery($quantitySql);
        $row = $stmt->fetch();
        $quantity = $row['quantity'];

        $response = new JsonResponse();
        $response->setData(array(
            'quantity' => $quantity,
        ));

        return $response;
    }

    public function userAddAction(Request $request)
    {
        $email = $request->request->get('user_email');
        $user = new User();
        $user->setEmail($email);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);
        $errorMessage = '';
        $valid = false;
        $responseData = array(
            'message' => 'todo ok',
            'email' => $email,
            'errorMessage' => $errorMessage,
        );
        if (count($errors) > 0) {
            $responseData['message'] = (string) $errors;
        }else{
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $responseData['message'] = 'Datos guardados con exito';
                $valid = true;
            }catch(\Exception $e)
            {
                $responseData['message'] = 'No se pudo ingresar el email. Revisa que no este ingresado.';
                $logger = $this->get('logger');
                $logger->error($e);
                //throw $e;
            }
        }
        $responseData['result'] = $valid;
        $response = new JsonResponse();
        $response->setData($responseData);

        return $response;
    }

    public function searchListUsersAction(Request $request)
    {
        $search = $request->get('search');
        $term = '%'.$search.'%';
        $em = $this->getDoctrine()->getManager();
        $usersSearchSql = "select id, email, active from maith_newsletter_user where email LIKE ? order by email";
        $results = $em->getConnection()->executeQuery( $usersSearchSql, array($term), array(\PDO::PARAM_STR) );
        // Add the data queried from database
        $list = array();
        while( $row = $results->fetch() )
        {
            $list[] = array('id' => $row['id'], 'email' => $row['email'], 'active' => $row['active']);
        }
        $response = new JsonResponse();
        $response->setData($list);

        return $response;
    }

    public function removeListUserAction(Request $request){
        $userId = $request->request->get('id');
        $responseData = array(
            'message' => 'No existe el usuario.',
        );
        $valid = false;
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Estudiante')->find($userId);

        if ($entity) {
            try{
                $em->remove($entity);
                //$em->flush();
                $valid = true;
                $responseData['message'] = 'Usuario borrado correctamente';
            }catch(\Exception $e){
                $responseData['message'] = 'Error al borrar el usuario';
                $logger = $this->get('logger');
                $logger->error($e);
            }
        }
        $responseData['result'] = $valid;
        $response = new JsonResponse();
        $response->setData($responseData);
        return $response;
    }
    
    public function userGroupAddAction(Request $request)
    {
        $name = $request->request->get('userGroupName');
        $group = new UserGroup();
        $group->setName($name);
        // Missing validate not empty on entity.
        $validator = $this->get('validator');
        $errors = $validator->validate($group);
        $errorMessage = '';
        $valid = false;
        $responseData = array(
            'message' => 'todo ok',
            'name' => $name,
            'errorMessage' => $errorMessage,
            'item' => null,
        );
        if (count($errors) > 0) {
            $responseData['message'] = (string) $errors;
        }else{
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($group);
                $em->flush();
                $responseData['message'] = 'Datos guardados con exito';
                $valid = true;
                $responseData['item'] = array('id' => $group->getId(), 'name' => $group->getName());
            }catch(\Exception $e)
            {
                $responseData['message'] = 'No se pudo ingresar el grupo. Revisa que no este ingresado.';
                $logger = $this->get('logger');
                $logger->error($e);
                //throw $e;
            }
        }
        $responseData['result'] = $valid;
        $response = new JsonResponse();
        $response->setData($responseData);
        return $response;
    }
    
    
    public function userGroupSearchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('MaithNewsletterBundle:UserGroup')->findAll();
        $list = array();
        foreach($groups as $group)
        {
          $list[] = array('id' => $group->getId(), 'name' => $group->getName());
        }
        $response = new JsonResponse();
        $response->setData($list);

        return $response;
    }

}
