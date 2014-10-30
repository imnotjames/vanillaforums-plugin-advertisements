<?php if(!defined('APPLICATION')) exit(); ?>

<?php $Width = $Configuration->GetWidth() === 0 ? 'auto' : $Configuration->GetWidth() . 'px'; ?>
<?php $Height = $Configuration->GetHeight() === 0 ? 'auto' : $Configuration->GetHeight() . 'px'; ?>
<?php $Orientations = [
	AdvertisementsPlugin_Configuration::ORIENTATION_VERTICAL => 'vertical',
	AdvertisementsPlugin_Configuration::ORIENTATION_HORIZONTAL => 'horizontal',
	AdvertisementsPlugin_Configuration::ORIENTATION_OTHER => 'square'
	];
?>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins
	class="adsbygoogle"
	style="
		display: block;
		width: <?= htmlentities($Width); ?>;
		height: <?= htmlentities($Height); ?>
		"
	data-ad-client="<?= htmlentities($Configuration->getPublisherIdentifier()); ?>"
	data-ad-slot="<?= htmlentities($Configuration->getAdvertisementIdentifier()); ?>"
	<?php if (!$Configuration->IsAutomaticOrientation()): ?>
	data-ad-format="<?= htmlentities($Orientations[$Configuration->getOrientation()]); ?>"
	<?php endif; ?>
>
	<?= $Configuration->getDisabledAdsText(); ?>
</ins>
<script>(window.adsbygoogle = window.adsbygoogle || []).push({});</script>
