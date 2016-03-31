<?php

namespace Blog\CoreBundle\Services;

use Blog\ModelBundle\Entity\Comment;
use Blog\ModelBundle\Entity\Post;
use Blog\ModelBundle\Form\CommentType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostManager
 */
class PostManager
{
    private $em;
    private $formFactory;

    /**
     * @param EntityManager        $em
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }

    /**
     * Find all posts
     *
     * @return array
     */
    public function findAll()
    {
        $posts = $this->em->getRepository('ModelBundle:Post')->findAll();

        return $posts;
    }

    /**
     * Find latest posts
     *
     * @param int $num
     *
     * @return array
     */
    public function findLatest($num)
    {
        $latestPosts = $this->em->getRepository('ModelBundle:Post')->findLatest($num);

        return $latestPosts;
    }

    /**
     * Find Post by slug
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return Post
     */
    public function findBySlug($slug)
    {
        $post = $this->em->getRepository('ModelBundle:Post')->findOneBy(
            array(
                'slug' => $slug,
            )
        );

        if (null === $post) {
            throw new NotFoundHttpException('Post was not found');
        }

        return $post;
    }

    /**
     * Create and validate a new comment
     *
     * @param Post    $post
     * @param Request $request
     *
     * @return FormInterface|boolean
     */
    public function createComment(Post $post, Request $request)
    {
        $comment = new Comment();
        $comment->setPost($post);

        $form = $this->formFactory->create(new CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($comment);
            $this->em->flush();

            return true;
        }

        return $form;
    }
}