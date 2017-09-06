<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 06/09/2017
 * Time: 10:10
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Author;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AuthorFixture extends  AbstractFixture implements  OrderedFixtureInterface, containerAwareInterface
{

    /**
     * @var ContainerInterface
     */
     private $container;
    /**
     * @var ContainerInterface
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $encoderFactory = $this->container->get("security.encoder_factory");
        $encoder = $encoderFactory->getEncoder(new Author());
        $password = $encoder->encodePassword("123", null);
       $author = new Author();
       $author->setName("hugo")
           ->setFirstName("Victor")
           ->setEmail("v.hogo@free.fr")
           ->setPassword($password);
       $this->addReference("auteur_1", $author);
       $manager->persist($author);

       $author = new Author();
        $author->setName("Ducasse")
            ->setFirstName("toto")
            ->setEmail("ducasse@free.fr")
            ->setPassword($password);
        $this->addReference("auteur_2", $author);
        $manager->persist($author);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}