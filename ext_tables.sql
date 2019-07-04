#
# Table structure for table 'tx_persons_domain_model_person'
#
CREATE TABLE tx_persons_domain_model_person (
	gender tinyint(4) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	first_name varchar(255) DEFAULT '' NOT NULL,
	last_name varchar(255) DEFAULT '' NOT NULL,
	position varchar(255) DEFAULT '' NOT NULL,
	birthday date,
	address text DEFAULT '' NOT NULL,
	zip varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	fax varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	www varchar(255) DEFAULT '' NOT NULL,
	short_biography text DEFAULT '' NOT NULL,
	biography text DEFAULT '' NOT NULL,
	image int(11) unsigned default '0' NOT NULL,
	content_elements int(11) unsigned default '0' NOT NULL,
	additional_images int(11) unsigned default '0' NOT NULL,
	status int(11) unsigned DEFAULT '0' NOT NULL ,
	categories int(11) UNSIGNED DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT 0 NOT NULL,
    l10n_parent int(11) unsigned DEFAULT 0 NOT NULL,

	KEY language (l10n_parent, sys_language_uid)
);


#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_persons_related_person INT(11) DEFAULT '0' NOT NULL
);
