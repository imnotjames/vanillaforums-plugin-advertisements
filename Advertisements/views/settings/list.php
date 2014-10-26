<?php if (!defined('APPLICATION')) exit(); ?>

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
		<?php if (empty($this->Data('Configurations'))): ?>
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
		<?php foreach ($this->Data('Configurations') as $Configuration): ?>
			<?php $AdvertisementNetworkClass = $Configuration->GetAdNetwork(); ?>
			<tr>
				<td>
					<a href="<?= htmlentities(sprintf($this->Data('EditURLFormat'), $Configuration->GetID())); ?>">
						<?= htmlentities(method_exists($AdvertisementNetworkClass, 'GetNetworkName') ? $AdvertisementNetworkClass::GetNetworkName() : $AdvertisementNetworkClass); ?>
					</a>
				</td>

				<td>
					<?= htmlentities($Configuration->GetTarget()); ?>
				</td>
				<td class="Right">
					<a href="<?= htmlentities(sprintf($this->Data('DeleteURLFormat'), $Configuration->GetID())); ?>" class="Button">
						<?= T('Remove'); ?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<br />

<p>
	<a href="<?= $this->Data('CreateURL'); ?>" class="Button">
		<?= T('New Advertisement'); ?>
	</a>
</p>
