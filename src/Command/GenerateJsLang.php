<?php


namespace App\Command;


use App\Service\VueI18nTranslation;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateJsLang extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:generate-js-lang')
            ->setDescription('Prepare js lang data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locales = $this->getContainer()->getParameter('locales');
        $projectDir = $this->getContainer()->getParameter('kernel.project_dir');
        $langDir = '/assets/js/lang';

        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        $io->progressStart(count($locales));
        $helper = $this->getContainer()->get(VueI18nTranslation::class);
        foreach ($locales as $locale) {
            $io->progressAdvance();

            $filename = implode('', [
                $projectDir,
                $langDir,
                DIRECTORY_SEPARATOR,
                $locale,
                '.json'
            ]);
            $trans = $helper->getTranslations($locale);
            file_put_contents($filename, json_encode($trans, JSON_PRETTY_PRINT));
        }
        $io->progressFinish();
    }
}