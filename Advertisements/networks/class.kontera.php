<?php
if(!defined('APPLICATION')) exit();

class AdvertisementsPlugin_Networks_Kontera implements AdvertisementsPlugin_Network {
	private $configuration;

	public function __construct(AdvertisementsPlugin_Configuration $configuration) {
		$this->configuration = $configuration;
	}

	public static function GetNetworkName() {
		return 'Kontera';
	}

	public static function GetAvailableTargets() {
		return array(
			AdvertisementsPlugin_Configuration::TARGET_NONE,

			AdvertisementsPlugin_Configuration::TARGET_SCRIPT_HEAD
		);
	}

	public function GetHTML() {
		$configuration = $this->configuration;

		ob_start();
		require implode(
			DIRECTORY_SEPARATOR,
			array( __DIR__, '..', 'views', 'advertisements', 'kontera.php' )
		);
		return ob_get_clean();
	}
}
