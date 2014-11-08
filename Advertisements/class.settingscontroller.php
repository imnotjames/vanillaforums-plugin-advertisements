<?php if(!defined('APPLICATION')) exit();

class AdvertisementsPlugin_SettingsController {
	private $Repository;
	private $Renderer;

	private $TargetDescriptions;


	public function __construct(AdvertisementsPlugin_Repository $Repository, callable $Renderer) {
		$this->Repository = $Repository;
		$this->Renderer = $Renderer;

		$this->TargetDescriptions = array(
			AdvertisementsPlugin_Configuration::TARGET_NONE =>                 T('Do Not Display'),

			AdvertisementsPlugin_Configuration::TARGET_SCRIPT_HEAD =>          T('Include in Page Scripts'),

			AdvertisementsPlugin_Configuration::TARGET_DISCUSSION_AFTER =>     T('After First Comment'),

			AdvertisementsPlugin_Configuration::TARGET_ASSET_COMMENT_BEFORE => T('Before All Comments'),
			AdvertisementsPlugin_Configuration::TARGET_ASSET_COMMENT_AFTER =>  T('After All Comments'),

			AdvertisementsPlugin_Configuration::TARGET_ASSET_CONTENT_BEFORE => T('Before Content'),
			AdvertisementsPlugin_Configuration::TARGET_ASSET_CONTENT_AFTER =>  T('After Content'),

			AdvertisementsPlugin_Configuration::TARGET_ASSET_PANEL_BEFORE =>   T('Before Side Panel'),
			AdvertisementsPlugin_Configuration::TARGET_ASSET_PANEL_AFTER =>    T('After Side Panel'),

			AdvertisementsPlugin_Configuration::TARGET_ASSET_FOOTER_AFTER =>   T('Footer'),
		);
	}

	private function Render($View, array $Data = array()) {
		$Renderer = $this->Renderer;

		return $Renderer($View, $Data);
	}

	public function ListAdvertisements(Gdn_Request $Request) {
		$Configurations = $this->Repository->GetAdvertisementConfigurations();

		$this->Render(
			'settings/list',
			array(
				'Configurations' => $Configurations,
				'TargetDescriptions' => $this->TargetDescriptions,
				'EditURLFormat' => $Request->URL(rtrim(AdvertisementsPlugin::SETTINGS_URL, '/') . '/edit/%d'),
				'DeleteURLFormat' => $Request->URL(rtrim(AdvertisementsPlugin::SETTINGS_URL, '/') . '/delete/%d'),
				'CreateURL' => $Request->URL(rtrim(AdvertisementsPlugin::SETTINGS_URL, '/') . '/new'),
			)
		);
	}

	public function NewAdvertisement(Gdn_Request $Request) {
		$Form = new Gdn_Form();

		$Networks = array(
			AdvertisementsPlugin_Configuration::NETWORK_ADSENSE => AdvertisementsPlugin_Networks_Adsense::GetNetworkName(),
			AdvertisementsPlugin_Configuration::NETWORK_KONTERA => AdvertisementsPlugin_Networks_Kontera::GetNetworkName(),
		);

		if ($Form->AuthenticatedPostBack()) {
			$Form->ValidateRule('Network', 'ValidateRequired');
			$Form->ValidateRule(
				'Network',
				array(
					'Name' => 'ValidateEnum',
					'Args' => (object) array( 'Enum' => array_keys($Networks), 'AllowNull' => true )
				),
				T('Must be a Valid Network')
			);

			$Network = $Form->GetFormValue('Network');

			if ($Form->ErrorCount() === 0) {
				$Configuration = new AdvertisementsPlugin_Configuration($Network);

				$ID = $this->Repository->SaveAdvertisementConfiguration($Configuration);

				$EditURL = sprintf(
					$Request->URL(rtrim(AdvertisementsPlugin::SETTINGS_URL, '/') . '/edit/%d'),
					$ID
				);

				Redirect($EditURL);
				return;
			}
		}

		$this->Render(
			'settings/new',
			array(
				'Form' => $Form,
				'Networks' => $Networks
			)
		);
	}

