<?php 
$user = u();
$urunler = contents_to_array("Ürünler"); 
$musteriler = contents_to_array("Müşteriler"); 
$users = usersArray();

?>
<div class="content">
    <div class="row">
        
    <?php if(getisset("ids")) {
         ?>
         <?php echo $__env->make("admin.type.stok-cikislari.coklu-stok-cikisi", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php 
    } else {
         ?>
         <?php echo $__env->make("admin.type.stok-cikislari.yeni-stok-cikisi", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php 
    } ?>
    
    <?php echo $__env->make("admin.type.stok-cikislari.filtrele", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("admin.type.stok-cikislari.gecmis-stok-cikislari", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    
    </div>
</div>
<script>
                $(function(){
                    <?php foreach($_GET AS $alan => $deger) {
                         ?>
                         $("[name='<?php echo e($alan); ?>']").val("<?php echo e($deger); ?>");
                         <?php 
                    } ?>
                });
            </script>

<?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin/type/stok-cikislari.blade.php ENDPATH**/ ?>