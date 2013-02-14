<?php
$this->set('title_for_layout', 'Feed Manager');
?>
<div class="main-content page category">
	<div class="container">
		<h1>Feed Manager</h1>

		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('Spot.name', 'Spot'); ?></th>
					<th><?php echo $this->Paginator->sort('feed'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($feeds as $feed): ?>
				<tr>
					<td>
						<?php echo $this->Html->link(__($feed['Spot']['name']), array('controller' => 'spots', 'action' => 'view', $feed['Spot']['id'], 'admin' => false)); ?>
					</td>
					<td>
						<?php echo h($feed['Feed']['feed']); ?>
					</td>
					<td>
						<?php echo h($feed['Feed']['created']); ?>
					</td>
					<td class="actions">
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $feed['Feed']['id'], 'admin' => false), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $feed['Feed']['id'])); ?>
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
