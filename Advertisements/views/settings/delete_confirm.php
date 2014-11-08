<?php if (!defined('APPLICATION')) exit(); ?>

<?php $Form = $this->Data('Form'); ?>
<?php $Configuration = $this->Data('Configuration'); ?>

<h1>
	<?= T('Advertisements'); ?>
</h1>

<div class="Info">
	<?= T('Add Advertisements to your forum'); ?>
</div>

<h3>
	<?= T('Delete Advertisement'); ?>:
	<?php $AdvertisementNetworkClass = $Configuration->GetAdNetwork(); ?>

	<?= htmlentities(method_exists($AdvertisementNetworkClass, 'GetNetworkName') ? $AdvertisementNetworkClass::GetNetworkName() : $AdvertisementNetworkClass); ?>
</h3>

<?= $Form->Open(); ?>
<?= $Form->Errors(); ?>

<div class="Homepage">
	<div class="LayoutOptions IdentifierOptions">
		<p>
			<strong>
				<?= T('Configuration Identifier'); ?>
			</strong>
		</p>

		<?= htmlentities($Configuration->GetID()); ?>
	</div>

	<div class="LayoutOptions PubliserIdentifierOptions">
		<p>
			<strong>
				<?= T('Publisher Identifier'); ?>
			</strong>
		</p>

		<?= htmlentities($Configuration->GetPublisherIdentifier()); ?>
	</div>


	<div class="LayoutOptions LocationOptions">
		<p>
			<strong>
				<?= T('Location'); ?>
			</strong>
		</p>

		<?= htmlentities($Configuration->GetTarget()); ?>
	</div>
</div>

<hr />

<?= $Form->Button(T('Remove this Advertisement'), array( 'class' => 'Button Submit' )); ?>

<a href="<?= htmlentities($this->Data('CancelURL')); ?>" class="Button">
	Cancel
</a>

<?= $Form->Close(); ?>
