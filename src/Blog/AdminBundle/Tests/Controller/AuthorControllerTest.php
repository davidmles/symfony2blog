<?php

namespace Blog\ModelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AuthorControllerTest
 */
class AuthorControllerTest extends WebTestCase
{
    /**
     * Test Author CRUD
     */
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/author/');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'author[name]'  => 'Someone',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(
            0,
            $crawler->filter('td:contains("Someone")')->count(),
            'The new author is not showing up'
        );

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(
            array(
                'author[name]' => 'Another one',
            )
        );

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Another one"
        $this->assertGreaterThan(0, $crawler->filter('[value="Another one"]')->count(), 'The edited author is not showing up');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been deleted on the list
        $this->assertNotRegExp('/Another one/', $client->getResponse()->getContent());
    }
}
