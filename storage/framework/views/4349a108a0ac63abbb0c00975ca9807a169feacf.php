<?php 
$urunler = contents_to_array("Ürünler"); 
$musteriler = contents_to_array("Müşteriler"); 
$stok_cikis_sayim = stok_cikis_sayim();
$stok_metre_sayim = stok_metre_sayim();
$users = usersArray();
$user = u();
?>
<div class="content">
    <img src="<?php echo e(url("logo.svg")); ?>" style="    position: absolute;
    width: 300px;
    top: 20px;
    left: 20px;" class="yesprint" alt="">
    <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-<?php echo e($c->icon); ?>"></i> <?php echo e(e2("Filtrele")); ?></h3>
            </div>
            <div class="block-content">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                        <?php echo e(e2("MÜŞTERİ")); ?> : 
                            <select name="musteri" id="" class="form-control select2 firma-sec">
                                <option value=""><?php echo e(e2("TÜMÜ")); ?></option>
                                <?php $musteri = contents_to_array("Müşteriler"); foreach($musteri AS $m) { ?>
                                <option value="<?php echo e($m->id); ?>"><?php echo e($m->title); ?> / <?php echo e($m->title2); ?></option>
                                <?php } ?>
                            </select>
                        
                            <div class="detay"></div>

                        </div>
                        <div class="col-md-6">
                            <?php echo e(e2("ÜRÜN")); ?> : 
                            <select name="urun" id="" class="form-control select2">
                                <option value=""><?php echo e(e2("TÜMÜ")); ?></option>
                                <?php $sorgu = contents_to_array("Ürünler"); foreach($sorgu AS $m) { ?>
                                <option value="<?php echo e($m->id); ?>"><?php echo e($m->title); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php echo e(e2("İŞLEM TARİHİ BAŞLANGIÇ")); ?> : 
                            <input type="date" name="date1" value="<?php echo e(ed(get("date1"),"")); ?>" id="" class="form-control">
                            <?php echo e(e2("İŞLEM TARİHİ BİTİŞ")); ?> : 
                            <input type="date" name="date2"  value="<?php echo e(ed(get("date2"),"")); ?>" id="" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <?php echo e(e2("TERMİN BAŞLANGIÇ")); ?> : 
                            <input type="date" name="tdate1" value="<?php echo e(ed(get("tdate1"),"")); ?>" id="" class="form-control">
                            <?php echo e(e2("TERMİN BİTİŞ")); ?> : 
                            <input type="date" name="tdate2" value="<?php echo e(ed(get("tdate2"),"")); ?>" id="" class="form-control">
                        </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary mt-10 noprint" name="filtre" value="ok"><?php echo e(e2("FİLTRELE")); ?></button>
                        </div>
                    </div>
                    
                   
                    
                    
                    

                </form>
            </div>
            <script>
                $(function(){
                    <?php foreach($_GET AS $alan => $deger) {
                         ?>
                         $("[name='<?php echo e($alan); ?>']").val("<?php echo e($deger); ?>");
                         <?php 
                    } ?>
                });
            </script>
            

        </div>
        <div class="row">
            <?php if(getisset("filtre")) { 
              ?>
                <?php echo e(col("col-md-12","Filtreye Göre Çıkan Siparişler",3)); ?>

                <?php 
                $sorgu = db("siparisler");
                if(!getesit("musteri","")) $sorgu = $sorgu->where("kid",get("musteri"));
                if(!getesit("urun","")) $sorgu = $sorgu->where("type",get("urun"));
                if(!getesit("date1","")) {
                    $sorgu = $sorgu->WhereBetween('created_at', [get("date1"), get("date2")]);
                }
                if(!getesit("tdate1","")) {
                    $sorgu = $sorgu->WhereBetween('date', [get("tdate1"), get("tdate2")]);
                }
                
                $sorgu = $sorgu->orderBy("id","DESC");
                $sorgu = $sorgu->get();
               // print2($sorgu);
               $toplam = $sorgu->count();
               $alt_toplam = 0;
               $sevk_toplam = 0;
               $kalan_toplam = 0;
                ?>
                    <?php echo e(bilgi("Yapmış olduğunuz filtreye göre $toplam sipariş döndürüldü")); ?>

                    <div class="float-right">
                        <div class="btn btn-success noprint" onclick="window.print()"><i class="fa fa-print"></i> Yazdır</div>
                    </div>
                    <div class="table-responsive yazdir">
                        <table class="table" id="excel">
                            <tr>
                                <th><?php echo e(e2("Sipariş Kodu")); ?></th>
                                <th><?php echo e(e2("İşlem Tarihi")); ?></th>
                                <th><?php echo e(e2("Firma Adı")); ?></th>
								<th><?php echo e(__("Ürün Adı")); ?></th>
                                <th><?php echo e(e2("Ürün Özellikleri")); ?></th>
                                <th><?php echo e(e2("Sipariş Notları")); ?></th>
                                <th><?php echo e(e2("Sipariş Miktarı")); ?></th>
                                <th><?php echo e(e2("Sevk Edilen")); ?></th>
                                <th><?php echo e(e2("Kalan Miktar")); ?></th>
                                <th><?php echo e(e2("Termin Tarihi")); ?></th>
                                <th><?php echo e(e2("Personel")); ?></th>
                                <th><?php echo e(e2("Durum")); ?></th>
                            </tr>
                            <?php foreach($sorgu AS $s) { 
                                $alt_toplam += $s->qty;
                                
                                $firma = $musteriler[$s->kid];
                                $urun = $urunler[$s->type];
                                $j = j($s->json);
                                $user = $s->id;
                                if(isset($users[$s->uid])) {
                                    $user = $users[$s->uid];
                                    $user = $user->name . " " . $user->surname;
                                }
                                
                                $sayim = 0;
                                $metre_sayim = 0;
                                if(isset($stok_cikis_sayim[$s->id])) {
                                    $sayim = $stok_cikis_sayim[$s->id];
                                }
                                if(isset($stok_metre_sayim[$s->id])) {
                                    $metre_sayim = $stok_metre_sayim[$s->id];
                                }
                                $kalan_metre = 0;
                                if(isset($j['METRE'])) {
                                    $kalan_metre = $metre_sayim - $j['METRE']; 
                                }
                                $sevk_toplam += $sayim;
                                $kalan_toplam += ($s->qty - $sayim);
                              ?>
                             <tr class="<?php if($s->qty - $sayim<0) echo "table-danger"; ?>">
                                 <td><?php echo e($s->id); ?></td>
                                 <td><?php echo e(date("d.m.Y H:i",strtotime($s->created_at))); ?></td>
                                 <td><?php echo e($firma->title); ?> / <?php echo e($firma->title2); ?></td>
                                 <td><?php echo e($urun->title); ?></td>
                                 <td>
                                 <?php urun_ozellikleri($j); ?>
                                 </td>
                                 <td><?php echo e($s->html); ?></td>
                                 <td><?php echo e(nf($s->qty)); ?>

                                    <hr>
                                    <?php echo e(nf(@$j['METRE'],"MT")); ?>


                                 </td>
                                 <td>
                                     <?php echo e(nf($sayim)); ?>

                                    <hr>
                                    <?php echo e(nf($metre_sayim,"MT")); ?>


                                 </td>
                                 <td><?php echo e(nf($s->qty - $sayim)); ?>

                                    <hr>
                                    <?php echo e(nf($kalan_metre,"MT")); ?>

                                 </td>
                                 <td><?php echo e(date("d.m.Y",strtotime($s->date))); ?></td>
                                 <td><?php echo e($user); ?></td>
                                 <td><?php echo e($s->title); ?></td>
                             </tr> 
                             <?php } ?>
                             <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php echo e(nf($alt_toplam)); ?></th>
                                        <th><?php echo e(nf($sevk_toplam)); ?></th>
                                        <th><?php echo e(nf($kalan_toplam)); ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                        </table>
                    </div>
                <?php echo e(_col()); ?> 
                <?php echo e(col("col-md-12","Filtreye Göre Stok Girişleri",9)); ?>

                <?php 
                $stoklar = db("stoklar")
                ->where("type",get("urun"));
                if(!getesit("date1","")) {
                    $stoklar = db("stoklar")->WhereBetween('created_at', [get("date1"), get("date2")]);
                }
                $stoklar = $stoklar->get();
                $toplam = $stoklar->count();
                $alt_toplam = 0;
                ?>
                    <?php echo e(bilgi("Yapmış olduğunuz sorguya göre $toplam stok girişi döndürüldü")); ?>

                    <table class="table">
                                    <tr>
                                        <th><?php echo e(e2("STOK NO")); ?></th>
                                        <th><?php echo e(e2("BARKOD")); ?></th>
                                        <th><?php echo e(e2("ÜRÜN ADI")); ?></th>
                                        <th><?php echo e(e2("ÜRÜN ÖZELLİKLERİ")); ?></th>
                                        <th><?php echo e(e2("DARA KG")); ?></th>
                                        <th><?php echo e(e2("KANTAR KG")); ?></th>
                                        <th><?php echo e(e2("NET KG")); ?></th>
                                        <th><?php echo e(e2("İŞLEM TARİHİ")); ?></th>
                                        <th><?php echo e(e2("PERSONEL")); ?></th>
                                        <th><?php echo e(e2("DURUM")); ?></th>
                                        <th><?php echo e(e2("İŞLEM")); ?></th>
                                    </tr>
                                    <?php foreach($stoklar AS $stok) { 
                                        $alt_toplam += $stok->net;
                                        $j = j($stok->json);
                                        $urun = $urunler[$stok->type];
                                        
                                        $u = @$users[$stok->uid];
                                        ?>
                                    <tr id="t<?php echo e($stok->id); ?>">
                                        <td><?php echo e($stok->id); ?></td>
                                        <td><?php echo e($stok->slug); ?></td>
                                        <td><?php echo e($urun->title); ?></td>
                                        <td>
                                            <?php foreach($j AS $alan => $deger) {
                                                $alan = str_replace("_"," ",$alan);
                                                    ?>
                                                    <div class="badge badge-primary">
                                                    <strong><?php echo e($alan); ?></strong> : <?php echo e($deger); ?> </div>

                                                    <?php 
                                            } ?>
                                        </td>
                                        <td><?php echo e(nf($stok->dara)); ?></td>
                                        <td><?php echo e(nf($stok->qty)); ?></td>
                                        <td><?php echo e(nf($stok->net)); ?></td>
                                        <td><?php echo e(date("d.m.Y H:i",strtotime($stok->created_at))); ?></td>
                                        <td><?php echo e($u->name); ?> <?php echo e($u->surname); ?></td>
                                        <td><?php if($stok->cikis!="") {
                                            ?>
                                            <div class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <?php 
                                        } ?></td>
                                        <td>
                                            
                                            <a href="?ajax=print-stok&id=<?php echo e($stok->id); ?>" target="_blank" class="btn btn-success">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php echo e(nf($alt_toplam)); ?></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </table>
                            <?php echo e(_col()); ?>

                            <?php echo e(col("col-md-12","Filtreye Göre Stok Çıkışları",15)); ?>

                            <?php $stoklar = db("stok_cikislari");
                            if(!getesit("date1","")) {
                                $stoklar = db("stok_cikislari")->WhereBetween('created_at', [get("date1"), get("date2")]);
                            }
                            if(!getesit("urun","")) $stoklar = $stoklar->where("siparis->type",get("urun"));
                            if(!getesit("musteri","")) $stoklar = $stoklar->where("musteri_id",get("musteri"));
                      
                            $stoklar = $stoklar->get(); 
                            $toplam = $stoklar->count();
                            $alt_toplam = 0;
                            ?>
                              <?php echo e(bilgi("Yapmış olduğunuz sorguya göre $toplam stok çıkışı döndürüldü")); ?>

                            <table class="table">
                                <tr>
                                    <th><?php echo e(e2("STOK ÇIKIŞ NO")); ?></th>
                                    <th><?php echo e(e2("İŞLEM TARİHİ")); ?></th>
                                    <th><?php echo e(e2("FİRMA")); ?></th>
                                    <th><?php echo e(e2("SİPARİŞ BİLGİSİ")); ?></th>
                                    <th><?php echo e(e2("STOK BİLGİSİ")); ?></th>
                                    <th><?php echo e(e2("MİKTAR")); ?></th>
                                   
                                </tr>
                                <?php foreach($stoklar AS $s) {
                                    $alt_toplam += $s->qty;
                                    $firma = j($s->musteri);
                                    $stok = j($s->stok);
                                    $siparis = j($s->siparis);
                                    $urun = $urunler[$siparis['type']];
                                    ?>
                                <tr>
                                    <td><?php echo e($s->id); ?></td>
                                    <td><?php echo e(date("d.m.Y H:i",strtotime($s->created_at))); ?></td>
                                    <td><?php echo e($firma['title']); ?> / <?php echo e($firma['title2']); ?>

                                
                                    </td>
                                    <td><?php echo e($urun->title); ?> / <?php echo e(date("d.m.Y H:i",strtotime($siparis['created_at']))); ?></td>
                                    <td>
                                    <a href="?ajax=print-stok&id=<?php echo e($stok['slug']); ?>&noprint" title="<?php echo e($stok['slug']); ?> Barkoduna Ait Bilgiler" class="ajax_modal"><?php echo e($stok['slug']); ?></a>
                                </td>
                                    <td><?php echo e(nf($s->qty)); ?></td>
                                   
                                </tr>
                            <?php } ?>
                                <tr>
                                    <th  colspan="6" class="text-right"><?php echo e(nf($alt_toplam)); ?></th>
                                </tr>
                            </table>
                <?php echo e(_col()); ?>

             <?php } ?>
    </div>
    </div>
    
</div>
<script>
                $(function(){
                    $(".firma-sec").on("change",function(){
                        $(".detay").html("Yükleniyor...");
                        $.get("?ajax=siparisler",{
                            id : $(this).val()
                        },function(d){
                            $(".detay").html(d);
                        });
                        
                    });
                }); 
            </script>
           <?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin/type/raporlar.blade.php ENDPATH**/ ?>