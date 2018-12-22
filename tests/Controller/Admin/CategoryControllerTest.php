<?php

namespace App\Tests\Admin;

use App\Entity\Category;
use App\Tests\Controller\WebTestCaseBase;
use Symfony\Component\HttpFoundation\Response;

class CategoryControllerTest extends WebTestCaseBase
{

    /**
     * @dataProvider getUrlsForRegularUsers
     * @param string $httpMethod
     * @param string $url
     */
    public function testAccessDeniedForRegularUsers(string $httpMethod, string $url): void
    {

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'pisi@zeelandnet.nl',
            'PHP_AUTH_PW' => 'pisoi',
        ]);

        $client->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    public function getUrlsForRegularUsers(): \Generator
    {
        yield ['GET', '/admin/category'];
        yield ['GET', '/admin/category/1'];
        yield ['GET', '/admin/category/edit/1'];
        yield ['GET', '/admin/category/delete/1'];

    }

    public function testAdminBackendHomePage(): void
    {
        $crawler = $this->client->request('GET', 'admin/category');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertGreaterThanOrEqual(
            1,
            $crawler->filter('body table#categories tbody tr')->count(),
            'The backend homepage displays all the available posts.'
        );
    }

    public function testAdminNewCategory(): void
    {
        $categoryName = 'Haine';

        $crawler = $this->client->request('GET', '/admin/category/new');
        $form = $crawler->selectButton('Create')->form([
            'category[name]' => $categoryName,

        ]);
        $this->client->submit($form);

        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $cat = $this->client->getContainer()->get('doctrine')->getRepository(Category::class)->findOneBy([
            'name' => $categoryName,
        ]);
        $this->assertNotNull($cat);
        $this->assertSame($categoryName, $cat->getName());

        //  commit the changes to database; don't roll back
        //  \DAMA\DoctrineTestBundle\Doctrine\DBAL\StaticDriver::commit();
        //  die;
    }

    public function testAdminShowCategory(): void
    {
        $this->client->request('GET', '/admin/category/1');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEditCategory(): void
    {

        $categoryName = "Haine";
        $crawler = $this->client->request('GET', '/admin/category/edit/1');
        $form = $crawler->selectButton('Update')->form([
            'category[name]' => $categoryName,
        ]);
        $this->client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        /** @var Category $cat */
        $cat = $this->client->getContainer()->get('doctrine')->getRepository(Category::class)->find(1);
        $this->assertSame($categoryName, $cat->getName());
    }

    public function testAdminDeleteCategory(): void
    {
        $this->client->request('GET', '/admin/category/delete/1');
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $cat = $this->client->getContainer()->get('doctrine')->getRepository(Category::class)->find(1);
        $this->assertNull($cat);
        $this->assertTrue($this->client->getResponse()->isRedirect('/admin/category'));
    }

}
