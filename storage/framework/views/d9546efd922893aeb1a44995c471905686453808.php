<?php 
$firmalar = contents_to_array("Müşteriler");
$urunler = contents_to_array("Ürünler");
$stok_cikis_sayim = stok_cikis_sayim();
 ?>
<div class="content">
    <div class="row">
        
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
                        

						<tbody> <?php $__currentLoopData = $alt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <tr class="" id="t<?php echo e($a->id); ?>">
                            <?php $firma = $firmalar[$a->kid];
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
                                <td><?php echo e($a->qty); ?></td>
                                <td>
                                    <?php 
                                  //  print2($stok_cikis_sayim);
                                    $stok_cikisi = 0;
                                    if(isset($stok_cikis_sayim[$a->id])) {
                                        $stok_cikisi = $stok_cikis_sayim[$a->id];
                                    } 
                                    ?>
                                    <?php echo e($stok_cikisi); ?>

                                </td>
                                <td>
                                    <?php echo e($a->qty-$stok_cikisi); ?>

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
                                    <div class="btn-group">
                                        <?php echo e(admin_delete($a->id)); ?>

                                        <a href="?ajax=print-siparis2&id=<?php echo e($a->id); ?>" target="_blank" class="btn btn-success"><i class="fa fa-print"></i></a>
                                        <a href="?duzenle=<?php echo e($a->id); ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                    </div>
                                </td>
								
							</tr> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
					</table> <?php echo e($alt->fragment('alt')->appends(request()->query())->links()); ?>

				</div>
			</div>
		</div>
	</div>
</div><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin/type/siparisler.blade.php ENDPATH**/ ?>