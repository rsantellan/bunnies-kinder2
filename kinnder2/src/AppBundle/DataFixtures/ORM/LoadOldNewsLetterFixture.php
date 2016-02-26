<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\DataFixtures\DataFixturesConstants;
use Maith\NewsletterBundle\Entity\User;
use Maith\NewsletterBundle\Entity\Content;
use Maith\NewsletterBundle\Entity\ContentSend;
use Maith\NewsletterBundle\Entity\ContentSendUser;

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
    return;
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    $sqlUsers = 'select nu.id, nu.md_user_id, u.email, u.culture, u.id as userId from md_news_letter_user nu left join md_user u on nu.md_user_id = u.id';
    $stmtUsers = $conn->prepare($sqlUsers);
    $stmtUsers->execute();
    
    $sqlUserGroups = 'select md_newsletter_group_id, md_newsletter_user_id from md_news_letter_group_user where md_newsletter_user_id = ?';
    $stmtUserGroups = $conn->prepare($sqlUserGroups);
    
    $manager->getRepository('MaithNewsletterBundle:UserGroup')->findAll();
    $metadataUser = $manager->getClassMetaData(get_class(new User()));
    $metadataUser->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    $users = array();
    while($rowUser = $stmtUsers->fetch())
    {
        $user = new User();
        $user->setEmail($rowUser['email']);
        $user->setId($rowUser['id']);
        $stmtUserGroups->execute(array($rowUser['id']));
        while($rowUserGroup = $stmtUserGroups->fetch())
        {
          $user->addUserGroup($manager->getRepository('MaithNewsletterBundle:UserGroup')->find($rowUserGroup['md_newsletter_group_id']));
        }
        
        $manager->persist($user);
        $users[$rowUser['id']] = $user;
        
        $progenitor = $manager->getRepository('AppBundle:Progenitor')->findOneBy(array('email' => trim($rowUser['email'])));
        $progenitor->setNewsletterUser($user);
        $manager->persist($progenitor);
    }
    
    $metadataContent = $manager->getClassMetaData(get_class(new Content()));
    $metadataContent->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    $sqlNewsletterContents = 'select id, subject, body, send_counter from md_newsletter_content';
    $sqlNewsLetterContentsSend = 'select id, subject, body, send_counter, sending_date, sended, for_status, md_newsletter_content_id from md_newsletter_content_sended where md_newsletter_content_id = ?';
    $sqlNewsLetterContentsSendUsers = 'select id, md_news_letter_user_id, md_newsletter_content_sended_id, sending_date from md_newsletter_send where md_newsletter_content_sended_id = ?';
    
    $stmtContents = $conn->prepare($sqlNewsletterContents);
    $stmtContentsSended = $conn->prepare($sqlNewsLetterContentsSend);
    $stmtContentsSendedUsers = $conn->prepare($sqlNewsLetterContentsSendUsers);
    
    $stmtContents->execute();
    
    while($rowContent = $stmtContents->fetch())
    {
      $contentUserSendCheck = array();
      $content = new Content();
      $content->setActive(true);
      $content->setBody($rowContent['body']);
      $content->setTitle($rowContent['subject']);
      $content->setId($rowContent['id']);
      $manager->persist($content);
      $stmtContentsSended->execute(array($rowContent['id']));
      while($rowContentSended = $stmtContentsSended->fetch())
      {
        $contentSend = new ContentSend();
        $contentSend->setActive(true);
        $contentSend->setBody($rowContentSended['body']);
        $contentSend->setContent($content);
        $contentSend->setId($rowContentSended['id']);
        $contentSend->setQuantitySended($rowContentSended['send_counter']);
        $contentSend->setSended($rowContentSended['sended']);
        $contentSend->setSendat(new \DateTime($rowContentSended['sending_date']));
        $contentSend->setTitle($rowContentSended['subject']);
        $content->addContentSend($contentSend);
        $manager->persist($contentSend);
        $manager->flush();
        $stmtContentsSendedUsers->execute(array($rowContentSended['id']));
        while($rowContentSendedUser = $stmtContentsSendedUsers->fetch())
        {
          $check = $rowContentSendedUser['md_news_letter_user_id'].'-'.$rowContentSended['id'];
          if(!isset($contentUserSendCheck[$check]))
          {
            $sendedUser = new ContentSendUser();
            $sendedUser->setActive(true);
            $sendedUser->setContent($contentSend);
            $sendedUser->setUser($users[$rowContentSendedUser['md_news_letter_user_id']]);
            $sendAt = $rowContentSended['sending_date'];
            if($sendAt)
            {
              $sendedUser->setSendat(new \DateTime($sendAt));
            }
            $manager->persist($sendedUser);
            $contentUserSendCheck[$check] = $check;
          }
        }
      }
      $manager->persist($content);
    }
    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

