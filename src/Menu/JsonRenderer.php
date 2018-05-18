<?php


namespace App\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class JsonRenderer
 * @package App\Menu
 * @link http://web-notes.wirehopper.com/2016/10/04/knpmenu-json-renderer-to-support
 */
class JsonRenderer
{
    /**
     * @var MatcherInterface
     */
    private $matcher;

    /**
     * @var array
     */
    private $defaultOptions;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(MatcherInterface $matcher, TranslatorInterface $translator, array $defaultOptions = [])
    {
        $this->matcher = $matcher;
        $this->translator = $translator;
        $this->defaultOptions = array_merge([
            'depth' => null,
            'matchingDepth' => null,
            'currentAsLink' => true,
            'currentClass' => 'current',
            'ancestorClass' => 'current_ancestor',
            'firstClass' => 'first',
            'lastClass' => 'last',
            'compressed' => false,
            'allow_safe_labels' => false,
            'clear_matcher' => true,
            'leaf_class' => null,
            'branch_class' => null,
        ], $defaultOptions);
    }

    public function render(ItemInterface $item, array $options = [])
    {
        $options = array_merge($this->defaultOptions, $options);


        $itemIterator = new \Knp\Menu\Iterator\RecursiveItemIterator($item);

        /** @var \RecursiveIteratorIterator|MenuItem[] $iterator */
        $iterator = new \RecursiveIteratorIterator($itemIterator, \RecursiveIteratorIterator::SELF_FIRST);

        $items = [];
        foreach ($iterator as $item) {
            $label = $item->getLabel();
            if ($item->getExtra('translation_domain')) {
                $label = $this->translator->trans($label, [], $item->getExtra('translation_domain'));
            }

            $id = $item->getName();
            $parentId = $item->getParent()->getName();
            $itemData = ['id' => strtolower($item->getName()), 'name' => $label, 'uri' => $item->getUri()];
            if ($parentId !== $id) {
                $itemData['parent'] = strtolower($parentId);
            }
            $itemData['has_children'] = $item->hasChildren();
            $itemData['depth'] = $iterator->getDepth();
            $itemData['is_current'] = $this->matcher->isCurrent($item);
            $itemData['is_ancestor'] = $this->matcher->isAncestor($item);
            $itemData['extras'] = $item->getExtras();
            unset($itemData['extras']['routes']);
            unset($itemData['extras']['translation_domain']);
            $itemData['is_first'] = $item->actsLikeFirst();
            $itemData['is_last'] = $item->actsLikeLast();


            $itemData['class'] = $item->getAttribute('class') ? [$item->getAttribute('class')] : [];
            if ($itemData['is_current']) {
                $itemData['class'] = array_merge($itemData['class'], [$options['currentClass']]);
            } elseif ($itemData['is_ancestor']) {
                $itemData['class'] = array_merge($itemData['class'], [$options['ancestorClass']]);
            }
            if ($item->actsLikeFirst()) {
                $itemData['class'] = array_merge($itemData['class'], [$options['firstClass']]);
            }
            if ($item->actsLikeLast()) {
                $itemData['class'] = array_merge($itemData['class'], [$options['lastClass']]);
            }

            $itemData['attributes'] = $item->getAttributes();

            $items[] = $itemData;
        }

        if ($options['clear_matcher']) {
            $this->matcher->clear();
        }

        return $items;
    }
}