<?php

namespace Blog\CoreBundle\Tests\Controller;

use Blog\ModelBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PostControllerTest
 */
class PostControllerTest extends WebTestCase
{
    /**
     * Tests posts index
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');

        $this->assertCount(3, $crawler->filter('h2'), 'There should be 3 displayed posts');
    }

    /**
     * Test show post
     */
    public function testShow()
    {
        $client = static::createClient();

        /** @var Post $post */
        $post = $client->getContainer()->get('doctrine')->getManager()->getRepository('ModelBundle:Post')->findFirst();

        $crawler = $client->request('GET', '/'.$post->getSlug());

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');

        $this->assertEquals($post->getTitle(), $crawler->filter('h1')->text(), 'Invalid post title');
    }
}
