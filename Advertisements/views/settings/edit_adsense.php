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
			<?= T('This is also known as the Client ID.'); ?>
		</p>

		<?= $Form->TextBox('PublisherIdentifier'); ?>
	</div>

	<div class="LayoutOptions PubliserIdentifierOptions">
		<p>
			<strong>
				<?= T('Advertisement Identifier'); ?>
			</strong>
			<br />
			<?= T('This is also known as the Slot ID.'); ?>
		</p>

		<?= $Form->TextBox('AdvertisementIdentifier'); ?>
	</div>

	<div class="LayoutOptions PositionOptions">
		<p>
			<strong>
				<?= T('Position'); ?>
			</strong>
			<br />
			<?= T('Choose the position of the advertisement'); ?>
		</p>

		<?= $Form->RadioList('Target', $AvailableTargets, [ 'list' => true ]); ?>
	</div>

	<div class="LayoutOptions OrientationOptions">
		<p>
			<strong>
				<?= T('Orientation'); ?>
			</strong>
			<br />
			<?= T('Choose the orientation of the advertisement.'); ?>
			<?= T('It is recommended to leave this set to Automatic.'); ?>
		</p>

		<?= $Form->RadioList('Orientation', $AvailableOrientations, [ 'list' => true ]); ?>
	</div>

	<div class="LayoutOptions DisabledTextOptions">
		<p>
			<strong>
				<?= T('Adblocker Text'); ?>
			</strong>
			<br />
			Text to show when the user has an ad-blocker activated.
		</p>

		<?= $Form->TextBox('DisabledAdsText', [ 'Multiline' => true ]); ?>
	</div>


	<div class="LayoutOptions SizeOptions">
		<p>
			<strong>
				<?= T('Display Size'); ?>
			</strong>
			<br />
			<?= T('Size of the Advertisement'); ?>
		</p>

		<div>
			<div>
				<strong>
					<?= $Form->Label('Width'); ?>
				</strong>
			</div>

			<?= $Form->TextBox('Width', [ 'type' => 'number', 'placeholder' => T('Auto') ]); ?> px

		</div>
		<div>
			<div>
				<strong>
					<?= $Form->Label('Height'); ?>
				</strong>
			</div>
			<?= $Form->TextBox('Height', [ 'type' => 'number', 'placeholder' => T('Auto') ]); ?> px
		</div>
	</div>
</div>

<hr />

<?= $Form->Button(T('Save Advertisement'), ['class' => 'Button Submit']); ?>

<a href="<?= htmlentities($this->Data('CancelURL')); ?>" class="Button">
	Cancel
</a>

<?= $Form->Close(); ?>
