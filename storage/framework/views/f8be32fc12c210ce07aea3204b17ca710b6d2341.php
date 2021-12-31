<?php $urun = db("contents")
->where("type","Ürünler")
->where("id",get("id"))->first();

$alt = explode(",",$urun->alt_type);
$stoklar = db("stoklar")->select("json")->orderBy("id","DESC")->get();
$alanlar = array();
foreach($stoklar AS $s) {
    $j = j($s->json);
    foreach($j AS $alan=>$deger) {
       
            if(!isset($alanlar[$alan])) $alanlar[$alan] = array();
            if(!in_array($deger,$alanlar[$alan])) {
                array_push($alanlar[$alan],$deger);
            }
    }
}
//print2($alanlar);
if(count($alt)>0) {
?>
<?php foreach($alt AS $a) {
    if($a!="") {
        $a2 = str_replace(" ","_",$a);
     ?>
     <?php echo e($a); ?>:
     <select name="<?php echo e($a2); ?>" id="<?php echo e($a2); ?>" class="form-control select2">
         <?php 
         if(isset($alanlar[$a2])) {
            foreach($alanlar[$a2] AS $option) { ?>
                <option value="<?php echo e($option); ?>"><?php echo e($option); ?></option>
            <?php } ?>
         <?php } ?>
     </select>
     
     <?php 
    }
} ?>
<?php } ?>
<script>
    $(".select2").select2({
        tags: true
    });
</script><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin-ajax/urun-alt-detay.blade.php ENDPATH**/ ?>