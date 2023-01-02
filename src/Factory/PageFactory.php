<?php

namespace App\Factory;

use App\Entity\Page;
use App\Repository\PageRepository;
use Gedmo\Sluggable\Util\Urlizer;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Page>
 *
 * @method        Page|Proxy create(array|callable $attributes = [])
 * @method static Page|Proxy createOne(array $attributes = [])
 * @method static Page|Proxy find(object|array|mixed $criteria)
 * @method static Page|Proxy findOrCreate(array $attributes)
 * @method static Page|Proxy first(string $sortedField = 'id')
 * @method static Page|Proxy last(string $sortedField = 'id')
 * @method static Page|Proxy random(array $attributes = [])
 * @method static Page|Proxy randomOrCreate(array $attributes = [])
 * @method static PageRepository|RepositoryProxy repository()
 * @method static Page[]|Proxy[] all()
 * @method static Page[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Page[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Page[]|Proxy[] findBy(array $attributes)
 * @method static Page[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Page[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class PageFactory extends ModelFactory
{
    /**
     * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     */
    protected function getDefaults(): array
    {
        $title =  preg_replace('/[^\w\s]/', '', self::faker()->text(20)); //filters out the punctuation

        return [
            'createdAt' => self::faker()->dateTime(),
            'published' => self::faker()->boolean(),
            'promoted' => self::faker()->boolean(),
            'content' => self::faker()->text(255),
            'title' => $title,
            'slug' => Urlizer::urlize($title),
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this// ->afterInstantiate(function(Page $page): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Page::class;
    }
}
