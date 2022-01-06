<?php $sorgu = db("stok_cikislari")->where("siparis_id",get("id"));
if(getisset("bugun")) {
    $sorgu = $sorgu->whereRaw('Date(created_at) = CURDATE()');
}
$sorgu = $sorgu->get();

?>
<div class="m-3">
    <table class="table table-striped table-hovert table-bordered table-xs ">
        <tr class="table-danger">
            <th><?php echo e(e2("BARKOD")); ?></th>
            <th><?php echo e(e2("TARİH")); ?></th>
            <th><?php echo e(e2("STOK BİLGİSİ")); ?></th>
            <th><?php echo e(e2("MİKTAR")); ?></th>
        </tr>
        <?php 
        $toplam = 0;
        $adet = 0;
        $gramaj = 0;
        $metre = 0;
        foreach($sorgu AS $s) { 
            $toplam +=$s->qty;
            $stok = j($s->stok);
            $stok_json = j($stok['json']);
            if(isset($stok_json['METRE'])) $metre += $stok_json['METRE'];
            if(isset($stok_json['GRAMAJ'])) $gramaj += $stok_json['GRAMAJ'];
            if(isset($stok_json['ADET'])) $adet += $stok_json['ADET'];
        ?>
        <tr>
            <td><?php echo e($stok['slug']); ?></td>
            <td><?php echo e(date("d.m.Y",strtotime($s->created_at))); ?></td>
            <td><?php echo e(urun_ozellikleri($stok_json)); ?></td>
            <td><?php echo e(nf($s->qty)); ?></td>
        </tr> 
        <?php } ?>
        <tfoot>
        <tr class="table-warning">
        <th  colspan="3" class="text-right"><?php echo e(e2("TOPLAM")); ?> :</th>
        <th>
            <?php echo e(nf($toplam)); ?> <br>
        <?php if($metre!=0)  echo nf($metre," MT."); ?> <br>
        <?php if($gramaj!=0)  echo nf($gramaj," GR."); ?> <br>
        <?php if($adet!=0)  echo nf($adet," AD."); ?> <br>
        </th>
        </tr>
    </tfoot>

    </table>
</div><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin-ajax/siparis-stok-cikisi.blade.php ENDPATH**/ ?>