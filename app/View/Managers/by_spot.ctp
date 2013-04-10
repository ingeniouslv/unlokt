<?php
$this->set('title_for_layout', "Managers of '".h($spot['Spot']['name'])."'");
?>
<div class="main-content page">
	<div class="container">
		<h1>Managers of <?php echo $this->Html->link($spot['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $spot['Spot']['id'])); ?> Manager</h1>
		<?php echo $this->Html->link('Add Manager', array('action' => 'add', $spot['Spot']['id']), array('class' => 'btn')); ?>
		<div class="row">
			<div class="six columns">
				<table class="zebra">
			<thead>
				<tr>
					<th>Name</th>
					<th>Admin</th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($managers as $manager): ?>
				<tr>
					<td class="user-name">
						<?php echo $manager['User']['name']; ?>
					</td>
					<td>
						<?php echo $manager['Manager']['is_admin'] ? 'Yes': 'No'; ?>
					</td>
					<td class="actions">
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $manager['Manager']['id'], $spot['Spot']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $manager['Manager']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>
</div>