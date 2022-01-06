<?php 

$firmalar = contents_to_array("Müşteriler");
$urunler = contents_to_array("Ürünler");
$stok_cikis_sayim = stok_cikis_sayim();
$stok_metre_sayim = stok_metre_sayim();
 ?>
<div class="content">
    <div class="row">
        <?php 
        if(getisset("cogalt")) {
            $s = db("siparisler")->where("id",get("cogalt"))->first();
            if($s) {
                $s = (Array) $s;
                $id = $s['id'];
                unset($s['id']);
                unset($s['created_at']);
                unset($s['uid']);
                $id2 = ekle($s,"siparisler");
                bilgi("$id Sipariş kodlu sipariş çoğaltılmıştır. Çoğaltılan yeni sipariş kodu: $id2");
            }
        }
        ?>
        
        <?php echo $__env->make("admin.type.siparisler.yeni-siparis-formu", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
	<div class="block">
		<div class="block-header block-header-default">
			<h3 class="block-title"><i class="fa fa-<?php echo e($c->icon); ?>"></i> Siparişleriniz</h3>
			<div class="block-options">
				<div class="block-options-item"> <a
						href="<?php echo e(url('admin-ajax/content-type-blank-delete?type='. $c->title)); ?>"
						teyit="<?php echo e(__('Tüm boş '.$c->title.'  '._('') )); ?>" title="<?php echo e(_('Boş Olan  İçeriklerini Sil')); ?>"
						class="btn btn-danger"><i class="fa fa-times"></i> </a> <a
						href="<?php echo e(url('admin-ajax/content-type-add?type='. $c->title)); ?>" class="btn btn-success"
						title="Yeni <?php echo e($c->title); ?> <?php echo e(_('İçeriği Oluştur')); ?>"><i class="fa fa-plus"></i> </a> </div>
			</div>
		</div>
		<div class="block-content">
            <?php 
            if(getisset("sil")) {
                db("siparisler")
                ->where("id",get("sil"))
                ->delete();
                bilgi("{$_GET['sil']} numaralı sipariş silinmiştir");
            }
            $siparis_durumlari = siparis_durumlari();
            ?>
            <?php  $alt = db("siparisler");
                        if(getisset("q")) {
                            $musterilerdb = db("contents")->where("title","like","%".get("q")."%")->get();
                            if($musterilerdb) {
                                $musterilerdizi = array();
                                foreach($musterilerdb AS $mdb) {
                                    array_push($musterilerdizi,$mdb->id);
                                }
                                $alt = $alt->whereIn("kid",$musterilerdizi);
                            }
                            
                        }
                        if(getisset("durum")) {
                            $alt = $alt->where("title",get("durum"));
                        } else {
                            $alt = $alt->whereNull("title");
                        }

                        $alt = $alt->orderBy("id","DESC")->simplePaginate("20"); ?>
			<div class="js-gallery "> <?php echo $__env->make("admin.inc.table-search", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                <div class="float-left">
                
                </div>
                <div class="float-right">
                    <div class="btn-group">
                            <a href="?" class="btn btn-<?php if(!getisset("durum")) echo "success"; else echo "default"; ?>"><?php echo e(e2("Tümü")); ?></a>
                        <?php foreach($siparis_durumlari AS $sd) {
                             ?>
                             <a href="?durum=<?php echo e($sd); ?>" class="btn btn-<?php if(getesit("durum",$sd)) echo "success"; else echo "default"; ?>"><?php echo e($sd); ?></a>
                             <?php 
                        } ?>
                    </div>
                </div>
                <script>
$(function(){
    $(".stok_cikisi_all").click(function(){
        $('.stok_cikisi:checkbox').not(this).prop('checked', this.checked);
    });
    $(".stok-cikisi-btn").on("click",function(){
        var valuesArray = $('.stok_cikisi:checked').map(function () {  
        return this.value;
        }).get().join(",");
        var url = "<?php echo e(url("admin/types/stok-cikislari?ids=")); ?>" + valuesArray;
     //   alert(url);
        location.href=url;
    });
})

    </script>
    <div class="btn btn-primary stok-cikisi-btn"><?php echo e(e2("Seçilen Siparişler İçin Stok Çıkışı Oluştur")); ?></div>
                <div class="table-responsive">
					<table class="table table-striped table-hover table-bordered table-vcenter" id="excel">
						<thead>
							<tr>
                                <th>
                                    <input type="checkbox" name="" class="stok_cikisi_all" id="">
                                </th>
                                <th><?php echo e(e2("Sipariş Kodu")); ?></th>
								<th><?php echo e(__("Firma Ünvanı")); ?></th>
								<th><?php echo e(__("Ürün Adı")); ?></th>
                                <th><?php echo e(e2("Ürün Özellikleri")); ?></th>
                                <th><?php echo e(e2("Sipariş Notları")); ?></th>
                                <th><?php echo e(e2("Sipariş Miktarı")); ?></th>
                                <th><?php echo e(e2("Sevk Edilen")); ?></th>
                                <th><?php echo e(e2("Kalan Miktar")); ?></th>
                                <th><?php echo e(e2("Termin Tarihi")); ?></th>
								<th class="d-none"><?php echo e(__("Kategorisi")); ?></th>
								<th class="d-none" style="width: 15%;"><?php echo e(__("Tip")); ?></th>
								<th><?php echo e(__("Durum")); ?></th>
								<th class="d-none"><?php echo e(__("Sıra")); ?></th>
								<th class="text-center" style="width: 100px;"><?php echo e(__("İşlemler")); ?></th>
							</tr>
						</thead>
                        

						<tbody> <?php $__currentLoopData = $alt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                        $stok_cikisi = 0;
                        $stok_metre = 0;
                        if(isset($stok_cikis_sayim[$a->id])) {
                            $stok_cikisi = $stok_cikis_sayim[$a->id];
                        } 
                        if(isset($stok_metre_sayim[$a->id])) {
                            $stok_metre = $stok_metre_sayim[$a->id];
                        } 
                        $kalan_metre = 0;
                        if(isset($j['METRE'])) {
                            $kalan_metre = $stok_metre - $j['METRE']; 
                        }
                        if(isset($firmalar[$a->kid]))  { 
                         
                         ?>
                          <tr  class="<?php if($a->qty - $stok_cikisi<0) echo "table-danger"; ?>" id="t<?php echo e($a->id); ?> ">
                             <?php 
                                 
                                 $firma = $firmalar[$a->kid];
                                 $urun = $urunler[$a->type];
                                 $j = j($a->json);
                             ?>
                                 <td>
                                     <input type="checkbox" name="" value="<?php echo e($a->id); ?>" class="stok_cikisi" id="">
                                     
                                 </td>
                                 <td width="100" class="text-center">
                                     <?php echo e($a->id); ?>

                                 </td>
                                 <td><a href="<?php echo e(url("admin/types/musteriler?detay=".$a->kid)); ?>"><?php echo e($firma->title); ?> / <?php echo e($firma->title2); ?></a></td>
                                 <td><?php echo e($urun->title); ?></td>
                                 <td>
                                     <?php urun_ozellikleri($j) ?>
                                 </td>
                                 <td><?php echo e($a->html); ?></td>
                                 <td><?php echo e(nf($a->qty)); ?></td>
                                 <td width="100">
                                     <?php 
                                   //  print2($stok_cikis_sayim);
                                     
                                     
                                     ?>
                                     <?php echo e(nf($stok_cikisi)); ?>

                                     <hr>
                                     <?php echo e(nf($stok_metre,"MT")); ?>

                                 </td>
                                 <td width="100">
                                     <?php echo e(nf($a->qty-$stok_cikisi)); ?>

                                     <hr>
                                     <?php echo e(nf($kalan_metre,"MT")); ?>

                                 </td>
                                 <td>
                                     <?php echo e(date("d.m.Y",strtotime($a->date))); ?>

                                 </td>
                                 <td>
                                  
                                     <select name="title" id="<?php echo e($a->id); ?>" table="siparisler"  class="form-control edit">
                                         <option value="">Seçiniz</option>
                                         <?php foreach($siparis_durumlari AS $d) { 
                                           ?>
                                          <option value="<?php echo e($d); ?>" <?php if($a->title==$d) echo "selected"; ?>><?php echo e($d); ?></option> 
                                          <?php } ?>
                                     </select>
                                 </td>
                                 <td>
                                 <div class="dropdown">
                                     <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                         <i class="fa fa-cog"></i>
                                     </button>
                                     <div class="dropdown-menu">
                                         <a href="<?php echo e(url("admin/types/stok-cikislari?ids=".$a->id)); ?>" class="btn btn-primary  dropdown-item"><i class="fa fa-cubes"></i> <?php echo e(e2("Stok Çıkışı")); ?></a>
                                         
                                         <a href="?cogalt=<?php echo e($a->id); ?>"  class="btn btn-success dropdown-item" title=""><i class="fa fa-copy"></i> <?php echo e(e2("Çoğalt")); ?></a>
                                         <a href="?ajax=print-siparis2&id=<?php echo e($a->id); ?>&siparis-emri" target="_blank" class="btn btn-success dropdown-item" title=""><i class="fa fa-print"></i> <?php echo e(e2("Sipariş Emri Yazdır")); ?></a>
                                         <a href="?ajax=print-siparis2&id=<?php echo e($a->id); ?>" target="_blank" class="btn btn-success dropdown-item" title=""><i class="fa fa-print"></i> <?php echo e(e2("Tüm Zamanların Stok Çıkışlarını Yazdır")); ?></a>
                                         <a href="?ajax=print-siparis2&id=<?php echo e($a->id); ?>&bugun" target="_blank" class="btn btn-success dropdown-item" title=""><i class="fa fa-print"></i> <?php echo e(e2("Bugünkü Stok Çıkışlarını Yazdır")); ?></a>
                                         <a href="?duzenle=<?php echo e($a->id); ?>" class="btn btn-info dropdown-item"><i class="fa fa-edit"></i> <?php echo e(e2("Düzenle")); ?></a>
                                         <?php echo e(admin_delete($a->id)); ?>

                                          </div>
                                 </div>
                                     <div class="btn-group">
                                     </div>
                                 </td>
 								
 							</tr>  
                         <?php } ?>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
					</table> <?php echo e($alt->fragment('alt')->appends(request()->query())->links()); ?>

				</div>
			</div>
		</div>
	</div>
</div><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin/type/siparisler.blade.php ENDPATH**/ ?>