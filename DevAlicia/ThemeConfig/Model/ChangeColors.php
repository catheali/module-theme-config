<?php

namespace DevAlicia\ThemeConfig\Model;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Design\Theme\ThemeProviderInterface;
use Magento\Framework\App\State\CleanupFiles;
use Magento\Framework\View\Asset\MergeService;

class ChangeColors
{

    const FILE_PATH_THEME_EXTEND = '/design/frontend/';

    const CSS_PATH_THEME_EXTEND = '/web/css/source/_extend.less';
    
	private Filesystem $_filesystem;
    
	private DirectoryList $_directoryList;
    
	private ThemeProviderInterface $_themeProvider;
    
	private $_scopeConfig;
    
	private $_storeManager;
    
	private CleanupFiles $_cleanupFiles;
    
	private MergeService $_mergeService;

    public function __construct(
        Filesystem $filesystem,
        DirectoryList $directoryList,
        ScopeConfigInterface $scopeConfig,
        ThemeProviderInterface $themeProvider,
        StoreManagerInterface $storeManager,
        CleanupFiles $cleanupFiles,
        MergeService $mergeService
    )
    {
        $this->_filesystem = $filesystem;
        $this->_scopeConfig = $scopeConfig;
        $this->_themeProvider = $themeProvider;
        $this->_directoryList = $directoryList;
        $this->_storeManager = $storeManager;
        $this->_cleanupFiles = $cleanupFiles;
        $this->_mergeService = $mergeService;
    }

    public function changeColorPrimary(string $color, $theme = null ): bool
    {
        $theme = $this->getThemeData($theme);
		$color = str_contains( $color, '#') ? $color : '#'.$color;
        $replaceValue = "@custom-color-button: $color;";
        $filePath = $this->_directoryList::APP.SELF::FILE_PATH_THEME_EXTEND.$theme['theme_path'].SELF::CSS_PATH_THEME_EXTEND;
        $absolutePath = $this->_filesystem->getDirectoryRead(DirectoryList::ROOT)->getAbsolutePath($filePath);
        $fileContents = file_get_contents($absolutePath);
        $pattern = '/@custom-color-button:.*?;/';
        if (preg_match($pattern, $fileContents)) {
            $updatedContents = preg_replace($pattern, $replaceValue, $fileContents);
            $success = file_put_contents($absolutePath, $updatedContents);
            if(!$success){
                return false;
            }
            $this->_cleanupFiles->clearMaterializedViewFiles();
            $this->_mergeService->cleanMergedJsCss();
            return true;
        }
        return false;
    }

    public function getThemeData($storeId = null)
    {
        $storeId = $storeId ?? $this->_storeManager->getStore()->getId();
        $themeId = $this->_scopeConfig->getValue(
            \Magento\Framework\View\DesignInterface::XML_PATH_THEME_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );

        $theme = $this->_themeProvider->getThemeById($themeId);

        return $theme->getData();
    }
}
