<?php if (!defined('APPLICATION')) exit(); ?>

<?php $Form = $this->Data('Form'); ?>
<?php $Configuration = $this->Data('Configuration'); ?>
<?php $AvailableOrientations = $this->Data('AvailableOrientations'); ?>
<?php $AvailableTargets = $this->Data('AvailableTargets'); ?>

<h1>
	<?= T('Advertisements'); ?>
</h1>

<div class="Info">
	<?= T('Add Advertisements to your forum'); ?>
</div>

<h3>
	<?= T('Edit Advertisement'); ?>:
	<?php $AdvertisementNetworkClass = $Configuration->GetAdNetwork(); ?>

	<?= htmlentities(method_exists($AdvertisementNetworkClass, 'GetNetworkName') ? $AdvertisementNetworkClass::GetNetworkName() : $AdvertisementNetworkClass); ?>
</h3>

<?= $Form->Open(); ?>
<?= $Form->Errors(); ?>

<div class="Homepage">
	<div class="LayoutOptions PubliserIdentifierOptions">
		<p>
			<strong>
				<?= T('Publisher Identifier'); ?>
			</strong>
			<br />

		</p>

		<?= $Form->TextBox('PublisherIdentifier'); ?>
	</div>

	<div class="LayoutOptions PositionOptions">
		<p>
			<strong>
				<?= T('Position'); ?>
			</strong>
			<br />
			<?= T('Choose the position of the advertisement'); ?>
		</p>

		<?= $Form->RadioList('Target', $AvailableTargets, array( 'list' => true )); ?>
	</div>
</div>

<hr />

<?= $Form->Button(T('Save Advertisement'), array( 'class' => 'Button Submit' )); ?>

<a href="<?= htmlentities($this->Data('CancelURL')); ?>" class="Button">
	Cancel
</a>

<?= $Form->Close(); ?>
