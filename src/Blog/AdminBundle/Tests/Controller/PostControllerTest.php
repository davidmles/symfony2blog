<?php

namespace Blog\ModelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PostControllerTest
 */
class PostControllerTest extends WebTestCase
{
    /**
     * Test Post CRUD
     */
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/post/');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Get the author value
        $authorValue = $crawler->filter('#post_author option:contains("David")')->attr('value');

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(
            array(
                'post[title]'  => 'New post',
                'post[body]'   => 'This is a new post',
                'post[author]' => $authorValue,
            )
        );

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(
            0,
            $crawler->filter('td:contains("New post")')->count(),
            'The new post is not showing up'
        );

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(
            array(
                'post[title]' => 'Updated post',
            )
        );

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Updated post"
        $this->assertGreaterThan(0, $crawler->filter('[value="Updated post"]')->count(), 'The edited post is not showing up');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Updated post/', $client->getResponse()->getContent());
    }
}
