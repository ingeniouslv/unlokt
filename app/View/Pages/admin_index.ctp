<?php
$this->set('title_for_layout', 'Page Manager');
?>
<div class="main-content page page">
	<div class="container">
		<h1>Page Manager</h1>
		<?php echo $this->Html->link(__('Add Page'), array('action' => 'add'), array('class' => 'btn')); ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('title'); ?></th>
					<th><?php echo $this->Paginator->sort('slug'); ?></th>
					<th><?php echo $this->Paginator->sort('is_published', 'Published'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($pages as $page): ?>
				<tr>
					<td class="user-name">
						<?php echo $this->Html->link(__($page['Page']['title']), array('action' => 'page', $page['Page']['slug'], 'admin' => false)); ?>
					</td>
					<td>
						<?php echo h($page['Page']['slug']); ?>
					</td>
					<td>
						<?php echo $page['Page']['is_published']?'Yes':'No'; ?>
					</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $page['Page']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $page['Page']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $page['Page']['id'])); ?>
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
				echo $this->Paginator->next(__('next') . ' ', array(), null, array('class' => 'next disabled'));
			?>
		</div>
	</div>
</div>
