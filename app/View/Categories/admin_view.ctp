<?php
$this->set('title_for_layout', h($category['Category']['name']));
?>
<div class="main-content page category">
	<div class="container">

		<div class="row">
			<div class="nine columns">
				<div class="page-header">
					<h1 class="name"><?php echo h($category['Category']['name']); ?></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="eight columns">
				<h2>Parent Category</h2>
				<?php
					//debug($category);
					if($category['Category']['parent_id'] != NULL) {
						echo $this->Html->link($category['ParentCategory']['name'], array('controller' => 'categories', 'action' => 'view', $category['ParentCategory']['id']));
					} else {
						echo "No Parent";
					}
				?>
			</div>
		</div>
	</div>
</div>

