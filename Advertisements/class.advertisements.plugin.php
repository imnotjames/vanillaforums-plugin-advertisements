<?php if(!defined('APPLICATION')) exit();

$PluginInfo['Advertisements'] = array(
	'Name' => 'Advertisements',
	'Description' => 'Adds Advertisements to your forum',
	'Version' => '0.0.0',
	'MobileFriendly' => TRUE,
	'Author' => 'James Ward',
	'AuthorUrl' => 'https://github.com/imnotjames/vanillaforums-plugin-advertisements',
	'SettingsUrl' => '/dashboard/settings/advertisements/',
	'RequiredApplications' => array('Vanilla' => '2.1'),
);

class AdvertisementsPlugin extends Gdn_Plugin {
	const SETTINGS_URL = '/dashboard/settings/advertisements/';
}
