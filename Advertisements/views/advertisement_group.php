<?php if(!defined('APPLICATION')) exit(); ?>

<div class="PluginAdvertisementsContainer">
	<?php foreach ($Advertisements as $Advertisement): ?>
		<div class="PluginAdvertisement">
			<?= $Advertisement->GetHTML(); ?>
		</div>
	<?php endforeach; ?>
</div>
