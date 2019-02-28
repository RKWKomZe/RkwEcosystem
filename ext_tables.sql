#
# Table structure for table 'tx_rkwecosystem_domain_model_ecosystem'
#
CREATE TABLE tx_rkwecosystem_domain_model_ecosystem (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

    title varchar(255) DEFAULT '' NOT NULL,
    title_alt varchar(255) DEFAULT '' NOT NULL,
	education text NOT NULL,
	politics text NOT NULL,
	end_customer text NOT NULL,
	potential_founder text NOT NULL,
	inspiration text NOT NULL,
	start_ups text NOT NULL,
	trend text NOT NULL,
	demand_for_solution text NOT NULL,
	company text NOT NULL,
	assistance text NOT NULL,
	business_customer text NOT NULL,
	remark text NOT NULL,
	frontend_user int(11) unsigned DEFAULT '0',
	education_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	politics_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	end_customer_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	potential_founder_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	inspiration_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	start_ups_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	trend_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	demand_for_solution_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	company_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	assistance_value tinyint(4) unsigned DEFAULT '0' NOT NULL,
	business_customer_value tinyint(4) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);
