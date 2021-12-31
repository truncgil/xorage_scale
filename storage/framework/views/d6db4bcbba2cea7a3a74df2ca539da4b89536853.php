<?php $stoklar = db("stoklar")->where("type",get("id"))
->whereNull("cikis") // çıkışı yapılmayan barkodlar listelensin yalnızca
->orderBy("id","DESC")->get();
$siparis = db("siparisler")->where("id",get("siparis_id"))->first();
$json = j($siparis->json);

unset($json['qty']);
unset($json['ROLL_NO']);
unset($json['METRE']);
//print2($json);
 ?>

    <select name="stok[]" class="stok-sec form-control" style="height:400px;" multiple>
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
    </select>
    <button class="btn btn-primary btn-fix "><i class="fa fa-plus"></i></button>


     
<script>
  //  $(".stok-sec").select2();
    $(".stok-sec").on("change",function(){
        $(".info").html("Yükleniyor...").load("?ajax=print-stok&noprint&id="+$(this).val());
    });
</script><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin-ajax/siparis-detay3.blade.php ENDPATH**/ ?>