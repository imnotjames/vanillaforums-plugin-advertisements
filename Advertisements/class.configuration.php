<?php if(!defined('APPLICATION')) exit();

class AdvertisementsPlugin_Configuration {
	const NETWORK_ADSENSE = 'AdvertisementsPlugin_Networks_Adsense';

	const ORIENTATION_AUTOMATIC = 'automatic';
	const ORIENTATION_VERTICAL = 'vertical';
	const ORIENTATION_HORIZONTAL = 'horizontal';
	const ORIENTATION_OTHER = 'other';

	const TARGET_NONE = 'none';

	const TARGET_SCRIPT_HEAD = 'Asset.Head.After';

	const TARGET_DISCUSSION_AFTER = 'Discussion.After';

	const TARGET_ASSET_COMMENT_BEFORE = 'Comment.Before';
	const TARGET_ASSET_COMMENT_AFTER = 'Comment.After';

	const TARGET_ASSET_CONTENT_BEFORE = 'Asset.Content.Before';
	const TARGET_ASSET_CONTENT_AFTER = 'Asset.Content.After';
	const TARGET_ASSET_PANEL_BEFORE = 'Asset.Panel.Before';
	const TARGET_ASSET_PANEL_AFTER = 'Asset.Panel.After';
	const TARGET_ASSET_FOOTER_BEFORE = 'Asset.Foot.Before';
	const TARGET_ASSET_FOOTER_AFTER = 'Asset.Foot.After';

	private $ID;

	private $AdNetwork;

	private $Target = self::TARGET_NONE;

	private $PublisherIdentifier;

	private $AdvertisementIdentifier;

	private $Orientation = self::ORIENTATION_AUTOMATIC;

	private $DisabledAdsText;

	private $Width;

	private $Height;

	public function __construct($AdNetwork, $ID = null) {
		$this->AdNetwork = $AdNetwork;
		$this->ID = $ID;
	}

	public function GetAdNetwork() {
		return $this->AdNetwork;
	}

	public function GetID() {
		return $this->ID;
	}

	public function SetID($ID) {
		$this->ID = $ID;
	}

	public function IsVisible() {
		return $this->Target !== self::TARGET_NONE;
	}

	public function GetTarget() {
		return $this->Target;
	}

	public function SetTarget($Target) {
		$this->Target = $Target;
	}

	public function GetPublisherIdentifier() {
		return $this->PublisherIdentifier;
	}

	public function SetPublisherIdentifier($PublisherIdentifier) {
		$this->PublisherIdentifier = $PublisherIdentifier;
	}

	public function GetAdvertisementIdentifier() {
		return $this->AdvertisementIdentifier;
	}

	public function SetAdvertisementIdentifier($AdvertisementIdentifier) {
		$this->AdvertisementIdentifier = $AdvertisementIdentifier;
	}

	public function GetDisabledAdsText() {
		return $this->DisabledAdsText;
	}

	public function SetDisabledAdsText($DisabledAdsText) {
		$this->DisabledAdsText = $DisabledAdsText;
	}

	public function GetOrientation() {
		return $this->Orientation;
	}

	public function SetOrientation($Orientation) {
		if (!in_array($Orientation, [ self::ORIENTATION_VERTICAL, self::ORIENTATION_HORIZONTAL, self::ORIENTATION_OTHER ])) {
			$Orientation = self::ORIENTATION_AUTOMATIC;
		}

		$this->Orientation = $Orientation;
	}

	public function IsAutomaticOrientation() {
		return $this->Orientation === self::ORIENTATION_AUTOMATIC;
	}

	public function GetWidth() {
		return $this->Width;
	}

	public function SetWidth($Width) {
		$Width = intval($Width);

		$this->Width = $Width < 0 ? 0 : $Width;
	}

	public function GetHeight() {
		return $this->Height;
	}

	public function SetHeight($Height) {
		$Height = intval($Height);

		$this->Height = $Height < 0 ? 0 : $Height;
	}
}
