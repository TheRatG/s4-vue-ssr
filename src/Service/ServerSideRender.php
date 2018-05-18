<?php

namespace App\Service;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ServerSideRender
{


    const COMPONENT_ATTR = '_component';
    /**
     * string
     */
    private $kernelProjectDir;
    /**
     * @var VersionStrategyInterface
     */
    private $versionStrategy;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var array
     */
    private $locales;

    /**
     * @var VueStateCollection
     */
    private $vueStateCollection;

    public function __construct(
        string $kernelProjectDir,
        VersionStrategyInterface $versionStrategy,
        RequestStack $requestStack,
        VueStateCollection $vueStateCollection
    ) {
        $this->kernelProjectDir = $kernelProjectDir;
        $this->versionStrategy = $versionStrategy;
        $this->requestStack = $requestStack;
        $this->vueStateCollection = $vueStateCollection;
    }

    public function render(array $state): array
    {
        $vueRenderer = file_get_contents(sprintf('%s/node_modules/vue-server-renderer/basic.js',
            $this->kernelProjectDir));
        $entryPoint = file_get_contents(
            $this->kernelProjectDir . '/public' . $this->versionStrategy->getVersion('build/js/server.js')
        );

        $ssrData = $this->prepareJsData($state);
        $ssrDataStr = $this->serializeToJson($ssrData);

        $v8 = new \V8Js('PHP', $ssrData);
        try {
            ob_start();

            $js = <<<EOT
var process = { env: { VUE_ENV: "server", NODE_ENV: "production" } }; 
this.global = { process: process, window: {} };
let PHP = $ssrDataStr;
EOT;
            $v8->executeString($js);
            $v8->executeString($vueRenderer);
            $v8->executeString($entryPoint);
            $result = ob_get_clean();
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return ['app' => $result];
    }

    protected function prepareJsData(array $state)
    {
        $result = $state;
        $result['component'] = $this->requestStack->getMasterRequest()->get(self::COMPONENT_ATTR);
        foreach ($this->vueStateCollection->getHandlers() as $handler) {
            $result = array_replace_recursive($result, $handler->getData());
        }

        return $result;
    }

    protected function serializeToJson(array $data)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($data, 'json');
    }
}