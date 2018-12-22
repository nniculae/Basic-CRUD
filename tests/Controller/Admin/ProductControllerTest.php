<?php

namespace App\Tests\Controller\Admin;

use App\Entity\Product;
use App\Tests\Controller\WebTestCaseBase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCaseBase
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
        yield ['GET', '/admin/product'];
        yield ['GET', '/admin/product/1'];
        yield ['GET', '/admin/product/edit/1'];
        yield ['GET', '/admin/product/delete/1'];
    }

    public function testAdminBackendProductListPage(): void
    {
        $crawler = $this->client->request('GET', '/admin/product');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThanOrEqual(
            1,
            $crawler->filter('body table#products tbody tr')->count(),
            'The backend product page displays all the available categories.'
        );
    }

    public function testAdminNewProduct(): void
    {
        $productName = 'Fender';
        $crawler = $this->client->request('GET', '/admin/product/new');
        $form = $crawler->filter('#product_save')->form([
            'product[name]' => $productName,
            'product[price]' => 234,
            'product[description]' => 'A very good guitar',
            'product[category]' => 1
        ]);
        $this->client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $product = $this->client->getContainer()->get('doctrine')->getRepository(Product::class)->findOneBy([
            'name' => $productName,
        ]);
        $this->assertNotNull($product);
        $this->assertSame($productName, $product->getName());
    }

    public function testAdminShowProduct(): void
    {
        $this->client->request('GET', '/admin/product/1');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEditProduct(): void
    {
        $productName = "Fender";
        $crawler = $this->client->request('GET', '/admin/product/edit/1');
//        $form = $crawler->filter('#product_save')->form([
//            'product[name]' => $productName,
//            'product[price]' => 234,
//            'product[description]' => 'A very good guitar',
//            'product[category]' => 1
//        ]);
        $form = $crawler->selectButton('product_save')->form([
            'product[name]' => $productName,
            'product[price]' => 234,
            'product[description]' => 'A very good guitar',
            'product[category]' => 1
        ]);
        $this->client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        /** @var Product $product */
        $product = $this->client->getContainer()->get('doctrine')->getRepository(Product::class)->find(1);
        $this->assertSame($productName, $product->getName());
    }
    public function testAdminDeleteProduct(): void
    {
        $this->client->request('GET', '/admin/product/delete/1');
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $product = $this->client->getContainer()->get('doctrine')->getRepository(Product::class)->find(1);
        $this->assertNull($product);
        $this->assertTrue($this->client->getResponse()->isRedirect('/admin/product'));
    }
}