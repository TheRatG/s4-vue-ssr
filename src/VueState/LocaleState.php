<?php


namespace App\VueState;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;

class LocaleState implements VueStateInterface
{
    /**
     * VueTranslation constructor.
     * @param TranslatorInterface|Translator $translator
     * @param RequestStack $requestStack
     * @param array $locales
     */
    const TRANSLATION_DOMAINS = ['messages', 'menu'];
    /**
     * @var Translator|TranslatorInterface
     */
    protected $translator;
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var array
     */
    private $locales;

    public function __construct(TranslatorInterface $translator, RequestStack $requestStack, array $locales)
    {
        $this->translator = $translator;
        $this->requestStack = $requestStack;
        $this->locales = $locales;
    }

    public function getData()
    {
        $locale = $this->requestStack->getMasterRequest()->getLocale();
        $catalog = $this->translator->getCatalogue($locale);

        $result = [];
        foreach ($catalog->all() as $domain => $value) {

            if (in_array($domain, self::TRANSLATION_DOMAINS)) {
                $trans = [];
                foreach ($value as $key => $item) {
                    if (false !== strpos($key, ' ')) {
                        continue;
                    }

                    $newKey = str_replace(['.', ':'], '_', $key);
                    $trans[$newKey] = $item;
                }
                $result[$domain] = $trans;
            }
        }

        return [
            'locale' => [
                'translations' => $result,
                'locale' => $locale,
                'locales' => $this->locales
            ]
        ];
    }
}