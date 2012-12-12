<!-- THIS MODAL IS BEING BUILT ON THE SPOT PAGE -->
<!-- IGNORE THIS FILE FOR NOW -->
<div class="main-content page spot">
	<div class="container">
		<h1>Gallery</h1>
	</div>
</div>

<div class="modal modal-gallery hide" id="galleryModal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h4><i class="icon-picture"></i>Gallery</h4>
	</div>
	<div class="modal-body">
		<div class="image">
			<img src="http://placehold.it/600x450">
		</div>

		<div class="image-selecter">
			<ul class="images">
				<li><img src="http://placehold.it/100x100"></li>
				<li><img src="http://placehold.it/100x100"></li>
				<li><img src="http://placehold.it/100x100"></li>
				<li><img src="http://placehold.it/100x100"></li>
				<li><img src="http://placehold.it/100x100"></li>
				<li><img src="http://placehold.it/100x100"></li>
			</ul>
		</div>
	</div>
</div>

<script>
$(function() {
	$('#galleryModal').modal();
});
</script>