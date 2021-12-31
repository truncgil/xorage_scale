<?php echo e(col("col-md-12 gecmis-stok-cikislari","Geçmiş Stok Çıkışları",3)); ?> 

    <?php $stoklar = db("stok_cikislari");
    if(!getesit("urun","")) $stoklar = $stoklar->where("siparis->type",get("urun"));
    if(!getesit("musteri","")) $stoklar = $stoklar->where("musteri_id",get("musteri"));
    if(!getesit("date1","")) $stoklar = $stoklar->where("created_at",get("date1"));
    $stoklar = $stoklar->orderBy("id","desc")->get(); ?>
    <div class="table-responsive ">
        <table class="table" id="excel">
            <tr>
                <th><?php echo e(e2("STOK ÇIKIŞ NO")); ?></th>
                <th><?php echo e(e2("İŞLEM TARİHİ")); ?></th>
                <th><?php echo e(e2("FİRMA")); ?></th>
                <th><?php echo e(e2("SİPARİŞ BİLGİSİ")); ?></th>
                <th><?php echo e(e2("STOK BİLGİSİ")); ?></th>
                <th><?php echo e(e2("MİKTAR")); ?></th>
                <th><?php echo e(e2("İŞLEM")); ?></th>
            </tr>
            <?php foreach($stoklar AS $s) {
                $firma = j($s->musteri);
                $stok = j($s->stok);
                $siparis = j($s->siparis);
                $urun = $urunler[$siparis['type']];
                ?>
            <tr>
                <td><?php echo e($s->id); ?></td>
                <td>
                    <input type="datetime-local" name="created_at" value="<?php echo e(date('Y-m-d\TH:i', strtotime($s->created_at))); ?>" class="form-control edit" table="stok_cikislari" id="<?php echo e($s->id); ?>">

                </td>
                <td><?php echo e($firma['title']); ?> / <?php echo e($firma['title2']); ?>

            
                </td>
                <td><?php echo e($urun->title); ?> / <?php echo e(date("d.m.Y H:i",strtotime($siparis['created_at']))); ?></td>
                <td>
                <a href="?ajax=print-stok&id=<?php echo e($stok['slug']); ?>&noprint" title="<?php echo e($stok['slug']); ?> Barkoduna Ait Bilgiler" class="ajax_modal"><?php echo e($stok['slug']); ?></a>
               </td>
                <td><?php echo e(nf($s->qty)); ?></td>
                <td>
                    <a href="?sil=<?php echo e($s->id); ?>&stok_id=<?php echo e($s->stok_id); ?>" teyit="<?php echo e(e2("Bu kayıt silinecektir. Bu işlem geri alınamaz")); ?>" class="btn btn-danger">Sil</a>
                </td>
            </tr>
           <?php } ?>
        </table>
    </div>
    <?php echo e(_col()); ?><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin/type/stok-cikislari/gecmis-stok-cikislari.blade.php ENDPATH**/ ?>