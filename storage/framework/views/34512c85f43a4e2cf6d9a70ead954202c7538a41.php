<?php 
$urunler = contents_to_array("Ürünler");

$siparisler = db("siparisler")->where("kid",get("id"))->orderBy("id","DESC")->get(); ?>

<?php echo e(e2("SİPARİŞLER:")); ?>

<select name="siparis" id="" class="form-control select2 siparis-sec">
<option value=""><?php echo e(e2("SİPARİŞ SEÇİNİZ")); ?></option>
    <?php foreach($siparisler AS $s) { ?>
        <option value="<?php echo e($s->id); ?>" type="<?php echo e($s->type); ?>"><?php echo e($urunler[$s->type]->title); ?> / <?php echo e(date("d.m.Y H:i",strtotime($s->created_at))); ?> / <?php echo e($s->qty); ?> </option>
    <?php } ?>
</select>
<div class="siparis-detay"></div>
<script>
    $(".siparis-sec").select2();
    $(".siparis-sec").on("change",function(){
        $(".siparis-detay").html("Yükleniyor...");
        $.get("?ajax=siparis-detay",{
            id : $('option:selected', this).attr('type'),
            siparis_id : $(this).val()
        },function(d){
            $(".siparis-detay").html(d);
        });
        
        
    }); 
</script><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin-ajax/siparisler.blade.php ENDPATH**/ ?>