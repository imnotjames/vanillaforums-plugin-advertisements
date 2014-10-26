<?php if(!defined('APPLICATION')) exit();

class AdvertisementsPlugin_Publisher {
	private $Subscribers = [];

	public function FromRepository(AdvertisementsPlugin_Repository $Repository) {
		$Publisher = new self();

		$Configurations = $Repository->GetAdvertisementConfigurations();

		foreach ($Configurations as $Configuration) {
			if ($Configuration->IsVisible()) {
				$Publisher->Subscribe(
					$Configuration->GetTarget(),
					$Configuration
				);
			}
		}

		return $Publisher;
	}

	public function Subscribe($Channel, AdvertisementsPlugin_Configuration $Configuration) {
		if (empty($this->Subscribers[$Channel])) {
			$this->Subscribers[$Channel] = [];
		}

		$this->Subscribers[$Channel][] = $Configuration;
	}

	public function GetSubscribers($Channel) {
		if (empty($this->Subscribers[$Channel])) {
			return [];
		}

		return $this->Subscribers[$Channel];
	}

	public function GetSubscribersHTML($Channel) {
		$Configurations = $this->GetSubscribers($Channel);

		if (empty($Configurations)) {
			return null;
		}

		$Advertisements = [];

		foreach ($Configurations as $Configuration) {
			if (empty($Configuration)) {
				continue;
			}

			if (!class_exists($Configuration->GetAdNetwork())) {
				continue;
			}

			$ConfigurationClass = $Configuration->GetAdNetwork();

			$Advertisements[] = new $ConfigurationClass($Configuration);
		}

		// Unset temporary variables here so they aren't loaded into the upcoming require
		unset($Configuration);
		unset($ConfigurationClass);

		ob_start();
		require implode(
			DIRECTORY_SEPARATOR,
			[__DIR__, 'views', 'advertisement_group.php']
		);
		return ob_get_clean();
	}
}
