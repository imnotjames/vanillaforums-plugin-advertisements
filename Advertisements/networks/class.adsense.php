<?php
if(!defined('APPLICATION')) exit();

class AdvertisementsPlugin_Networks_Adsense implements AdvertisementsPlugin_Network {
	private $Configuration;

	public function __construct(AdvertisementsPlugin_Configuration $Configuration) {
		$this->Configuration = $Configuration;
	}

	public static function GetNetworkName() {
		return 'Adsense by Google';
	}

	public static function GetAvailableTargets() {
		return array(
			AdvertisementsPlugin_Configuration::TARGET_NONE,

			AdvertisementsPlugin_Configuration::TARGET_DISCUSSION_AFTER,

			AdvertisementsPlugin_Configuration::TARGET_ASSET_COMMENT_AFTER,

			AdvertisementsPlugin_Configuration::TARGET_ASSET_CONTENT_BEFORE,
			AdvertisementsPlugin_Configuration::TARGET_ASSET_CONTENT_AFTER,

			AdvertisementsPlugin_Configuration::TARGET_ASSET_PANEL_BEFORE,
			AdvertisementsPlugin_Configuration::TARGET_ASSET_PANEL_AFTER,

			AdvertisementsPlugin_Configuration::TARGET_ASSET_FOOTER_AFTER,
		);
	}

	public function GetHTML() {
		$Configuration = $this->Configuration;

		ob_start();
		require implode(
			DIRECTORY_SEPARATOR,
			array( __DIR__, '..', 'views', 'advertisements', 'adsense.php' )
		);
		return ob_get_clean();
	}
}
