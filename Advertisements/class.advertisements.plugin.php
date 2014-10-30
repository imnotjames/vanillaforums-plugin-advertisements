<?php if(!defined('APPLICATION')) exit();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'class.configuration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'class.repository.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'class.settingscontroller.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'class.publisher.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'networks' . DIRECTORY_SEPARATOR . 'interface.network.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'networks' . DIRECTORY_SEPARATOR . 'class.adsense.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'networks' . DIRECTORY_SEPARATOR . 'class.kontera.php';

$PluginInfo['Advertisements'] = array(
	'Name' => 'Advertisements',
	'Description' => 'Adds Advertisements to your forum',
	'Version' => '0.0.2',
	'MobileFriendly' => TRUE,
	'Author' => 'James Ward',
	'AuthorUrl' => 'https://github.com/imnotjames/vanillaforums-plugin-advertisements',
	'SettingsUrl' => '/dashboard/settings/advertisements/',
	'RequiredApplications' => array('Vanilla' => '2.1'),
);

class AdvertisementsPlugin extends Gdn_Plugin {
	const SETTINGS_URL = '/dashboard/settings/advertisements/';

	private function GetPublisherSingleton() {
		static $Publisher;

		if (empty($Publisher)) {
			$Publisher = AdvertisementsPlugin_Publisher::FromRepository(
				new AdvertisementsPlugin_Repository()
			);
		}

		return $Publisher;
	}

	public function Base_AfterDiscussion_Handler($Sender) {
		$this->PublishAdvertisements($Sender, 'Discussion.After');
	}

	public function Base_BeforeCommentDisplay_Handler($Sender) {
		$this->PublishAdvertisements($Sender, 'Comment.Before');
	}

	public function Base_AfterComment_Handler($Sender) {
		$this->PublishAdvertisements($Sender, 'Comment.After');
	}

	public function Base_BeforeRenderAsset_Handler($Sender, $Arguments) {
		$this->PublishAdvertisements($Sender, sprintf('Asset.%s.Before', $Arguments['AssetName']));
	}

	public function Base_AfterRenderAsset_Handler($Sender, $Arguments) {
		$this->PublishAdvertisements($Sender, sprintf('Asset.%s.After', $Arguments['AssetName']));
	}

	private function PublishAdvertisements(Gdn_Controller $Sender, $Channel) {
		if ($Sender->Application !== 'Vanilla') {
			return;
		}

		$Publisher = $this->GetPublisherSingleton();

		if (empty($Publisher)) {
			return;
		}

		$HTML = $Publisher->GetSubscribersHTML($Channel);

		if (!empty($HTML)) {
			echo $HTML;
		}
	}

	public function Base_GetAppSettingsMenuItems_Handler($Sender) {
		$Sender->EventArguments['SideMenu']->AddLink(
			'Forum',
			T('Advertisements'),
			self::SETTINGS_URL,
			'Garden.Settings.Manage'
		);
	}

	public function SettingsController_Advertisements_Create($Sender, $Section = null) {
		// This function will exit if the permission fails
		$Sender->Permission('Garden.Settings.Manage');

		$SettingsController = new AdvertisementsPlugin_SettingsController(
			new AdvertisementsPlugin_Repository(),
			function($View, array $Data = []) use ($Sender) {
				foreach ($Data as $Field => $Value) {
					$Sender->SetData($Field, $Value);
				}

				$Sender->AddSideMenu(self::SETTINGS_URL);

				$Sender->Render($View, '', 'plugins/Advertisements');
			}
		);

		switch (strtolower($Section)) {
			case null:
				$SettingsController->ListAdvertisements($Sender->Request);
				break;

			case 'new':
				$SettingsController->NewAdvertisement($Sender->Request);
				break;

			case 'edit':
				$ID = empty($Sender->RequestArgs[1]) ? null : $Sender->RequestArgs[1];

				$SettingsController->EditAdvertisement($Sender->Request, $ID);
				break;

			case 'delete':
				$ID = empty($Sender->RequestArgs[1]) ? null : $Sender->RequestArgs[1];

				$SettingsController->RemoveAdvertisement($Sender->Request, $ID);
				break;
			default:
				Redirect(self::SETTINGS_URL);
		}
	}
}
