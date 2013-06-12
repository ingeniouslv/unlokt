<div class="main-content page user">
<div class="container">



<h1 class='name'>Now Following <?php echo h($spot['Spot']['name'])?></h1>
<div class="row" style='margin-top:10px;'>
<p class='four columns'>You have followed this spot to keep in closer contact with the owner. You receive email updates for any specials 
or events. You can unfollow a spot at anytime.
</p>
 </div>
 
 <div class="row" style='margin-left:1px; margin-top:10px;'>

<a class='btn btn-large btn-yellow' href='/spots/view/<?php echo h($spot['Spot']['id']); ?>'>OK</a> 
 <a class='btn btn-red btn-large' href='/users/unfollow_spot/<?php echo h($spot['Spot']['id']); ?>'>Cancel</a> 
	 </div>
	 
	 
	 
</div></div>