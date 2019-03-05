<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'RKW.RkwEcosystem',
			'Ecosystem',
			[
				'Ecosystem' => 'edit, update, reset, save, persist, print, show, expertFeedback, expertFeedbackSend, delete, open'
			],
			// non-cacheable actions
			[
				'Ecosystem' => 'edit, update, reset, save, persist, print, show, expertFeedback, expertFeedbackSend, delete, open'
			]
		);

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'RKW.RkwEcosystem',
			'Mylist',
			[
				'Ecosystem' => 'myList, delete'
			],
			// non-cacheable actions
			[
				'Ecosystem' => 'myList, delete'
			]
		);

	// wizards
    /*
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					ecosystem {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_ecosystem.svg
						title = LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkw_ecosystem_domain_model_ecosystem
						description = LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkw_ecosystem_domain_model_ecosystem.description
						tt_content_defValues {
							CType = list
							list_type = rkwecosystem_ecosystem
						}
					}
					mylist {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_mylist.svg
						title = LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkw_ecosystem_domain_model_mylist
						description = LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkw_ecosystem_domain_model_mylist.description
						tt_content_defValues {
							CType = list
							list_type = rkwecosystem_mylist
						}
					}
				}
				show = *
			}
	   }'
	);
    */
	},
	$_EXTKEY
);


// set logger
$GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwEcosystem']['writerConfiguration'] = array(

    // configuration for WARNING severity, including all
    // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
    \TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(
        // add a FileWriter
        'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
            // configuration for the writer
            'logFile' => 'typo3temp/logs/tx_rkwecosystem.log'
        )
    ),
);