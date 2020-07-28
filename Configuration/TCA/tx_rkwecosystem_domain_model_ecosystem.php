<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem',
		'label' => 'education',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => true,
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'title,title_alt,education,politics,end_customer,potential_founder,inspiration,start_ups,trend,demand_for_solution,company,assistance,business_customer,remark,frontend_user,education_value,politics_value,end_customer_value,potential_founder_value,inspiration_value,start_ups_value,trend_value,demand_for_solution_value,company_value,assistance_value,business_customer_value',
		'iconfile' => 'EXT:rkw_ecosystem/Resources/Public/Icons/tx_rkwecosystem_domain_model_ecosystem.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, title_alt, education, politics, end_customer, potential_founder, inspiration, start_ups, trend, demand_for_solution, company, assistance, business_customer, remark, frontend_user, education_value, politics_value, end_customer_value, potential_founder_value, inspiration_value, start_ups_value, trend_value, demand_for_solution_value, company_value, assistance_value, business_customer_value',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, title_alt, education, politics, end_customer, potential_founder, inspiration, start_ups, trend, demand_for_solution, company, assistance, business_customer, remark, frontend_user, education_value, politics_value, end_customer_value, potential_founder_value, inspiration_value, start_ups_value, trend_value, demand_for_solution_value, company_value, assistance_value, business_customer_value, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
	],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_rkwecosystem_domain_model_ecosystem',
				'foreign_table_where' => 'AND tx_rkwecosystem_domain_model_ecosystem.pid=###CURRENT_PID### AND tx_rkwecosystem_domain_model_ecosystem.sys_language_uid IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		't3ver_label' => [
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			],
		],
		'hidden' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
					]
				],
			],
		],
		'starttime' => [
			'exclude' => true,
			//'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 13,
				'eval' => 'datetime',
				'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
			]
		],
		'endtime' => [
			'exclude' => true,
			//'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 13,
				'eval' => 'datetime',
				'default' => 0,
				'range' => [
					'upper' => mktime(0, 0, 0, 1, 1, 2038)
				],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
			],
		],
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			),
		),
        'title_alt' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.title_alt',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required'
            ),
        ),
		'education' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.education',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'politics' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.politics',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'end_customer' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.end_customer',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'potential_founder' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.potential_founder',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'inspiration' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.inspiration',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'start_ups' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.start_ups',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'trend' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.trend',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'demand_for_solution' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.demand_for_solution',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'company' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.company',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'assistance' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.assistance',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'business_customer' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.business_customer',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'remark' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.remark',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'frontend_user' => [
			'exclude' => true,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.frontend_user',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => [
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				],
			],
		],


		'education_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.education_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'politics_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.politics_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'end_customer_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.end_customer_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'potential_founder_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.potential_founder_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'inspiration_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.inspiration_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'start_ups_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.start_ups_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'trend_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.trend_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'demand_for_solution_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.demand_for_solution_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'company_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.company_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'assistance_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.assistance_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
		'business_customer_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_ecosystem/Resources/Private/Language/locallang_db.xlf:tx_rkwecosystem_domain_model_ecosystem.business_customer_value',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim'
			),
		),
	],
];
