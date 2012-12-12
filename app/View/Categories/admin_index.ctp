<?php
$this->set('title_for_layout', 'Managing Categories');
?>
<div class="main-content page category">
	<div class="container">
		<h1>Category Manager</h1>
		<?php echo $this->Html->link(__('Add Category'), array('action' => 'add'), array('class' => 'btn')); ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('parent_id'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($categories as $category): ?>
				<tr>
					<td class="category-name">
						<?php echo $this->Html->link(__($category['Category']['name']), array('action' => 'view', $category['Category']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($category['ParentCategory']['name'], array('controller' => 'categories', 'action' => 'view', $category['ParentCategory']['id'])); ?>
					</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $category['Category']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $category['Category']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
