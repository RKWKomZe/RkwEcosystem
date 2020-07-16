<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{
        //=================================================================
        // Configure Plugin
        //=================================================================
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


        //=================================================================
        // Configure Logger
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwEcosystem']['writerConfiguration'] = array(

            // configuration for WARNING severity, including all
            // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
            \TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(

                // add a FileWriter
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
                    // configuration for the writer
                    'logFile' => 'typo3temp/var/logs/tx_rkwecosystem.log'
                )
            ),
        );
	},
	$_EXTKEY
);

