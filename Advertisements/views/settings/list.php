<?php if (!defined('APPLICATION')) exit(); ?>

<?php $Configurations = $this->Data('Configurations'); ?>
<?php $TargetDescriptions = $this->Data('TargetDescriptions'); ?>
<?php $EditURLFormat = $this->Data('EditURLFormat'); ?>
<?php $DeleteURLFormat = $this->Data('DeleteURLFormat'); ?>
<?php $CreateURL = $this->Data('CreateURL'); ?>

<h1>
	<?= T('Advertisements'); ?>
</h1>

<div class="Info">
	<?= T('Add Advertisements to your forum'); ?>
</div>

<table>
	<thead>
		<tr>
			<th>
				<?= T('Advertising Network'); ?>
			</th>
			<th>
				<?= T('Location'); ?>
			</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php if (empty($Configurations)): ?>
			<tr>
				<td colspan="2">
					<p class="Center">
						<small>
							<?= T('No Advertisement Configurations'); ?>
						</small>
					</p>
				</td>
			</tr>
		<?php endif; ?>
		<?php foreach ($Configurations as $Configuration): ?>
			<?php $AdvertisementNetworkClass = $Configuration->GetAdNetwork(); ?>
			<tr>
				<td>
					<a href="<?= htmlentities(sprintf($EditURLFormat, $Configuration->GetID())); ?>">
						<?= htmlentities(method_exists($AdvertisementNetworkClass, 'GetNetworkName') ? $AdvertisementNetworkClass::GetNetworkName() : $AdvertisementNetworkClass); ?>
					</a>
				</td>

				<td>
					<?= htmlentities(array_key_exists($Configuration->GetTarget(), $TargetDescriptions) ? $TargetDescriptions[$Configuration->GetTarget()] : $Configuration->GetTarget()); ?>
				</td>
				<td class="Right">
					<a href="<?= htmlentities(sprintf($DeleteURLFormat, $Configuration->GetID())); ?>" class="Button">
						<?= T('Remove'); ?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<br />

<p>
	<a href="<?= $CreateURL; ?>" class="Button">
		<?= T('New Advertisement'); ?>
	</a>
</p>
