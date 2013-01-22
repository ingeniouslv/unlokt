<?php
$this->set('title_for_layout', 'Attachment Manager');
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Attachment Manager</h1>
		<table class="zebra">
			<thead>
				<tr>
					<th>Attachment ID</th>
					<th>Image</th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($attachments as $attachment): ?>
				<tr>
					<td class="spot-name"><?php echo $attachment['Attachment']['id']; ?></td>
					<td><img src="<?php echo $this->Html->gen_path('attachment', $attachment['Attachment']['id'], 100); ?>" /></td>
					<td class="actions">
						<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $attachment['Attachment']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $attachment['Attachment']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>