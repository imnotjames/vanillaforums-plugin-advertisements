<?php if(!defined('APPLICATION')) exit(); ?>

<?php $Width = $Configuration->GetWidth() === 0 ? 'auto' : $Configuration->GetWidth() . 'px'; ?>
<?php $Height = $Configuration->GetHeight() === 0 ? 'auto' : $Configuration->GetHeight() . 'px'; ?>
<?php $Orientations = [
	AdvertisementsPlugin_Configuration::ORIENTATION_AUTOMATIC => 'auto',
	AdvertisementsPlugin_Configuration::ORIENTATION_VERTICAL => 'vertical',
	AdvertisementsPlugin_Configuration::ORIENTATION_HORIZONTAL => 'horizontal',
	AdvertisementsPlugin_Configuration::ORIENTATION_OTHER => 'square'
	];
?>
<ins
	class="adsbygoogle"
	id="AdvertisementsPlugin-<?= intval($Configuration->GetId()); ?>"
	style="
		display: block;
		width: <?= htmlentities($Width); ?>;
		height: <?= htmlentities($Height); ?>
		"
	data-ad-client="<?= htmlentities($Configuration->getPublisherIdentifier()); ?>"
	data-ad-slot="<?= htmlentities($Configuration->getAdvertisementIdentifier()); ?>"
	data-ad-format="<?= htmlentities($Orientations[$Configuration->getOrientation()]); ?>"
>
	<?= $Configuration->getDisabledAdsText(); ?>
</ins>
<script type="text/javascript">
	(function(){
		var runAdvertisementPluginScript = function() {
			var adsenseURL = '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';

			var scripts = document.getElementsByTagName('script');

			// If we're already loading this script don't try to load it again
			for (var i = 0; i < scripts.length; i++) {
				if (scripts.src == adsenseURL) {
					return;
				}
			}

			var script = document.createElement('script');
			script.type = 'text/javascript';
			script.async = true;
			script.src = adsenseURL;
			document.getElementsByTagName('head')[0].appendChild(script);
		};

		if(window.addEventListener) {
			window.addEventListener('load', runAdvertisementPluginScript, false);
		} else {
			window.attachEvent('onload', runAdvertisementPluginScript);
		}
	})();

	(window.adsbygoogle = window.adsbygoogle || []).push({});
</script>
