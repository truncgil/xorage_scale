<?php if(getisset("detay")) {
    $urun = c(get("detay"));
    $musteriler = contents_to_array("Müşteriler");
    $siparisler = db("siparisler")->where("type",get("detay"))
    ->orderBy("id","DESC")
    ->get();
    $stok_cikislari = db("stok_cikislari")
    ->where("stok->type",get("detay"))
    ->orderBy("id","DESC")
    ->get();
    $stok_cikis_sayim = stok_cikis_sayim();
     ?>
     <div class="row">
     <?php col("col-md-6","{$urun->title} Sipariş Detayları",2) ?>
		 <div class="table-responsive">
			 <table class="table">
				 <tr>
					 <th>İşlem Tarihi</th>
					 <th>Müşteri</th>
					 <th>Miktar</th>
					 <th>Sevk Edilen</th>
					 <th>Kalan</th>
					 <th>Termin Tarihi</th>
				 </tr>
				 <?php foreach($siparisler AS $s)  { 
					$musteri = $musteriler[$s->kid];
				  ?>
 				 <tr>
 					 <td><?php echo e(date("d.m.Y H:i",strtotime($s->created_at))); ?></td>
 					 <td><?php echo e($musteri->title); ?></td>
 					 <td><?php echo e($s->qty); ?></td>
 					 <td>
						<?php 
						//  print2($stok_cikis_sayim);
						$stok_cikisi = 0;
						if(isset($stok_cikis_sayim[$s->id])) {
							$stok_cikisi = $stok_cikis_sayim[$s->id];
						} 
						?>
						<?php echo e($stok_cikisi); ?>

					</td>
					<td>
						<?php echo e($s->qty-$stok_cikisi); ?>

					</td>
 					 <td><?php echo e(date("d.m.Y",strtotime($s->date))); ?></td>
 				 </tr> 
				  <?php } ?>
			 </table>
		 </div>
			
 		<?php _col(); ?> 
 		<?php col("col-md-6 ","{$urun->title} Stok Çıkışları",3) ?>
			<div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Tarih</th>
                        <th>Barkod</th>
                        <th>Müşteri</th>
                        <th>Miktar</th>
                    </tr>
                    <?php foreach($stok_cikislari AS $s)  { 
                        $stok = j($s->stok);
                        $siparis = j($s->siparis);
                        $musteri = $musteriler[$s->musteri_id];
                       
                     ?>
                     <tr>
                         <td><?php echo e(date("d.m.Y H:i",strtotime($s->created_at))); ?></td>
                         <td>
                             <a href="?ajax=print-stok&id=<?php echo e($stok['slug']); ?>&noprint" title="<?php echo e($stok['slug']); ?> Barkoduna Ait Bilgiler" class="ajax_modal"><?php echo e($stok['slug']); ?></a>
                         </td>
                         <td><?php echo e($musteri->title); ?> <?php echo e($musteri->title2); ?></td>
                         <td><?php echo e($s->qty); ?></td>
                     </tr> 
                     <?php } ?>
                </table>
            </div>
 		<?php _col(); ?> 

     </div>
     
     
     <?php 
} ?><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin/type/urunler/urun-detay.blade.php ENDPATH**/ ?>