<?php
$this->set('title_for_layout', 'Note Manager');
?>
<div class="main-content page category">
	<div class="container">
		<h1>Note Manager</h1>
		<?php if (!empty($flagged_review_count)): ?>
			<h3>** <?php echo $this->Html->link("There are $flagged_review_count flagged Notes", array('action' => 'flagged_reviews', 'admin' => true)); ?> **</h3>
		<?php endif; ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('User.name', 'User'); ?></th>
					<th><?php echo $this->Paginator->sort('Spot.name', 'Spot'); ?></th>
					<th><?php echo $this->Paginator->sort('review', 'Note'); ?></th>
					<th><?php echo $this->Paginator->sort('stars'); ?></th>
					<th><?php echo $this->Paginator->sort('ip'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($reviews as $review): ?>
				<tr>
					<td>
						<?php echo $this->Html->link(__($review['Review']['name']), array( 'action' => 'view', $review['Review']['id'], 'admin' => false)); ?>
					</td>
					<td>
						<?php echo $this->Html->link(__($review['User']['name']), array('controller' => 'users', 'action' => 'view', $review['User']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link(__($review['Spot']['name']), array('controller' => 'spots', 'action' => 'view', $review['Spot']['id'], 'admin' => false)); ?>
					</td>
					
					<td><?php echo h($review['Review']['review']); ?></td>
					<td><?php echo h($review['Review']['stars']); ?></td>
					<td><?php echo h($review['Review']['ip']); ?></td>
					<td><?php echo h($review['Review']['created']); ?></td>
					<td class="actions">
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $review['Review']['id'], 'admin' => false), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $review['Review']['id'])); ?>
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
