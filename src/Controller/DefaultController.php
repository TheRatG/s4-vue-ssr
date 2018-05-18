<?php

namespace App\Controller;

use App\Service\Articles;
use App\Service\ServerSideRender;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route(
     *     "/",
     *     name="app.home",
     *     defaults={"_component"="IndexPage"}
     * )
     * @Template("base.html.twig")
     * @param ServerSideRender $renderer
     * @return array
     */
    public function indexAction(ServerSideRender $renderer)
    {
        return $renderer->render([
            'rand' => rand(1, 1000),
        ]);
    }

    /**
     * @Route(
     *     "/about",
     *     name="app.about",
     *     defaults={"_component"="AboutPage"}
     * )
     * @Template("base.html.twig")
     * @param ServerSideRender $renderer
     * @return array
     */
    public function aboutAction(ServerSideRender $renderer)
    {
        return $renderer->render([
            'rand' => rand(1, 1000),
        ]);
    }

    /**
     * @Route(
     *     "/article/{id}",
     *     name="app.article",
     *     requirements={"id" = "\d+"},
     *     defaults={"_component"="ArticlePage","id" = -1}
     * )
     * @Template("base.html.twig")
     * @param int $id
     * @param ServerSideRender $renderer
     * @return array
     */
    public function articleAction($id, ServerSideRender $renderer)
    {
        if ($id < 0) {
            $article = $this->get(Articles::class)->getRandom();
        } else {
            $article = $this->get(Articles::class)->getById($id);
        }
        if (!$article) {
            $this->createNotFoundException('Article not found');
        }

        return $renderer->render([
            'article' => $article,
        ]);
    }
}
