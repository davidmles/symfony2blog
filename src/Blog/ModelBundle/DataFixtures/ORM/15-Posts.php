<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Author;
use Blog\ModelBundle\Entity\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures for the Post Entity
 */
class Posts extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 15;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $p1 = new Post();
        $p1->setTitle('Lorem ipsum dolor sit amet');
        $p1->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sagittis, ligula nec facilisis
        iaculis, nulla eros sodales ante, quis luctus ligula augue in lectus. Cras pharetra tempus magna eu feugiat.
        Sed tincidunt rhoncus egestas. Nam eu lacinia ex, vitae maximus odio. Nulla facilisi. Curabitur ultrices quam
        ante, eget gravida est aliquam ut. Nullam mauris sapien, vulputate id consequat sit amet, mattis ut arcu.
        Sed sodales sagittis nisl at ullamcorper.

Sed vitae semper nisi, at eleifend diam. Donec ut mauris odio. Fusce mi felis, pretium sit amet quam nec, mollis
ultrices turpis. Morbi ultrices purus luctus, bibendum dui at, rutrum massa. Sed malesuada ligula non quam convallis
volutpat. Aenean at arcu consequat, tincidunt ex a, placerat ipsum. Suspendisse potenti. Nullam sit amet pharetra
metus, eu laoreet enim. Curabitur sollicitudin elit a sodales porttitor. Donec fringilla blandit maximus. In hac
habitasse platea dictumst. Cras ut consequat ipsum. Donec faucibus ac arcu ut rutrum.');
        $p1->setAuthor($this->getAuthor($manager, 'David'));

        $p2 = new Post();
        $p2->setTitle('Donec in turpis ac dolor tempor egestas nec ac tortor');
        $p2->setBody('Donec in turpis ac dolor tempor egestas nec ac tortor. Suspendisse facilisis ipsum id neque
        efficitur sollicitudin in et nunc. Quisque posuere at ligula et tristique. Interdum et malesuada fames ac ante
        ipsum primis in faucibus. Donec tristique quam vitae nunc efficitur fringilla. Aenean eget erat sed nisl
        mattis convallis. Nam nec leo gravida, auctor metus ut, aliquam leo. Nunc nec semper urna, gravida consectetur
        ipsum. Curabitur sagittis elementum vulputate.

Aenean id commodo ligula. Nulla euismod felis a arcu facilisis, sit amet feugiat ipsum convallis. Donec ullamcorper,
orci eu egestas congue, ex ligula semper ante, eget sagittis justo quam eget velit. Ut aliquam pretium nunc, eu
aliquet leo. Donec vitae nulla lobortis est efficitur faucibus eget at urna.');
        $p2->setAuthor($this->getAuthor($manager, 'Eddie'));

        $p3 = new Post();
        $p3->setTitle('Suspendisse facilisis dapibus placerat');
        $p3->setBody('Suspendisse facilisis dapibus placerat. Sed sed tellus magna. Maecenas eget vehicula lorem, sit
        amet aliquet tortor. Morbi maximus massa sed sapien blandit semper. Ut accumsan nisl tempor, fringilla arcu et,
        vulputate ex. Pellentesque vitae iaculis odio. Mauris vitae urna commodo, elementum tellus et, porta lectus.
        Etiam finibus sit amet erat sit amet finibus.');
        $p3->setAuthor($this->getAuthor($manager, 'Eddie'));

        $manager->persist($p1);
        $manager->persist($p2);
        $manager->persist($p3);

        $manager->flush();
    }

    /**
     * Get an author
     *
     * @param ObjectManager $manager
     * @param string $name
     *
     * @return Author
     */
    private function getAuthor(ObjectManager $manager, $name)
    {
        return $manager->getRepository('ModelBundle:Author')->findOneBy(
            array(
                'name' => $name,
            )
        );
    }
}