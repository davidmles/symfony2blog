<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blog\ModelBundle\Entity\Author;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Author controller.
 *
 * @Route("/author")
 */
class AuthorController extends Controller
{
    /**
     * Lists all Author entities.
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

        $authors = $em->getRepository('ModelBundle:Author')->findAll();

        return array(
            'authors' => $authors,
        );
    }

    /**
     * Creates a new Author entity.
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
        $author = new Author();
        $form = $this->createForm('Blog\ModelBundle\Form\AuthorType', $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('blog_admin_author_show', array('id' => $author->getId()));
        }

        return array(
            'author' => $author,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Author entity.
     *
     * @param Author $author
     *
     * @throws NotFoundHttpException
     * @return array
     *
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Author $author)
    {
        $deleteForm = $this->createDeleteForm($author);

        return array(
            'author' => $author,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Author entity.
     *
     * @param Request $request
     * @param Author  $author
     *
     * @throws NotFoundHttpException
     * @return array
     *
     * @Route("/{id}/edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Author $author)
    {
        $deleteForm = $this->createDeleteForm($author);
        $editForm = $this->createForm('Blog\ModelBundle\Form\AuthorType', $author);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('blog_admin_author_edit', array('id' => $author->getId()));
        }

        return array(
            'author' => $author,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Author entity.
     *
     * @param Request $request
     * @param Author  $author
     *
     * @throws NotFoundHttpException
     * @return array
     *
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Author $author)
    {
        $form = $this->createDeleteForm($author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($author);
            $em->flush();
        }

        return $this->redirectToRoute('blog_admin_author_index');
    }

    /**
     * Creates a form to delete a Author entity.
     *
     * @param Author $author The Author entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Author $author)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_admin_author_delete', array('id' => $author->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
