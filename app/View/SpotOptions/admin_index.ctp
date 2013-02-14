<?php
$this->set('title_for_layout', 'Spot Options');
?>
<div class="main-content page plan">
	<div class="container">
		<h1>Spot Option Manager</h1>
		<?php echo $this->Html->link(__('Add Spot Option'), array('action' => 'add'), array('class' => 'btn')); ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('css_class'); ?></th>
					<th>icon</th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($spotOptions as $spotOption): ?>
				<tr>
					<td class="spot-option-name">
						<?php echo $this->Html->link($spotOption['SpotOption']['name'], array('action' => 'view', $spotOption['SpotOption']['id'])); ?>&nbsp;
					</td>
					<td><?php echo h($spotOption['SpotOption']['css_class']); ?>&nbsp;</td>
					<td><span class="<?php echo h($spotOption['SpotOption']['css_class']); ?>" />&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $spotOption['SpotOption']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $spotOption['SpotOption']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $spotOption['SpotOption']['id'])); ?>
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
