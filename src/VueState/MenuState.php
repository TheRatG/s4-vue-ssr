<?php


namespace App\VueState;

use Knp\Menu\Twig\MenuExtension;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class MenuState implements VueStateInterface
{
    /**
     * @var \Twig\Environment
     */
    private $engine;

    /**
     * MenuState constructor.
     * @param \Twig\Environment $engine
     */
    public function __construct(\Twig\Environment $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @return array
     */
    public function getData()
    {
        /** @var MenuExtension $ext */
        $ext = $this->engine->getExtension(MenuExtension::class);
        $menu = $ext->render('main', [], 'json');
        return ['menu' => ['rows' => $menu]];
    }
}