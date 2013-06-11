<div class="main-content page user">
<div class="container">



<h1 class='name'>Now Following <?php echo h($spot['Spot']['name'])?></h1>
<br>
<p>
When you follow a spot you receive email updates for any specials or events created by the spot owner. 
You can unfollow a spot at anytime.
</p>
<br>
<a class='btn btn-large btn-yellow' href='/spots/view/<?php echo h($spot['Spot']['id']); ?>'>Back To Spot</a> 
 <a class='btn btn-blue btn-large' href='/users/unfollow_spot/<?php echo h($spot['Spot']['id']); ?>'>Unfollow Spot</a> 
	
</div></div>