<?php

namespace DevAlicia\ThemeConfig\Console;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DevAlicia\ThemeConfig\Model\ChangeColors;

class ColorPrimaryCommand extends Command
{

    private ChangeColors $changeColors;

    public function __construct(
        ChangeColors $changeColors
    )
    {
        $this->changeColors = $changeColors;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('color:primary')
        ->setDescription('Command to primary color')
        ->addArgument('color', InputArgument::REQUIRED, 'New color value')
        ->addArgument('store', InputArgument::OPTIONAL, 'Store to associate with the color');

        parent::configure();
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $content = $this->changeColors->changeColorPrimary($input->getArgument('color'), $input->getArgument('store'));
            if(!$content) {
                throw new Exception("A alteração de cores da classe css Primary não foi efetuada por algum erro interno.");
            }
             $output->writeln("A alteração de cores da classe css Primary foi efetuada com sucesso!" );
        } catch (Exception $e) {
            $output->writeln("Erro: $e" );
        }
       return 1;
    }

}
