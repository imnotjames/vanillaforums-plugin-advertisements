<?php if(!defined('APPLICATION')) exit();

/**
 * Repository to save and retrieve Configuration objects
 */
class AdvertisementsPlugin_Repository {
	private $Save;

	private $Load;

	public function __construct($save, $load) {
		if (!is_callable($save)) {
			throw new InvalidArgumentException('$save must be an instance of callable');
		}

		if (!is_callable($load)) {
			throw new InvalidArgumentException('$load must be an instance of callable');
		}

		$this->Save = $save;
		$this->Load = $load;
	}

	/**
	 * Dehydrate a configuration to an array
	 *
	 * @param AdvertisementsPlugin_Configuration $Configuration the configuration to dehydrate
	 *
	 * @return array
	 */
	private function ToArray(AdvertisementsPlugin_Configuration $Configuration) {
		$Reflect = new ReflectionClass($Configuration);
		$Properties = $Reflect->getProperties();

		$Array = array();

		foreach ($Properties as $Property) {
			$Property->SetAccessible(true);

			$Array[$Property->GetName()] = $Property->GetValue($Configuration);
		}

		return $Array;
	}

	/**
	 * Hydrate a Configuration from an array of data
	 *
	 * @param array $Array the "serialized" array of data that make up this configuration
	 *
	 * @return AdvertisementsPlugin_Configuration
	 */
	private function FromArray(array $Array) {
		if (!isset($Array['AdNetwork']) || !isset($Array['ID'])) {
			return null;
		}

		$AdNetwork = $Array['AdNetwork'];
		$ID = $Array['ID'];

		$Configuration = new AdvertisementsPlugin_Configuration($AdNetwork, $ID);

		$Reflect = new ReflectionClass($Configuration);
		$Properties = $Reflect->getProperties();

		foreach ($Properties as $Property) {
			if (!array_key_exists($Property->GetName(), $Array)) {
				// If the array doesn't have the key at all skip this field and
				// leave it as a default
				continue;
			}

			$Property->SetAccessible(true);

			$Property->SetValue($Configuration, $Array[$Property->GetName()]);
		}

		return $Configuration;
	}

	/**
	 * Save a all of the configurations to the configuration
	 *
	 * @param array $Configurations array of AdvertisementsPlugin_Configuration objects
	 */
	private function SaveAdvertisementConfigurations(array $Configurations) {
		$ConfigurationsArray = array();

		foreach ($Configurations as $Configuration) {
			$ConfigurationsArray[] = $this->ToArray($Configuration);
		}

		$Save = $this->Save;
		$Save($ConfigurationsArray);
	}

	public function GetAdvertisementConfigurations() {
		$Load = $this->Load;

		$ConfigurationsArray = $Load();

		$Configurations = array();

		foreach ($ConfigurationsArray as $ConfigurationArray) {
			if (!is_array($ConfigurationArray)) {
				// Bad config option somehow..
				continue;
			}

			$Configurations[] = $this->FromArray($ConfigurationArray);
		}

		$Configurations = array_filter($Configurations);

		return $Configurations;
	}

	public function SaveAdvertisementConfiguration(AdvertisementsPlugin_Configuration $Configuration) {
		$Configurations = $this->GetAdvertisementConfigurations();

		$ID = $Configuration->GetID();

		if (empty($ID)) {
			$ID = array_reduce(
				$Configurations,
				function ($Memo, $Configuration) {
					if ($Configuration->GetID() > $Memo) {
						return $Configuration->GetID();
					}

					return $Memo;
				},
				0
			) + 1;

			$Configuration->SetID($ID);

			$Index = false;
		} else {
			$ConfigurationIDs = array_map(
				function ($C) {
					return $C->GetID();
				},
				$Configurations
			);

			$Index = array_search($Configuration->GetID(), $ConfigurationIDs);
		}

		if ($Index === false) {
			$Index = count($Configurations) + 1;
		}

		$Configurations[$Index] = $Configuration;

		$this->SaveAdvertisementConfigurations($Configurations);

		return $ID;
	}

	public function GetAdvertisementConfiguration($ID) {
		$Configurations = $this->GetAdvertisementConfigurations();

		$ConfigurationIDs = array_map(
			function ($C) {
				return $C->GetID();
			},
			$Configurations
		);

		$Index = array_search($ID, $ConfigurationIDs);

		if ($Index === false) {
			return null;
		}

		return $Configurations[$Index];
	}

	public function DeleteAdvertisementConfiguration(AdvertisementsPlugin_Configuration $Configuration) {
		$Configurations = $this->GetAdvertisementConfigurations();

		$ConfigurationIDs = array_map(
			function ($C) {
				return $C->GetID();
			},
			$Configurations
		);

		$Index = array_search($Configuration->getID(), $ConfigurationIDs);

		if (!array_key_exists($Index, $Configurations)) {
			return;
		}

		unset($Configurations[$Index]);

		$this->SaveAdvertisementConfigurations($Configurations);
	}
}
