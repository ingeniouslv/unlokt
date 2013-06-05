 
<body style='background:black;'>


 
<div style="
position:relative;
max-width:8.5in;font-size:12pt;color:white; background:black;padding:35px;">

 
 <a href='<?php echo ABSOLUTE_URL ; ?>/special/view/<?php echo h($deal['id']); ?>' style='padding:0px;margin:0px;'><img 
  style='display:block;margin-bottom:0px;' vspace=0
  src='<?php echo ABSOLUTE_URL ; ?>/store/data/deal/<?php 
  echo h($deal['id']) ; ?>/<?php echo h($deal['id']) ; ?>/default.jpg' ></a><div style=" margin-top:0px;
  color:white;background:#585858 ;width:400px;">
 
 <div style='padding:10px;postiion:absolute; left:0px; top: 0px;'>
 
 	<a href='<?php echo ABSOLUTE_URL ; ?>/special/view/<?php echo h($deal['id']); ?>' style='display:inline-block;
	padding:3px 7px; 
	margin-top:4px;
	margin-left:8px;
	margin-bottom:8px;
	cursor:pointer;color:#1a1b20;font-size:11px;font-weight:bold;line-height:1.5;
	text-align:center; 
	float:right;
	vertical-align:top; 
	text-decoration:none;
border:1px solid #f6cc36;background-color:#fae69b;
	*display:inline;*zoom:1;'>View <?php echo h($deal['type']); ?></a>
	
	
   <p style="font-weight:bold;color:#FFDB4D;
      font-size:1.2em;margin-top:6px;margin-bottom:6px;"><?php echo h($spot['name']); ?> 
      <?php echo h($deal['type']); ?></p>
 
 
 
  <p style="font-size:1em;font-weight:bold;
      margin-top:6px;margin-bottom:6px;"><?php echo h($deal['name']) ; ?></p>
 
  
 	
 <p style='font-size:.8em;margin-top:6px;'>
		<?php echo h($deal['description']); ?>
	</p>
	

</div>
 </div>
  
  

	
	<p style='font-size:.9em;'>
	<b><?php echo h($spot['name']); ?></b><br>
	<?php echo h($spot['address']); ?> <?php echo h($spot['address2']); ?><br>
	<?php echo h($spot['city']); ?>, <?php echo h($spot['state']); ?> <?php echo h($spot['zip']); ?> <br>
	Phone: 		<?php if (preg_match('/^\d{10}$/', $spot['phone'])): ?>
					<?php echo h(preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '($1) $2-$3', $spot['phone'])); ?>
				<?php else: ?>
					<?php echo h($spot['phone']); ?>
				<?php endif; ?><br><?php echo h($spot['url']); ?><br>
	</p>


<br>

	<div style="background:#000;width: 205px;padding: 10px 10px 0px 10px;">
		<a href="http://unlokt.com" style="border:0px;"><img src="http://unlokt.com/img/main-logo2.png"
			 alt="http://unlokt.com" /></a>
	</div>
	<p style='font-size:.8em;width:80%;'>
		Your are receiving this email because you follow <?php echo h($spot['name']); ?> on Unlokt.com and have notifications enabled.
		 If you do not wish to receive notifcations you can turn notifcations off here: <a 
		 href='<?php echo ABSOLUTE_URL ; ?>/users/account'>Account Settings</a><br><br>
		Unlokt.com - Copyright 2012-<?php echo date("Y"); ?> - All Rights Reserved
	</p>
</div>


</body>
 








