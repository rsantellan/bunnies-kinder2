<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\Role;
/**
 * Description of LoadUserFixture
 *
 * @author Rodrigo Santellan
 */
class LoadUserFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function getOrder() {
        return 1;
    }

    public function load(ObjectManager $manager) {
        
        $role = new Role();
        $role->setName("ROLE_ADMIN");
        $manager->persist($role);
        
        /***
         * 
         * Newsletter roles
         * 
         */
        
        $roles_string_list = array(
            'ROLE_MANAGE_NEWSLETTER',
            'ROLE_NEWSLETTER_ADD_CONTENT',
            'ROLE_NEWSLETTER_EDIT_CONTENT',
            'ROLE_NEWSLETTER_ADD_USER',
            'ROLE_NEWSLETTER_EDIT_USER',
            'ROLE_NEWSLETTER_SEARCH_USER',
            'ROLE_NEWSLETTER_DOWNLOAD_USERS',
            'ROLE_NEWSLETTER_UPLOAD_USERS',
            'ROLE_NEWSLETTER_ADD_GROUP',
            'ROLE_NEWSLETTER_EDIT_GROUP',
            'ROLE_NEWSLETTER_REMOVE_GROUP',
            'ROLE_NEWSLETTER_CREATE_EMAIL_LAYOUT',
            'ROLE_NEWSLETTER_EDIT_EMAIL_LAYOUT',
        );
        $roles_list = array();
        foreach($roles_string_list as $name)
        {
          $r1 = new Role();
          $r1->setName($name);
          $manager->persist($r1);
          $roles_list[] = $r1;
        }
        
        
        
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername('rsantellan@gmail.com');
        $user->setEmail('rsantellan@gmail.com');
        $user->setPlainPassword('1234');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);
        $user->setNombre("Rodrigo Santellan");
        $user->addRole($role);
        foreach($roles_list as $rl)
        {
          $user->addRole($rl);
        }
        $manager->persist($user);
        
        $admin = $userManager->createUser();
        $admin->setUsername('bunnysadministrador');
        $admin->setEmail('info@bunnyskinder.com.uy');
        $admin->setPlainPassword('bunnyskinder1974');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true);
        $admin->addRole($role);
        foreach($roles_list as $rl)
        {
          $admin->addRole($rl);
        }
        $manager->persist($admin);
        
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


