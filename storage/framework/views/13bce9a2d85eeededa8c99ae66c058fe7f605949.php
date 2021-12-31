<?php use App\Translate; ?>

<?php if(!getisset("ajax")) { ?>


<?php $__env->startSection("title"); ?>
	<?php echo e($c->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("desc"); ?>
	<div class="container">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo e(url('admin/new/contents')); ?>"><i class="fa fa-home"></i></a></li>
			<?php echo $breadcrumb; ?>

			<li class="breadcrumb-item active" aria-current="page"><?php echo e($c->title); ?></li>
		  </ol>
		</nav>
		
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php } else { ?>
<style type="text/css">
.modal #sidebar,.modal #page-header,.modal #side-overlay {
display:none !important;
}
</style>
<?php } ?>
<script type="text/javascript">
$(function(){
	$('.ana-icerik,.ceviriler,.coklu').toggleClass('hidden');
});
</script>
<div class="content">
<div class="block">
	<div class="block-header block-header-default">
		<h3 class="block-title"><?php echo e($c->title); ?> <?php echo e(__('İçeriğini Düzenle')); ?></h3>
		<div class="block-options">
			<button type="button" class="btn-block-option" onclick="$('.ana-icerik').toggleClass('hidden');">
				<i class="si si-eye"></i>
			</button>
		</div>
	</div>
	<div class="block-content block-content-full ana-icerik">
		
		<form action="<?php echo e(url('admin-ajax/cover-upload')); ?>" class="hidden-upload" id="f<?php echo e($c->id); ?>" enctype="multipart/form-data" method="post">
							<input type="file" name="cover" id="c<?php echo e($c->id); ?>" onchange="$('#f<?php echo e($c->id); ?>').submit();" required />
							<input type="hidden" name="id" value="<?php echo e($c->id); ?>" />
							
							<input type="hidden" name="slug" value="<?php echo e($c->slug); ?>" />
							<?php echo e(csrf_field()); ?>

						</form>
		<form action="<?php echo e(url('admin-ajax/content-update?back')); ?>" class="serialize" method="post">
		<?php echo e(csrf_field()); ?>

			<div class="row">
				<div class="col-md-9">
					<?php echo e(__('Başlık')); ?>

					<input type="hidden" name="id" value="<?php echo e($c->id); ?>" />
					
					<input type="hidden" name="oldslug" value="<?php echo e($c->slug); ?>" />
					<input type="text" name="title" id="title" value="<?php echo e($c->title); ?>" class="form-control" />
					
					<?php echo e(__('ID')); ?> <div class="btn btn-default" onclick="$.get('<?php echo e(url('admin-ajax/slug?title='.$c->breadcrumb)); ?>'+$('#title').val(),function(d){
						$('#slug').val(d)
					})"><i class="si si-refresh"></i></div>
					
				
					<input type="text" name="slug" id="slug" value="<?php echo e($c->slug); ?>" class="form-control" />
					<?php echo e(e2("Parent")); ?>

					<input type="text" name="kid" class="form-control" value="<?php echo e($c->kid); ?>" />
					<?php echo e(__('İçerik Tipi')); ?>

					<select name="type" id="<?php echo e($c->id); ?>" class="form-control edit" table="contents" >
						<option value="">Tip Seçiniz</option>
					<?php $__currentLoopData = @$types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($t->title); ?>" <?php if($t->title==$c->type): ?> selected <?php endif; ?>><?php echo e($t->title); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
					
					<?php echo e(__('İçerik')); ?>

					<textarea class="" id="editor" name="html"><?php echo e($c->html); ?></textarea>
					
					<?php echo $__env->make("admin.inc.fields", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
				<div class="col-md-3 text-center">
				<?php if($c->cover!=''): ?>
					<div class="js-gallery">
						<a href="<?php echo e(url('cache/large/'.$c->cover)); ?>" class="img-link img-link-zoom-in img-thumb img-lightbox"  target="_blank" >
							<img src="<?php echo e(url('cache/small/'.$c->cover)); ?>" alt="" />
						</a>
					</div>
						<hr />
						<?php else: ?> 
								<i class="fa fa-image" style="    display: block;
    font-size: 150px;
    color: #f3f3f3;"></i>
						<?php endif; ?>
						<div class="btn-group">
						<button type="button" class="btn  btn-secondary btn-sm" onclick="$('#c<?php echo e($c->id); ?>').trigger('click');" title="<?php echo e(__('Resim Yükle')); ?>"><i class="fa fa-upload"></i> <?php echo e(__('Kapak Resmi Yükle')); ?></button>
						<?php if($c->cover!=''): ?>
						<a teyit="<?php echo e(__('Resmi kaldırmak istediğinizden emin misiniz')); ?>" title="<?php echo e(__('Resmi kaldır')); ?>" href="<?php echo e(url('admin-ajax/cover-delete?id='.$c->id)); ?>" class="btn btn-secondary btn-sm "><i class="fa fa-times"></i></a>
						<a title="<?php echo e(__('Resmi indir')); ?>" href="<?php echo e(url('cache/download/'.$c->cover)); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i></a>
						<?php endif; ?>
						</div>
						
				</div>
			</div>
			
			
			<hr />
			<div class="right-fixed">
				<a href="<?php echo e(url($c->slug)); ?>" target="_blank" class="btn btn-danger"><i class="fa fa-globe"></i> <?php echo e(__($c->title)); ?> <?php echo e(__('İçeriğini Web\'de Gör')); ?></a>
				<button class="btn btn-primary"><?php echo e(__('Değişiklikleri Kaydet')); ?></button>
			</div>
		</form>
		<form action="<?php echo e(url('admin-ajax/files-upload')); ?>" id="files<?php echo e($c->id); ?>" class="dropzone" id="dropzone" enctype="multipart/form-data" method="post">
							<div class="fallback">
								<input name="file" type="file" multiple />
								
							  </div>
							  <?php if($c->files!=""): ?> 
								  <?php
									$files = explode(",",$c->files);
								  ?>
								  <?php $__currentLoopData = @$files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								  <?php $file_title = str_replace("storage/app/files/".$c->slug . "/","",$f); ?>
								  <div file="<?php echo e($f); ?>" class="dz-preview dz-file-preview dz-processing dz-error dz-complete">  
									  <div class="dz-image"><img data-dz-thumbnail="" onerror='$(this).hide();' src="<?php echo e(url($f)); ?>" width="100%"></div>  <div class="dz-details">    
									  <div class="dz-filename"><span data-dz-name=""><?php echo e($file_title); ?></span></div>  </div>  
									  <div class="dz-success-mark">   
									  <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      
									  <title>Check</title>      
									  <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">       
									  <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>      </g>    </svg>  </div>  
										<div class="btn-group">
											<div  class="btn btn-default delete"><i class="fa fa-times"></i></div>								  
											<a href="<?php echo e(url($f)); ?>" target="_blank" class="btn btn-default "><i class="fa fa-download"></i></a>								
											<?php if(strpos($f,".fbx")!==false) {
												 ?>
												 <a href="<?php echo e(url("three-js?file=".$f)); ?>" target="_blank" class="btn btn-default " title="<?php echo e(e2("3D Önizleme")); ?>"><i class="fa fa-box"></i></a>
												 <?php 
											} ?>  
										</div>
								  </div>
								  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							  <?php endif; ?>
							  <div class="dz-message" data-dz-message><span><?php echo e(__('İçeriğin dosyalarını buraya bırakarak veya tıklayarak yükleyebilirsiniz')); ?></span></div>
							  <input type="hidden" name="id" value="<?php echo e($c->id); ?>" />
							<input type="hidden" name="slug" value="<?php echo e($c->slug); ?>" />
							<?php echo e(csrf_field()); ?>

						</form>
						<script type="text/javascript">
						$(function(){
							
							$(".dz-preview .delete").on("click",function(){
								var bu = $(this).parent().parent();
								bu.fadeTo(0.5);
								$.post("<?php echo e(url('admin-ajax/delete-file')); ?>",{
									file:bu.attr("file"),
									slug : "<?php echo e($c->slug); ?>",
									id : "<?php echo e($c->id); ?>",
									_token : "<?php echo e(csrf_token()); ?>"
								},function(d){
									bu.fadeOut();
								});
								$(".dz-message").html("")
								
							}).css("cursor","pointer");
							
						});
						</script>
						<style type="text/css">
						
						</style>
	</div>
</div>

<!--
<?php echo $__env->make("admin.inc.translate", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make("admin.inc.multi-content", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
-->
<?php echo $__env->make("admin.inc.sub-content", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<?php if(!getisset("ajax")) { ?>
<?php $__env->stopSection(); ?>
<?php } ?>

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin/contents.blade.php ENDPATH**/ ?>