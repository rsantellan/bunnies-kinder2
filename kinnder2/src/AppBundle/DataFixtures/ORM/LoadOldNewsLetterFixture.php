<?php

namespace Maith\ContableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\DataFixtures\DataFixturesConstants;
use Maith\NewsletterBundle\Entity\User;

/**
 * Description of LoadOldNewsLetterFixture
 *
 * @author Rodrigo Santellan
 */
class LoadOldNewsLetterFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	return 11;
  }

  public function load(ObjectManager $manager) {
    
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    $sqlUsers = 'select nu.id, nu.md_user_id, u.email, u.culture from md_news_letter_user nu left join md_user u on nu.md_user_id = u.id';
    $stmtUsers = $conn->prepare($sqlUsers);
    $stmtUsers->execute();
    
    $sqlUserGroups = 'select md_newsletter_group_id, md_newsletter_user_id from md_news_letter_group_user where md_newsletter_user_id = ?';
    $stmtUserGroups = $conn->prepare($sqlUserGroups);
    while($rowUser = $stmtUsers->fetch())
    {
        $user = new User();
        $user->setEmail($rowUser['email']);
        $stmtUserGroups->execute(array($rowUser['id']));
        while($userGroup = $stmtUserGroups->fetch())
        {
            
        }
    }
    


    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

