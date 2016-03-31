<?php

namespace Blog\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Test redirection to posts index
     */
    public function testIndex()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $crawler = $client->request('GET', '/admin/');

        $this->assertTrue(
            $client->getResponse()->isRedirect('/admin/post/'),
            'There was no redirection to the posts index.'
        );
    }
}
