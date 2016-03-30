<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures for the Comment Entity
 */
class Comments extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 20;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $posts = $manager->getRepository('ModelBundle:Post')->findAll();

        $comments = array(
            0 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean viverra lorem enim, sit amet viverra
            orci condimentum quis. Proin id metus est. In neque orci, aliquet consectetur consectetur a, bibendum sit
            amet lorem. Ut volutpat a risus vel molestie. Donec sit amet est augue.',
            1 => 'Integer blandit facilisis tellus in accumsan. Mauris porttitor, nisl vel commodo interdum, felis
            urna fringilla nibh, vitae elementum libero erat ut enim. Mauris porta a tortor ut suscipit.
            Sed sollicitudin neque quis tellus ullamcorper dapibus. Vivamus pretium pulvinar magna, quis imperdiet
            dolor rutrum vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
            egestas. Suspendisse in sapien posuere, consectetur sapien nec, fermentum nisi.',
            2 => ' Phasellus sit amet urna sit amet quam porttitor varius. Phasellus ut consectetur sapien. Interdum
            et malesuada fames ac ante ipsum primis in faucibus. Fusce faucibus lobortis iaculis. Curabitur rhoncus
            viverra ex vitae hendrerit. Fusce et enim ut nibh ullamcorper tristique ac et quam. Fusce nec lectus
            consequat, mollis mauris et, blandit nulla.',
        );

        $i = 0;

        foreach ($posts as $post) {
            $comment = new Comment();
            $comment->setAuthorName('Someone');
            $comment->setBody($comments[$i++]);
            $comment->setPost($post);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}