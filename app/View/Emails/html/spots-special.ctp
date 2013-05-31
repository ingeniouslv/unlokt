
<div style="max-width:8.5in;font-size:12pt;color:white; background:black;padding:17px;">
	 
 
	<h3 style="font-size:16pt;"><?php echo $deal['name'] ; ?></h3>
	<p>
		<?php echo $deal['description']; ?>
	</p>
	
	
	<p>
	
	<b><?php echo $deal['start_time'] ; ?> to <?php echo $deal['end_time'] ; ?><br>
	<?php echo $deal['start_date'] ; ?></b>
	
	</p>
	<br><br>
	<h3><?php echo $spot['name']; ?></h3>
	
	<p>
	<?php echo $spot['address']; ?> <?php echo $spot['address2']; ?><br>
	<?php echo $spot['city']; ?>, <?php echo $spot['state']; ?> <?php echo $spot['zip']; ?> <br>
	Phone: <?php echo $spot['phone']; ?><br><?php echo $spot['url']; ?><br>
	</p>


	<div style="background:#000;width: 205px;padding: 10px 10px 0px 10px;">
		<a href="https://unlokt.com" style="border:0px;"><img src="https://unlokt.com/img/main-logo2.png" alt="https://unlokt.com" /></a>
	</div>
	<p>
		unlokt.com
	</p>
</div>





