<?php
$this->set('title_for_layout', 'Location Manager');
?>
<div class="main-content page">
	<div class="container">
		<h1>Location Manager</h1>
		<?php echo $this->Html->link('Add Location', array('action' => 'add'), array('class' => 'btn')); ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('lat', 'Latitude'); ?></th>
					<th><?php echo $this->Paginator->sort('lng', 'Longitude'); ?></th>
					<th><?php echo $this->Paginator->sort('is_active', 'Active'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($locations as $location): ?>
				<tr>
					<td class="user-name">
						<?php echo $this->Html->link($location['Location']['name'], array('action' => 'view', $location['Location']['id'])); ?>
					</td>
					<td>
						<?php echo $location['Location']['lat']; ?>
					</td>
					<td>
						<?php echo $location['Location']['lng']; ?>
					</td>
					<td>
						<?php echo ($location['Location']['is_active'])?'Yes':'No'; ?>
					</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $location['Location']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $location['Location']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $location['Location']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p>
			<?php
				echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
				));
			?>
		</p>

		<div class="paging">
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</div>
	</div>
</div>