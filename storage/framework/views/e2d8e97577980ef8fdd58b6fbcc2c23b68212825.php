<div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title"><?php echo e(__('Çoklu İçerik Ekle')); ?></h3>
            <div class="block-options">
				<button type="button" class="btn-block-option" onclick="$('.coklu').toggleClass('hidden');">
					<i class="si si-eye"></i>
				</button>
			</div>
        </div>
		

        <div class="block-content block-content-full coklu">
			<form action="<?php echo e(url('admin-ajax/content-multi-add?kid='.$c->slug)); ?>" method="post">
			<?php echo csrf_field(); ?>
			<div class="row">
				<div class="col-md-6">
					<?php echo e(__('Bu kutuya birden fazla başlık yazarak bu alana çoklu olarak içerik ekleyebilirsiniz:')); ?>
					<select name="contents[]" id="" class="select2 form-control" multiple>
						<option value=""></option>
					</select>
					
					
				</div>
				<div class="col-md-6">
					<?php echo e(__('Tip Seçiniz')); ?>
					<select name="type"  class="form-control" >
						<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($t->title); ?>"><?php echo e($t->title); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
				<div class="col-md-12">
					<br />
					<button class="btn btn-primary"><?php echo e(__('Ekle')); ?></button>
				</div>
			</div>
			
			</form>
		</div>
</div><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin/inc/multi-content.blade.php ENDPATH**/ ?>