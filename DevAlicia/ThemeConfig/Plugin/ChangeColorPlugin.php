<?php

namespace DevAlicia\ThemeConfig\Plugin;

use Magento\Config\Model\Config;
use DevAlicia\ThemeConfig\Model\ChangeColors;
use Psr\Log\LoggerInterface;

class ChangeColorPlugin
{

    private LoggerInterface $logger;
    private ChangeColors $_changeColors;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger,
        ChangeColors $changeColors
    ){
        $this->logger = $logger;
        $this->_changeColors = $changeColors;
    }

    /**
     * After save plugin
     *
     * @param Config $subject
     * @return void
     */
    public function afterSave(Config $subject): void
    {
        $configData = $subject->getData();

        $this->logger->info('Before saving config: ' . json_encode($configData));

        if (isset($configData['section']) && $configData['section'] == 'statuscolor') {
            $colorConfig = $configData['groups']['general']['fields']['primary_color']['value'];
            $content = $this->_changeColors->changeColorPrimary($colorConfig);
            if(!$content) {
                $this->logger->info('Something went wrong, verify logs.');
            }
            $this->logger->info('Custom config data is being saved.'. json_encode($content));
        }
    }
}