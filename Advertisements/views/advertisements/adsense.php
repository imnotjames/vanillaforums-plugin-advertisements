<?php if(!defined('APPLICATION')) exit(); ?>

<?php $Width = empty($Configuration->GetWidth()) ? 'auto' : intval($Configuration->GetWidth()) . 'px'; ?>
<?php $Height = empty($Configuration->GetHeight()) ? 'auto' : intval($Configuration->GetHeight()) . 'px'; ?>

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
	data-ad-format="<?= htmlentities($Configuration->getOrientation()) ? 'vertical' : 'horizontal'; ?>"
>
	<?= $Configuration->getDisabledAdsText(); ?>
</ins>
<script>(window.adsbygoogle = window.adsbygoogle || []).push({});</script>
