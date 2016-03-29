<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AuthorController
 */
class AuthorController extends Controller
{
    /**
     * @Route("/show")
     */
    public function showAction()
    {
        return $this->render('CoreBundle:Author:show.html.twig', array(
            // ...
        ));
    }

}
