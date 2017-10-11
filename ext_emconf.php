<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "persons".
 *
 * Auto generated 11-10-2017 11:27
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Persons',
  'description' => 'Manage persons',
  'category' => 'plugin',
  'author' => 'Dirk Wenzel',
  'author_email' => 'wenzel@cps-it.de',
  'state' => 'beta',
  'uploadfolder' => '1',
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'version' => '0.6.0',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '8.7.0-8.7.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  '_md5_values_when_last_written' => 'a:61:{s:9:"ChangeLog";s:4:"b42d";s:9:"README.md";s:4:"7b1a";s:13:"composer.json";s:4:"f35b";s:12:"ext_icon.png";s:4:"7259";s:17:"ext_localconf.php";s:4:"81db";s:14:"ext_tables.php";s:4:"0f33";s:14:"ext_tables.sql";s:4:"39b7";s:24:"ext_typoscript_setup.txt";s:4:"dbfd";s:27:"Classes/CallStaticTrait.php";s:4:"a3a6";s:39:"Classes/Controller/PersonController.php";s:4:"fcef";s:44:"Classes/Controller/PersonRepositoryTrait.php";s:4:"e3a4";s:34:"Classes/Controller/SignalTrait.php";s:4:"b020";s:32:"Classes/Domain/Model/Content.php";s:4:"7075";s:31:"Classes/Domain/Model/Person.php";s:4:"eb4b";s:44:"Classes/Domain/Model/Dto/EmConfiguration.php";s:4:"530d";s:46:"Classes/Domain/Repository/PersonRepository.php";s:4:"b340";s:32:"Classes/Service/ImageService.php";s:4:"ed02";s:37:"Classes/Slot/PersonControllerSlot.php";s:4:"e562";s:42:"Classes/Utility/EmConfigurationUtility.php";s:4:"7380";s:39:"Classes/Utility/LocalizationUtility.php";s:4:"51e3";s:33:"Classes/View/AbstractJsonView.php";s:4:"4925";s:34:"Classes/View/Person/FilterJson.php";s:4:"fa8d";s:32:"Classes/View/Person/ListJson.php";s:4:"cf1a";s:32:"Classes/View/Person/ShowJson.php";s:4:"15be";s:40:"Classes/View/Person/ShowSelectedJson.php";s:4:"2f2c";s:44:"Configuration/FlexForms/flexform_persons.xml";s:4:"1394";s:52:"Configuration/TCA/tx_persons_domain_model_person.php";s:4:"8c42";s:42:"Configuration/TCA/Overrides/tt_content.php";s:4:"9bbd";s:62:"Configuration/TCA/Overrides/tx_persons_domain_model_person.php";s:4:"0e50";s:47:"Configuration/TSconfig/ContentElementWizard.txt";s:4:"8b08";s:37:"Configuration/TypoScript/constants.ts";s:4:"3a6c";s:33:"Configuration/TypoScript/setup.ts";s:4:"43b7";s:41:"Documentation/Configuration/TypoScript.md";s:4:"3dab";s:31:"Documentation/Models/Content.md";s:4:"f705";s:30:"Documentation/Models/Person.md";s:4:"21cd";s:32:"Documentation/Plugins/Persons.md";s:4:"3f3d";s:46:"Resources/Private/Language/de.locallang_be.xlf";s:4:"b81c";s:46:"Resources/Private/Language/de.locallang_db.xlf";s:4:"83b2";s:40:"Resources/Private/Language/locallang.xlf";s:4:"443a";s:43:"Resources/Private/Language/locallang_be.xlf";s:4:"03fa";s:78:"Resources/Private/Language/locallang_csh_tx_hfmpersons_domain_model_person.xlf";s:4:"41b8";s:43:"Resources/Private/Language/locallang_db.xlf";s:4:"7334";s:38:"Resources/Private/Layouts/Default.html";s:4:"20c0";s:47:"Resources/Private/Partials/Person/ListItem.html";s:4:"16ff";s:49:"Resources/Private/Partials/Person/Properties.html";s:4:"bafb";s:46:"Resources/Private/Templates/Person/Filter.html";s:4:"b774";s:44:"Resources/Private/Templates/Person/List.html";s:4:"eb33";s:44:"Resources/Private/Templates/Person/Show.html";s:4:"a8c0";s:52:"Resources/Private/Templates/Person/ShowSelected.html";s:4:"f94d";s:39:"Resources/Public/Icons/icon-persons.png";s:4:"2444";s:39:"Resources/Public/Icons/icon-persons.svg";s:4:"0c36";s:57:"Resources/Public/Icons/tx_persons_domain_model_person.svg";s:4:"3d45";s:46:"Tests/Unit/Controller/PersonControllerTest.php";s:4:"4d1e";s:51:"Tests/Unit/Controller/PersonRepositoryTraitTest.php";s:4:"0888";s:39:"Tests/Unit/Domain/Model/ContentTest.php";s:4:"c796";s:38:"Tests/Unit/Domain/Model/PersonTest.php";s:4:"57ac";s:51:"Tests/Unit/Domain/Model/Dto/EmConfigurationTest.php";s:4:"9a1e";s:53:"Tests/Unit/Domain/Repository/PersonRepositoryTest.php";s:4:"3a2c";s:39:"Tests/Unit/Service/ImageServiceTest.php";s:4:"81ac";s:44:"Tests/Unit/Slot/PersonControllerSlotTest.php";s:4:"7f18";s:40:"Tests/Unit/View/AbstractJsonViewTest.php";s:4:"b1d8";}',
);

