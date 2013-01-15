<?php
$days_of_week = array(
	0 => 'Sunday',
	1 => 'Monday',
	2 => 'Tuesday',
	3 => 'Wednesday',
	4 => 'Thursday',
	5 => 'Friday',
	6 => 'Saturday'
);
$current_dow = date('w');
$current_time = date('H:i');
// Make sure we have valid data for using this element.
// First check for $happy_hour_data array.
switch (true) {
	case isset($happy_hour_data) && is_array($happy_hour_data):
		// Variable is already set - nothing to do here.
		break;
	case isset($spot['HappyHour']):
		$happy_hour_data = $spot;
		break;
	case !isset($happy_hour_size):
		break;
	default:
		throw new NotFoundException('piece-happy_hour requires HappyHourData');
		break;
}

if (isset($happy_hour_size)):?>
	<?php if($happy_hour_size == "large"): ?>
		<h4><i class="icon-clock-1"></i> Happy Hour</h4>
		<!-- See if Happy Hour is happening NOW -->
		<?php
			foreach ($happy_hour_data as $happy_hour):
				foreach ($happy_hour['ChildHappyHour'] as $happy_hour_child):
					// Check if all the conditions are true to say Happy Hour is happening right now.
					if ($current_dow == $happy_hour_child['day_of_week'] && $current_time > $happy_hour_child['start'] && $current_time < $happy_hour_child['end']):
						$to = str_replace(':00', '', date('g:i a', strtotime($happy_hour['HappyHour']['end'])));
		?>
			<div class="is-active">
				<span>Happening 'till <span class="end-time"><?php echo $to; ?></span></span>
			</div>
		<?php break 2; endif; endforeach; endforeach; ?>
		
		<!-- Show the HappyHour schedule -->
		<div class="times">
			<?php
			$last_day_of_week_index = -1;
			
			foreach ($happy_hour_data as $happy_hour):
				$from = str_replace(':00', '', date('g:i a', strtotime($happy_hour['HappyHour']['start'])));
				$to = str_replace(':00', '', date('g:i a', strtotime($happy_hour['HappyHour']['end'])));
				$day_of_week = $days_of_week["{$happy_hour['HappyHour']['day_of_week']}"];
				
				if($happy_hour['HappyHour']['day_of_week'] != $last_day_of_week_index):
					$last_day_of_week_index = $happy_hour['HappyHour']['day_of_week'];
			?>
					<div class="weekday"><?php echo $days_of_week[$last_day_of_week_index]; ?></div>
			<?php
				endif;
			?>
			<p>
				<span class="title">
					<a href="javascript:void(0);" class="happy-hour-title"><?php echo $happy_hour['HappyHour']['title']; ?></a>
				</span>
				<b class="pull-right"><?php echo $from; ?> to <?php echo $to; ?></b>
				<span class="long-description"><?php echo $happy_hour['HappyHour']['description']; ?></span>
			</p>
			<!-- <p>Mon &ndash; Wed <b class="pull-right">4:00 pm to 7:00 pm</b></p>
			<p>Fri &amp; Sat <b class="pull-right">2:00 pm to 12:00 am</b></p> -->
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
<?php else: ?>
	<div class="is-active">
		<span>Happening 'till <span class="end-time"><?php echo $happening_until; ?></span></span>
	</div>
<?php endif; ?>