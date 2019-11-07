<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{

        //=================================================================
        // Register Plugins
        //=================================================================
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
			'RKW.RkwEcosystem',
			'Ecosystem',
			'RKW Ecosystem: Gründerökosystem'
		);

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
			'RKW.RkwEcosystem',
			'Mylist',
			'RKW Ecosystem: Meine Ökosysteme'
		);

        //=================================================================
        // Add TypoScript
        //=================================================================
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
		    $extKey,
            'Configuration/TypoScript',
            'RKW Ecosystem');

        //=================================================================
        // Add Tables
        //=================================================================
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
		    'tx_rkwecosystem_domain_model_ecosystem'
        );

		//=================================================================
		// Add Flexform
		//=================================================================
		$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));
		$pluginName = strtolower('Ecosystem');
		$pluginSignature = $extensionName . '_' . $pluginName;
		$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
		$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
		    $pluginSignature,
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/Ecosystem.xml'
        );
	},
	$_EXTKEY
);
