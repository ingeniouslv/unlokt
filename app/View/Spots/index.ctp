<?php
$this->set('title_for_layout', 'Spot Manager');
?>

<div class="main-content page spot">
	<div class="container">
		<div class="row">
			<div class="eight columns">
				<h1>Spots Manager</h1>
				<table class="zebra">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('name', 'Spot Name'); ?></th>
							<th class="actions">Actions</th>
						</tr>
					</thead>
		
					<tbody>
						<?php foreach ($spots as $spot): ?>
						<tr>
							<td class="spot-name"><?php echo $this->Html->link(__($spot['Spot']['name']), array('action' => 'view', $spot['Spot']['id'], 'admin' => false)); ?></td>
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $spot['Spot']['id'], "admin" => false), array('class' => 'btn')); ?>
								<?php echo $this->Html->link('Managers', array('controller'=>'managers', 'action'=>'by_spot', $spot['Spot']['id']), array('class' => 'btn')); ?>
								<?php echo $this->Html->link('Manage Payments', array('controller' => 'payments', 'action' => 'method', $spot['Spot']['id'], "admin" => false), array('class' => 'btn')); ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>