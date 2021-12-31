<?php use App\Translate; ?>

<?php $__env->startSection("title",__($id)." ".__("Çevirisini Düzenle")); ?>
<?php $__env->startSection("desc",__($id)." ".__(" Çevirisini bu sayfadan düzenleyebilirsiniz")); ?>
<?php $__env->startSection('content'); ?>

<script>
$(document).ready(function(){
  $("#ceviri-ara").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#ceviri-table tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<style type="text/css">
.tek-satir {
	white-space:nowrap;
	max-width:250px;
	text-overflow:ellipsis;
	overflow:hidden
}

</style>
	
	<div class="content">
		<div class="block">
				 <div class="block-header block-header-default">
					<h3 class="block-title"><?php echo e(__($id)); ?></h3>
					<div class="block-options">
					<script type="text/javascript">
					$(function(){
						$(".satir-olustur").on("click",function(){
							var bu = $(this); bu.html('İşlem yapılıyor. Bu işlem biraz sürebilir...'); 
							$.get('<?php echo e(url('admin-ajax/lang-cache/?dil='.$id)); ?>',function(d){
							bu.html('Tüm içeriklerin satırları oluşturuldu');
								window.setTimeout(function(){
									location.reload();
								},1000);
								
							});
						});
					});
					</script>
					<?php $isim = explode(".",$id); ?>
						<div class="block-options-item">
						<div class="btn btn-primary satir-olustur" onclick=""><?php echo e(__('Tüm İçeriklerin Satırlarını Oluştur')); ?></div>
						<div class="btn btn-info" onclick="$.get('<?php echo e(url('ajax/set-locale?l='.$isim[0])); ?>',function(){location.reload();})"><?php echo e(__('Dili Şu Şekilde Değiştir:')); ?> <?php echo e($isim[0]); ?></div>
						</div>
					</div>
				</div>
				<?php 
					$diller = Translate::where("dil",$id)->whereRaw("LENGTH(icerik) < 1000");
					if(getisset("q")) {
						$diller = $diller -> where("icerik","like","%{$_GET['q']}%");
					}
					
					$diller =$diller->orderBy("id","DESC")->simplePaginate(10);
				?>
				<div class="block-content">
				<form action="" method="get">
					<input type="text" name="q" class="form-control" value="<?php echo e(get("q")); ?>"  placeholder="Ara..."  /> <br />
				</form>
						<?php echo csrf_field(); ?>
						<input type="hidden" name="<?php echo e(base64_encode('json')); ?>" value="<?php echo e($id); ?>" />
						
						<table class="table table-bordered table-hover table-striped " id="ceviri-table">
							<thead>
								<tr>
									<th><?php echo e(__("İçerik")); ?></th>
									<th><?php echo e(__("Çeviri")); ?></th>
									<th><?php echo e(__("İşlem")); ?></th>
								</tr>
							</thead>
							
							<tbody>
							<?php $__currentLoopData = $diller; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								
							<?php if(is_html($d->icerik)): ?>
								<tr>
									<td>
										<div style="width:500px;height:150px;overflow:auto">
											<?php echo $d->icerik; ?>

										</div>
									</td>
									<td>
										<form action="<?php echo e(url('admin-ajax/input-edit')); ?>" class="ajax-form" method="post">
										<?php echo csrf_field(); ?>
											<input type="hidden" name="id" value="<?php echo e($d->id); ?>" />
											<input type="hidden" name="table" value="translate" />
											<input type="hidden" name="name" value="ceviri" />
											<?php //{{base64_encode($d->icerik)}} ?>
												<textarea name="value" class="form-control ckeditor" id="editor" cols="30" rows="10"><?php echo $d->ceviri; ?></textarea>
										</form>
									</td>
								
								
							<?php else: ?>
								<tr>
									<td><div class="tek-satir"><?php echo e($d->icerik); ?></div></td>
									<td>
									<textarea name="ceviri" table="translate" id="<?php echo e($d->id); ?>" cols="30" rows="1" class="edit form-control"><?php echo e($d->ceviri); ?></textarea>
									</td>
								
							<?php endif; ?>
								<td>
									<a href="" onclick="$.get('?ajax=translate-sil&id=<?php echo e($d->id); ?>');
									$(this).parent().parent().remove(); return false" class="btn btn-danger" title="<?php echo e(__('Bu satırı sil')); ?>"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
						<?php echo e($diller->appends($_GET)->links()); ?>

				</div>
		</div>
	</div>
<script type="text/javascript">
$(function(){
	$("textarea.ckeditor_textarea").each(function(){
    var textarea_id = $(this).attr("id");
    CKEDITOR.instances[textarea_id].updateElement();
    ckeditor_blur_event(textarea_id)
});

});


</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin/languages.blade.php ENDPATH**/ ?>