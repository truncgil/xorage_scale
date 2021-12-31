<?php $sorgu = db("stok_cikislari")->where("siparis_id",get("id"))->get();

?>
<div class="m-3">
    <table class="table table-striped table-hovert table-bordered table-xs ">
        <tr class="table-danger">
            <th><?php echo e(e2("BARKOD")); ?></th>
            <th><?php echo e(e2("STOK BİLGİSİ")); ?></th>
            <th><?php echo e(e2("MİKTAR")); ?></th>
        </tr>
        <?php 
        $toplam = 0;
        foreach($sorgu AS $s) { 
            $toplam +=$s->qty;
            $stok = j($s->stok);
            $stok_json = j($stok['json']);
        ?>
        <tr>
            <td><?php echo e($stok['slug']); ?></td>
            <td><?php echo e(urun_ozellikleri($stok_json)); ?></td>
            <td><?php echo e(nf($s->qty)); ?></td>
        </tr> 
        <?php } ?>
        <tfoot>
        <tr class="table-warning">
        <th  colspan="2" class="text-right"><?php echo e(e2("TOPLAM")); ?> :</th>
        <th><?php echo e(nf($toplam)); ?></th>
        </tr>
    </tfoot>

    </table>
</div><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin-ajax/siparis-stok-cikisi.blade.php ENDPATH**/ ?>