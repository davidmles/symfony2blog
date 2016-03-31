<?php

namespace Blog\CoreBundle\Services;

use Blog\ModelBundle\Entity\Author;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthorManager
 */
class AuthorManager
{
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Find Author by slug
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return Author
     */
    public function findBySlug($slug)
    {
        $author = $this->em->getRepository('ModelBundle:Author')->findOneBy(
            array(
                'slug' => $slug,
            )
        );

        if (null === $author) {
            throw new NotFoundHttpException('Author was not found');
        }

        return $author;
    }

    /**
     * Find all posts for a given author
     *
     * @param Author $author
     *
     * @return array
     */
    public function findPosts(Author $author)
    {
        $posts = $this->em->getRepository('ModelBundle:Post')->findBy(
            array(
                'author' => $author,
            )
        );

        return $posts;
    }
}