<div class="navbar-admin">
	<div class="container">
		<div class="btn-group">
			<?php
				if(isset($admin_options)) { 
					foreach($admin_options as $admin_option) {
						echo $this->Html->link($admin_option['display_name'], array('controller' => $admin_option['controller'], 'action' => $admin_option['action'], 'admin' => true), array('class'=>'btn btn-dark'));
					}
				} else {
					echo $this->Html->link('Categories', array('controller' => 'categories', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
					echo $this->Html->link('Feeds', array('controller' => 'feeds', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
					echo $this->Html->link('Locations', array('controller' => 'locations', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
					echo $this->Html->link('Pages', array('controller' => 'pages', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
					echo $this->Html->link('Plans', array('controller' => 'plans', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
					echo $this->Html->link('Notes', array('controller' => 'reviews', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
					echo $this->Html->link('Specials', array('controller' => 'deals', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
					echo $this->Html->link('Spots', array('controller' => 'spots', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
					echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index', 'admin' => true), array('class'=>'btn btn-dark'));
				}
			?>
		</div>
	</div>
</div>