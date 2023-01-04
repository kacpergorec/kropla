<?php

namespace App\Tests\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PageRepository $repository;
    private string $path = '/admin/page/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Page::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Page index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'page[title]' => 'Testing',
            'page[content]' => 'Testing',
            'page[redirectUrl]' => 'Testing',
            'page[slug]' => 'Testing',
            'page[promoted]' => 'Testing',
            'page[published]' => 'Testing',
            'page[createdAt]' => 'Testing',
            'page[updatedAt]' => 'Testing',
            'page[category]' => 'Testing',
            'page[author]' => 'Testing',
        ]);

        self::assertResponseRedirects('/admin/page/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Page();
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');
        $fixture->setRedirectUrl('My Title');
        $fixture->setSlug('My Title');
        $fixture->setPromoted('My Title');
        $fixture->setPublished('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setCategory('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Page');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Page();
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');
        $fixture->setRedirectUrl('My Title');
        $fixture->setSlug('My Title');
        $fixture->setPromoted('My Title');
        $fixture->setPublished('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setCategory('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'page[title]' => 'Something New',
            'page[content]' => 'Something New',
            'page[redirectUrl]' => 'Something New',
            'page[slug]' => 'Something New',
            'page[promoted]' => 'Something New',
            'page[published]' => 'Something New',
            'page[createdAt]' => 'Something New',
            'page[updatedAt]' => 'Something New',
            'page[category]' => 'Something New',
            'page[author]' => 'Something New',
        ]);

        self::assertResponseRedirects('/admin/page/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getContent());
        self::assertSame('Something New', $fixture[0]->getRedirectUrl());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getPromoted());
        self::assertSame('Something New', $fixture[0]->getPublished());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getCategory());
        self::assertSame('Something New', $fixture[0]->getAuthor());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Page();
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');
        $fixture->setRedirectUrl('My Title');
        $fixture->setSlug('My Title');
        $fixture->setPromoted('My Title');
        $fixture->setPublished('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setCategory('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/admin/page/');
    }
}
