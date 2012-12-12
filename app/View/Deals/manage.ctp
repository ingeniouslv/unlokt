<?php
$this->set('title_for_layout', 'Managing Spot Specials');
?>
<div class="main-content page deal">
	<div class="container">
		<h1>Manage <?php echo $show_active?'Active':'Inactive'; ?> Specials for <?php echo $this->Html->link($spot['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $spot['Spot']['id'])); ?></h1>
		<?php echo $this->Html->link('New Spot Special', array('action' => 'add', $spot['Spot']['id']), array('class' => 'btn btn-blue')); ?>
		<?php
			if($show_active) {
				echo $this->Html->link('Show Inactive Spot Specials', array('action' => 'manage', $spot['Spot']['id'], 0), array('class' => 'btn btn-dark'));
			} else {
				echo $this->Html->link('Show Active Spot Specials', array('action' => 'manage', $spot['Spot']['id']), array('class' => 'btn btn-blue'));
			}
			
			 ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name', 'Special Name'); ?></th>
					<th><?php echo $this->Paginator->sort('active'); ?></th>
					<th><?php echo $this->Paginator->sort('public'); ?></th>
					<th><?php echo $this->Paginator->sort('keys'); ?></th>
					<th><?php echo $this->Paginator->sort('views'); ?></th>
					<th><?php echo $this->Paginator->sort('redemptions'); ?></th>
					<th><?php echo $this->Paginator->sort('completions'); ?></th>
					<th><?php echo $this->Paginator->sort('sku'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($deals as $deal): ?>
				<tr>
					<td class="deal-name">
						<?php echo $this->Html->link($deal['Deal']['name'], array('action' => 'view', $deal['Deal']['id'], 'admin' => false)); ?>
					</td>
					<td><?php echo h(($deal['Deal']['is_active']?'Yes':'No')); ?>&nbsp;</td>
					<td><?php echo h(($deal['Deal']['is_public']?'Yes':'No')); ?>&nbsp;</td>
					<td><?php echo h($deal['Deal']['keys']); ?>&nbsp;</td>
<!-- 					<td class="actions"><?php echo $this->Html->link('Statistics', array('action' => 'statistics', $deal['Deal']['id'])); ?></td> -->
					<td><?php echo h($deal['Deal']['views']); ?></td>
					<td><?php echo h($deal['Deal']['redemptions']); ?></td>
					<td><?php echo h($deal['Deal']['completions']); ?></td>
					<td><?php echo h($deal['Deal']['sku']); ?></td>
					<td class="actions">
						<?php
							if($deal['Deal']['is_active']) {
								echo $this->Form->postLink(__('Hide'), array('action' => 'toggle_is_active', $deal['Deal']['id'], 'admin' => false), array('class' => 'btn btn-red'));
							} else {
								echo $this->Form->postLink(__('Show'), array('action' => 'toggle_is_active', $deal['Deal']['id'], 'admin' => false), array('class' => 'btn btn-green'));
							}
						?>
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