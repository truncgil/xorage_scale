<?php $stoklar = db("stoklar")->where("type",get("id"))
->whereNull("cikis") // çıkışı yapılmayan barkodlar listelensin yalnızca
->orderBy("id","DESC")->get();
$siparis = db("siparisler")->where("id",get("siparis_id"))->first();
$json = j($siparis->json);

unset($json['qty']);
unset($json['ROLL_NO']);
unset($json['METRE']);
 ?>
 <?php echo e(e2("STOK BARKODU GİRİNİZ")); ?>

 <select name="stok" id="stok" class="form-control select2 stok-sec">
     <option value=""><?php echo e(e2("SEÇİNİZ")); ?></option>
     <?php foreach($stoklar AS $s) {
         $stok_json = j($s->json);
         unset($stok_json['qty']);
         unset($stok_json['ROLL_NO']);
         //print2($stok_json);
         $kabul = true;
         foreach($stok_json AS $alan => $deger) {
             if(isset($json[$alan])) {
                 if($json[$alan]!=$deger) {
                 //    echo "$alan : {$json[$alan]} <> $deger \n";
                     $kabul=false;
                 }
             }
             
         }
         if($kabul)  { 
     ?>
     <option value="<?php echo e($s->id); ?>"><?php echo e($s->slug); ?> / <?php echo e($s->net); ?></option>
     <?php } ?>
     <?php 
} ?>
     
<script>
    $(".stok-sec").select2();
    $(".stok-sec").on("change",function(){
        $(".info").html("Yükleniyor...").load("?ajax=print-stok&noprint&id="+$(this).val());
    });
</script><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin-ajax/siparis-detay.blade.php ENDPATH**/ ?>