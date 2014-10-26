<?php
if(!defined('APPLICATION')) exit();

interface AdvertisementsPlugin_Network {
	public static function GetNetworkName();

	public static function GetAvailableTargets();

	public function GetHTML();
}
