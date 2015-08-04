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
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername('rsantellan@gmail.com');
        $user->setEmail('rsantellan@gmail.com');
        $user->setPlainPassword('1234');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);
        $user->setNombre("Rodrigo Santellan");
        $user->addRole($role);
        $manager->persist($user);
        
        $admin = $userManager->createUser();
        $admin->setUsername('bunnysadministrador');
        $admin->setEmail('info@bunnyskinder.com.uy');
        $admin->setPlainPassword('bunnyskinder1974');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true);
        $admin->addRole($role);
        $manager->persist($admin);
        
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


