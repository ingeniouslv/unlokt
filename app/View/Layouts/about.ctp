<?php echo $this->element('splash-head'); ?>
<body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
<div class="content-container">        
	<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container" style="height:60px;">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" id="logo" href="/">Unlokt</a>
	    </div>
	  </div>
	  
	  <div class="container-fluid white">	  
	    <div class="navbar-collapse collapse">
	        <nav class="navigation pull-right">
	          <ul class="nav navbar-nav">
	            <li class=""><a href="http://unlokt.com/pages/about">About Us</a></li>
	            <li class=""><a href="http://blog.unlokt.com/">Blog</span></a></li>
	            <li><a href="http://unlokt.com/spots/recommend_a_spot">Recommend </a></li>
	            <li><a href="http://unlokt.com/users/login" class="signIn">Sign In</a></li>
	          </ul>
	        </nav>  
	    </div><!--/.navbar-collapse -->	    
	  </div>
	</div>

	<?php echo $this->fetch('content'); ?>   

      <footer>
      	<div class="container">
	        <p>&copy; 2013 UNLOKT <span class="pull-right"><a href="http://unlokt.com/pages/about">About Us</a> | <a href="http://unlokt.com/spots/recommend_a_spot">Recommend</a> | <a href="http://unlokt.com/users/login" class="signIn">Sign In</a></span></p>
      	</div>
      </footer>
      
    </div> <!-- /container -->       
     
</div>

	<div class="splash-wrap hiddenop" id="splash-wrap">	
		<div class="splash">
			<?php if($this->Session->check('Message')): ?>
				<?php
					echo $this->Session->flash();
					echo $this->Session->flash('auth');
				?>
			<?php endif; ?>
'); ?>
		</div>
	</div>	
	
    	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="/js/vendor/bootstrap.min.js"></script>

        <script src="/js/plugins.js"></script>
        <script src="/js/main.js"></script>
</body>
</html>