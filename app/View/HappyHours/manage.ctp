<?php
$this->set('title_for_layout', 'Manage Happy Hours for '.h($spot['Spot']['name'])); 
$days_of_week = array(
	0 => 'Sunday',
	1 => 'Monday',
	2 => 'Tuesday',
	3 => 'Wednesday',
	4 => 'Thursday',
	5 => 'Friday',
	6 => 'Saturday'
);
?>
<div class="main-content page spot">
	<div class="container">
		<div class="row">
			<div class="nine columns">
				<h1>Happy Hour Manager for <a href="<?php echo $this->webroot; ?>spots/view/<?php echo $spot['Spot']['id']; ?>"><?php echo h($spot['Spot']['name']); ?></a></h1>

				<h3>Current Happy Hours</h3>

				<table class="zebra">
					<thead>
						<tr>
							<th>Title</th>
							<th>Day of Week</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th class="actions">Actions</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($happyHours as $happyHour): ?>
							<tr>
								<td><?php echo $happyHour['HappyHour']['title']; ?></td>
								<td><?php echo $days_of_week["{$happyHour['HappyHour']['day_of_week']}"]; ?></td>
								<td><?php echo date('g:i a', strtotime($happyHour['HappyHour']['start'])); ?></td>
								<td><?php echo date('g:i a', strtotime($happyHour['HappyHour']['end'])); ?></td>
								<td class="actions">
									<a class="btn btn-red" href="<?php echo $this->webroot; ?>happy_hours/delete/<?php echo $happyHour['HappyHour']['id']; ?>" onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
								</td>
							</tr>
						<?php endforeach; ?>
						<tr class="table-actions">
							<td colspan="4" class="actions">
								<a class="btn btn-blue" href="<?php echo $this->webroot; ?>happy_hours/add/<?php echo $spot['Spot']['id']; ?>">New Happy Hour</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

