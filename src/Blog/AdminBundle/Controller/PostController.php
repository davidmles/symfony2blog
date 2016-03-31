<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blog\ModelBundle\Entity\Post;

/**
 * Post controller.
 *
 * @Route("/post")
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @return array
     *
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('ModelBundle:Post')->findAll();

        return array(
            'posts' => $posts,
        );
    }

    /**
     * Creates a new Post entity.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('Blog\ModelBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_admin_post_show', array('id' => $post->getId()));
        }

        return array(
            'post' => $post,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Post entity.
     *
     * @param Post $post
     *
     * @return array
     *
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);

        return array(
            'post'        => $post,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @param Request $request
     * @param Post    $post
     *
     * @return array
     *
     * @Route("/{id}/edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('Blog\ModelBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_admin_post_edit', array('id' => $post->getId()));
        }

        return array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Post entity.
     *
     * @param Request $request
     * @param Post    $post
     *
     * @return RedirectResponse
     *
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('blog_admin_post_index');
    }

    /**
     * Creates a form to delete a Post entity.
     *
     * @param Post $post The Post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_admin_post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
