<?php 

$j = json_decode($c->json,true); 





?>

<?php if($fields!=null): ?> 

						<?php $__currentLoopData = @$fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

							<?php echo e(__($a)); ?>


							<?php if($d['type']=="textarea"): ?>

								<textarea name="<?php echo e($a); ?>" id="" cols="30" fields="10" class="form-control"><?php echo e(json_field($j,$a)); ?></textarea>

							<?php elseif($d['type']=="select"): ?>

								<select name="<?php echo e($a); ?>" id="" class="form-control select2">

									<option value="">Seçiniz</option>

									<?php $__currentLoopData = $d['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

										<option value="<?php echo e($v); ?>" <?php if($v ==json_field($j,$a)): ?> selected <?php endif; ?>><?php echo e($v); ?></option>

									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								</select>

							<?php elseif($d['type']=="select-dynamic"): ?>

							<?php

							$db_and_type = explode(":",$d['values'][0]);
							
								$sorgu = DB::table($db_and_type[0])
								->where("type",$db_and_type[1])
								->get();

								$title = explode("-",$d['values'][1]);

							?>

								<select name="<?php echo e($a); ?>" id="" class="form-control select2">

									<option value="">Seçiniz</option>

									<?php $__currentLoopData = $sorgu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

										<?php

											$value = $s->{$d['values'][2]};

										?>

										<option value="<?php echo e($value); ?>"  <?php if($value ==json_field($j,$a)): ?> selected <?php endif; ?>>

										<?php $__currentLoopData = $title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

										<?php echo e($s->{$t}); ?> 

										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

										</option>

									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								</select>

							<?php elseif($d['type']=="select-multiple-dynamic"): ?>

							<?php
								$db_and_type = explode(":",$d['values'][0]);
						
								$sorgu = DB::table($db_and_type[0])
								->where("type",$db_and_type[1])
								->get();

								$title = explode("-",$d['values'][1]);

							?>

								<select name="<?php echo e($a); ?>[]" id="" class="form-control select2" multiple>

									<option value="">Seçiniz</option>

									<?php $__currentLoopData = $sorgu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

										<?php

											$value = $s->{$d['values'][2]};

										?>

										<option value="<?php echo e($value); ?>"  <?php if(@in_array($value,json_field($j,$a))): ?> selected <?php endif; ?>>

										<?php $__currentLoopData = $title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

										<?php echo e($s->{$t}); ?> 

										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

										</option>

									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								</select>

							<?php elseif($d['type']=="select-multiple"): ?>

								<select name="<?php echo e($a); ?>[]" id="" class="form-control select2" multiple>

									<option value="">Seçiniz</option>

									

									<?php $__currentLoopData = $d['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

										<?php if($v!=""): ?>

											<option value="<?php echo e($v); ?>" <?php if(@in_array($v,json_field($j,$a))): ?> selected <?php endif; ?>><?php echo e($v); ?></option>

										<?php endif; ?>

									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

									<?php if(is_array(json_field($j,$a))): ?>

										<?php $__currentLoopData = json_field($j,$a); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

											<option value="<?php echo e($v); ?>" selected><?php echo e($v); ?></option>

										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

									<?php endif; ?>

								</select>

							<?php elseif($d['type']=="radio"): ?> <br />

								<?php $__currentLoopData = $d['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

								

									<label><input type="<?php echo e($d['type']); ?>" name="<?php echo e($a); ?>" value="<?php echo e($v); ?>" <?php if($v ==json_field($j,$a)): ?> checked <?php endif; ?> id="" /> <?php echo e($v); ?></label> <br />

								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<?php elseif($d['type']=="checkbox"): ?>  <br />

								<?php $__currentLoopData = $d['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

									<label><input type="<?php echo e($d['type']); ?>" name="<?php echo e($a); ?>[]" value="<?php echo e($v); ?>" <?php if(@in_array($v,json_field($j,$a))): ?> checked <?php endif; ?> id="" /> <?php echo e($v); ?></label> <br />

								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<?php else: ?>

								<input type="<?php echo e($d['type']); ?>" step="any" class="form-control" name="<?php echo e($a); ?>" value="<?php echo e(json_field($j,$a)); ?>" id="" />

							<?php endif; ?>

							

							

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

					<?php endif; ?><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin/inc/fields.blade.php ENDPATH**/ ?>