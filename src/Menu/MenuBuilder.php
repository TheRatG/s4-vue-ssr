<?php


namespace App\Menu;

use App\Service\Articles;
use Knp\Menu\FactoryInterface;


class MenuBuilder
{
    private $factory;

    private $articles;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     * @param Articles $articles
     */
    public function __construct(FactoryInterface $factory, Articles $articles)
    {
        $this->factory = $factory;
        $this->articles = $articles;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $menu
            ->addChild('link_home', ['route' => 'app.home'])
            ->setExtra('badge', 'home')
            ->setExtra('translation_domain', 'menu');
        $page = $menu
            ->addChild('link_page', ['route' => 'app.article'])
            ->setExtra('badge', 'page')
            ->setExtra('translation_domain', 'menu');

        $items = $this->articles->getAll();
        foreach ($items as $item) {
            $page
                ->addChild($item->getTitle(),
                    [
                        'route' => 'app.article',
                        'routeParameters' => ['id' => $item->getId()]
                    ]
                )
                ->setExtra('translation_domain', false);
        }

        $menu
            ->addChild('link_about', ['route' => 'app.about', 'extras' => ['badge' => 'about']])
            ->setExtra('translation_domain', 'menu');

        return $menu;
    }
}