	public function EditAdvertisement(Gdn_Request $Request, $ID) {
		$Form = new Gdn_Form();

		if (empty($ID)) {
			Redirect(AdvertisementsPlugin::SETTINGS_URL);
			return;
		}

		$Configuration = $this->Repository->GetAdvertisementConfiguration($ID);

		if (empty($Configuration)) {
			Redirect(AdvertisementsPlugin::SETTINGS_URL);
			return;
		}

		$AdNetwork = $Configuration->getAdNetwork();

		$AvailableOrientations = array(
			AdvertisementsPlugin_Configuration::ORIENTATION_AUTOMATIC => T('Automatic'),
			AdvertisementsPlugin_Configuration::ORIENTATION_VERTICAL => T('Vertical'),
			AdvertisementsPlugin_Configuration::ORIENTATION_HORIZONTAL => T('Horizontal'),
			AdvertisementsPlugin_Configuration::ORIENTATION_OTHER => T('Other')
		);

		$AvailableTargets = $AdNetwork::GetAvailableTargets();

		$AvailableTargets = array_intersect_key(
			$this->TargetDescriptions,
			array_combine(
				$AvailableTargets,
				$AvailableTargets
			)
		);

		$Form->SetValue('PublisherIdentifier', $Configuration->GetPublisherIdentifier());
		$Form->SetValue('AdvertisementIdentifier', $Configuration->GetAdvertisementIdentifier());

		$Form->SetValue('Target', $Configuration->GetTarget());
		$Form->SetValue('Orientation', $Configuration->GetOrientation());

		$Form->SetValue('Width', $Configuration->GetWidth() === 0 ? '' : $Configuration->GetWidth());
		$Form->SetValue('Height', $Configuration->GetHeight() === 0 ? '' : $Configuration->getHeight());

		$Form->SetValue('DisabledAdsText', $Configuration->GetDisabledAdsText());

		if ($Form->AuthenticatedPostBack()) {
			$Form->ValidateRule('Target', 'ValidateRequired');
			$Form->ValidateRule(
				'Target',
				array(
					'Name' => 'ValidateEnum',
					'Args' => (object) array( 'Enum' => array_keys($AvailableTargets), 'AllowNull' => true )
				),
				'Must be a valid Target'
			);

			$Form->ValidateRule(
				'Orientation',
				array(
					'Name' => 'ValidateEnum',
					'Args' => (object) array( 'Enum' => array_keys($AvailableOrientations), 'AllowNull' => true )
				),
				'Must be a valid Target'
			);

			$Form->ValidateRule('Width', 'ValidateInteger');
			$Form->ValidateRule('Height', 'ValidateInteger');

			if ($Form->ErrorCount() === 0) {
				$ValidValues = array(
					'PublisherIdentifier',
					'AdvertisementIdentifier',

					'Target',
					'Orientation',

					'Width',
					'Height',

					'DisabledAdsText',
				);

				$FormValues = array_intersect_key(
					$Form->FormValues(),
					array_flip($ValidValues)
				);

				foreach ($FormValues as $Field => $Value) {
					if (method_exists($Configuration, 'Set' . $Field)) {
						$Configuration->{'Set' . $Field}($Value);
					}
				}

				$this->Repository->SaveAdvertisementConfiguration($Configuration);
			}
		}

		switch  ($AdNetwork) {
			case AdvertisementsPlugin_Configuration::NETWORK_ADSENSE:
				$View = 'settings/edit_adsense';
				break;

			case AdvertisementsPlugin_Configuration::NETWORK_KONTERA:
				$View = 'settings/edit_kontera';
				break;

			default:
				throw new Exception('Invalid type');
		}

		$this->Render(
			$View,
			array(
				'Form' => $Form,
				'Configuration' => $Configuration,
				'AvailableOrientations' => $AvailableOrientations,
				'AvailableTargets' => $AvailableTargets,
				'CancelURL' => $Request->URL(AdvertisementsPlugin::SETTINGS_URL)
			)
		);
	}

	public function RemoveAdvertisement(Gdn_Request $Request, $ID) {
		if (!empty($ID)) {
			$Configuration = $this->Repository->GetAdvertisementConfiguration($ID);
		}

		if (empty($Configuration)) {
			Redirect(AdvertisementsPlugin::SETTINGS_URL);
			return;
		}

		$Form = new Gdn_Form();

		if ($Form->AuthenticatedPostBack()) {
			$this->Repository->DeleteAdvertisementConfiguration($Configuration);

			Redirect(AdvertisementsPlugin::SETTINGS_URL);
			return;
		}

		$this->Render(
			'settings/delete_confirm',
			array(
				'Form' => $Form,
				'Configuration' => $Configuration,
				'CancelURL' => $Request->URL(AdvertisementsPlugin::SETTINGS_URL)
			)
		);
	}
}
