<?php 
$user = u();
$urunler = contents_to_array("Ürünler"); 
$users = usersArray();
?>
<div class="content">
    <div class="row">
    <?php echo e(col("col-md-12","Yeni Stok Kartı",3)); ?>

    
    <?php 
    if(getisset("sil")) {
        db("stoklar")->where("id",get("sil"))
        ->whereNull("cikis")
        ->delete();
        echo "ok";
        exit();
    }
    if(getisset("ekle")) {
        $post = $_POST;
        $net = $post['qty'] - $post['dara'];
        $qty = $post['qty'];
        $dara = $post['dara'];
        $type = $post['type'];

        unset($post['_token']);
        unset($post['type']);
        unset($post['qty']);
        unset($post['dara']);
        $id = 1;
        
        $son_id = db("stoklar")->orderBy("id","DESC")->first();
        if($son_id) {
            $id = $son_id -> id;
        }
        $barcode = date("Ymdhi").$id;
        ekle([
            "type" => $type,
            "slug" => $barcode,
            "qty" => $qty,
            "dara" => $dara,
            "net" => $net,
            "json" => json_encode_tr($post)
        ],"stoklar");
        bilgi("Stok girişi başarıyla oluşturuldu");
    } ?>
   
        <form action="?ekle" method="post" class="">
            <?php echo e(csrf_field()); ?>

            
            <?php echo e(e2("ÜRÜN:")); ?>

            <select name="type" required class="form-control select2 urun-sec" required id="">
                    <option value="">Seçiniz</option>
                <?php foreach($urunler AS $u) { ?>
                    <option value="<?php echo e($u->id); ?>"><?php echo e($u->title); ?></option>
                <?php } ?>
            </select>
            <div class="alt-detay"></div>
            <?php echo e(e2("DARA KG")); ?>

            <input type="number"  name="dara" step="any" class="form-control" value="0" id="dara">
            <?php echo e(e2("KANTAR KG")); ?> 
            <div class="badge badge-success baglanti-ok d-none">Bağlantı başarılı!</div>
            <div class="badge badge-info baglanti-false d-none">Kantar'dan veri okuma başarısız lütfen sağ taraftaki bağlan tuşundan kantarın bağlı olduğu portu seçiniz!</div>
            <div class="input-group">
                <input type="number"  name="qty" step="any" class="form-control" value="0" id="qty">
                <div class="btn btn-success baglan" onclick="serialScaleController.init();"><i class="fa fa-plug"></i> Bağlan</div>
         </div>

            <button class="btn btn-primary mt-10" type="submit"><?php echo e(e2("Ekle")); ?></button>
            <script>
                $(function(){
                    $(".urun-sec").on("change",function(){
                        $(".alt-detay").html("Yükleniyor...");
                        $.get("?ajax=urun-alt-detay",{
                            id : $(this).val()
                        },function(d){
                            $(".alt-detay").html(d);
                        });
                        
                    });
                    $(".urun-sec2").on("change",function(){
                        if($(this).val()!="") {
                            $(".alt-detay2").html("Yükleniyor...");
                            $.get("?ajax=urun-alt-detay2",{
                                id : $(this).val()
                            },function(d){
                                $(".alt-detay2").html(d);
                            });
                        }
                        
                        
                    });
                }); 
            </script>
        </form>
    <?php echo e(_col()); ?>

    <?php echo e(col("col-md-12","Filtrele")); ?>

       <form action="" method="get" class="filtre">
            <?php echo e(e2("ÜRÜN:")); ?>

            <select name="type" class="form-control select2 urun-sec2" id="">
                    <option value=""><?php echo e(e2("Tümü")); ?></option>
                <?php foreach($urunler AS $u) { ?>
                    <option value="<?php echo e($u->id); ?>"><?php echo e($u->title); ?></option>
                <?php } ?>
            </select>
            <div class="alt-detay2"></div>
           
            <br>
            <div class="row">
                <div class="col-md-4">
                    <?php echo e(e2("DURUM")); ?> :  <br>
                    <select name="durum" id="" class="form-control">
                        <?php $durum = explode(",","Tümü,Gönderildi,Depoda") ?>
                        <?php foreach($durum AS $d)  { 
                          ?>
                         <option value="<?php echo e($d); ?>" <?php if(getesit("durum",$d)) echo "selected"; ?>><?php echo e(e2($d)); ?></option> 
                         <?php } ?>
                       
                        
                    </select>
                </div>
                <div class="col-md-4">
                    <?php echo e(e2("SIRALA")); ?> :  <br>
                    <div class="input-group">
                        <select name="order" id="" class="form-control">
                            <?php $durum = explode(",","EN,GRAMAJ,METRE") ?>
                            <option value=""><?php echo e(e2("Sıralama Yok")); ?></option>
                            <?php foreach($durum AS $d)  { 
                            ?>
                            <option value="<?php echo e($d); ?>" <?php if(getesit("order",$d)) echo "selected"; ?>><?php echo e(e2($d)); ?></option> 
                            <?php } ?>
                        
                            
                        </select>
                        <select name="by" id="" class="form-control">
                            <?php $durum = explode(",","Küçükten Büyüğe,Büyükten Küçüğe") ?>
                            <?php foreach($durum AS $d)  { 
                            ?>
                            <option value="<?php echo e($d); ?>" <?php if(getesit("by",$d)) echo "selected"; ?>><?php echo e(e2($d)); ?></option> 
                            <?php } ?>
                        
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php echo e(e2("FİLTRELE")); ?> :
                    <div class="input-group">
                        <input type="number" name="satir" min="1" max="100000" value="20" class="form-control" title="<?php echo e(e2("Sayfa başına düşen satır sayısı")); ?>" name="" id="">
                        <button class="btn btn-primary" name="filtre" value="ok"><?php echo e(e2("Filtrele")); ?></button>
                    </div>
                </div>
            </div>
            
            
            <script>
                
                <?php if(getisset("filtre")) {
 ?>
    $(".urun-sec2").val("<?php echo e(get("type")); ?>");
    window.setTimeout(function(){
        $(".urun-sec2").trigger("change");
       window.setTimeout(function(){
        <?php 
        
        foreach($_GET AS $alan => $deger)  {
            if($alan!="type") {
                if($alan=="ROLL_NO") {
                    if($deger!="")  { 
                     
                      ?>
                      var newOption = new Option("<?php echo e($deger); ?>", "<?php echo e($deger); ?>", true, true);
                     $(".filtre [name='<?php echo e($alan); ?>']").append(newOption).trigger('change'); 
                     <?php } ?>
                     <?php 
                }
             ?>
             $(".filtre [name='<?php echo e($alan); ?>']").val("<?php echo e($deger); ?>").trigger("change");
             <?php 
            }
        } ?>
       },1000);
    },500);
 <?php  
                } ?>
            </script>
       </form> 
    <?php echo e(_col()); ?>

    <?php echo e(col("col-md-12","Geçmiş Stok Girişleri",3)); ?> 
    <div class="float-right">
        <a href="" class="btn btn-primary"><i class="fa fa-sync"></i> <?php echo e(e2("Değişiklikleri Görmek İçin Yenileyin")); ?></a>
    </div>
    <?php $stoklar = db("stoklar");
    
    if(getisset("q")) {
       // $stoklar = where("slug")
       $deger = "%".trim(get("q"))."%";
       $q = get("q");
       
      
        
        $urunlerdb = db("contents")->where("title","like","%{$_GET['q']}%")->where("type","Ürünler")->get();
        if($urunlerdb) {
            $urunlerdizi = array();
            foreach($urunlerdb AS $udb) {
                array_push($urunlerdizi,$udb->id);
            }
        //    print2($urunlerdizi);
            $stoklar = $stoklar->whereIn("type",$urunlerdizi);
        }
        
        $stoklar = $stoklar->orwhere(function($query) use($deger,$q){
               $query->orWhere("slug",$q);
               $query->orWhere("json","like",$deger);
        });
        
        

    }
    if(getisset("filtre")) {
        $get = $_GET;
        if(!getesit("type","")) {
            $stoklar = $stoklar->where("type",get("type"));
        }
        if(getesit("durum","Gönderildi")) {
            $stoklar = $stoklar->whereNotNull("cikis");
        }
        if(getesit("durum","Depoda")) {
            $stoklar = $stoklar->whereNull("cikis");
        }
        
        unset($get['filtre']);
        unset($get['type']);
        unset($get['satir']);
        unset($get['page']);
        unset($get['durum']);
        unset($get['by']);
        unset($get['order']);
        $stoklar = $stoklar->where(function($query) use($get){
            foreach($get AS $alan => $deger) {
                if($deger !="") {
                    if($alan=="ROLL_NO") {
                    
                    
                        $query->where("json","like","%$deger%");
                    } else {
                        $tire = explode("-",$deger);
                        if(count($tire)>1) {
                            $query->where("json->$alan",">=",$tire[0]);
                            $query->where("json->$alan","<=",$tire[1]);
                        } else {
                            $query->where("json->$alan",$deger);
                        }
                        
                    }
                   
                }
                    
            }
        });
    }
    $satir = 20;
    if(getisset("satir")) {
        $satir = get("satir");
    }
   // echo $stoklar->toSql();
   if(!getesit("order","")) {
       $by = "ASC";
       if(getesit("by","Büyükten Küçüğe")) {
           $by = "DESC";
       }
       $stoklar = $stoklar->orderBy("json->".get("order"),$by);
   } else {
    $stoklar = $stoklar->orderBy("id","DESC");
   }
    $stoklar = $stoklar->simplePaginate($satir); ?>
    <form action="" method="get">
        <input type="text" name="q" placeholder="<?php echo e(e2("Ara...")); ?>" value="<?php echo e(get("q")); ?>" id="" class="form-control">

    </form>
    <div class="table-responsive">
        <table class="table" id="excel">
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
            <?php 
            $sayim = array();
            $sayim['dara'] = 0;
            $sayim['qty'] = 0;
            $sayim['net'] = 0;
            foreach($stoklar AS $stok) { 
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
                        
                        $int = (int) $deger;
                        if(is_integer($int)) {
                            if(!isset($sayim[$alan])) $sayim[$alan] = 0;
                            $sayim[$alan] += $int;
                        } else {
                            if(!isset($sayim[$alan][$deger])) $sayim[$alan][$deger] = 0;
                            $sayim[$alan][$deger]++;
                        }
                                                    ?>
                            <div class="badge badge-primary">
                            <strong><?php echo e($alan); ?></strong> : <?php echo e($deger); ?> </div>

                            <?php 
                    }
                    $sayim['dara'] += $stok->dara;
                    $sayim['qty'] += $stok->qty;
                    $sayim['net'] += $stok->net;
                   ?>
                </td>
                <td><?php echo e($stok->dara); ?></td>
                <td><?php echo e($stok->qty); ?></td>
                <td><?php echo e($stok->net); ?></td>
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
                    <div class="no-print">
                    <?php if($user->level=="Admin") {
                         ?>
                         <?php if($stok->cikis=="")  { 
                          ?>
                          <a href="?sil=<?php echo e($stok->id); ?>" ajax="#t<?php echo e($stok->id); ?>" teyit="<?php echo e(e2("Bu stok bilgisini silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!")); ?>" class="btn btn-danger"><i class="fa fa-times"></i></a>
                          <?php } ?>
                          <?php 
                    } ?>
                    <a href="?ajax=print-stok&id=<?php echo e($stok->id); ?>" target="_blank" class="btn btn-success">
                        <i class="fa fa-print"></i>
                    </a>
                    </div>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <th>
                    <?php if(isset($sayim['METRE'])) {
                        echo nf($sayim['METRE'],"METRE");
                    } ?>
                </th>
                <th><?php echo e(nf($sayim['dara'])); ?></th>
                <th><?php echo e(nf($sayim['qty'])); ?></th>
                <th><?php echo e(nf($sayim['net'])); ?></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <?php //print2($sayim); ?>
        <?php echo e($stoklar->appends(request()->query())->links()); ?>

    </div>
    <?php echo e(_col()); ?>

    </div>
</div>

<script>
    
    "use strict";
    class SerialScaleController {
        constructor() {
            this.encoder = new TextEncoder();
            this.decoder = new TextDecoder();
        }
        async init() {
            if ('serial' in navigator) {
                try {
                    const port = await navigator.serial.requestPort();
                    await port.open({ baudRate: 9600 });
                    this.reader = port.readable.getReader();
                    let signals = await port.getSignals();
                    console.log(signals);
                    $(".baglanti-false").addClass("d-none");
                    $(".baglanti-ok").removeClass("d-none");
                }
                catch (err) {
                    $(".baglanti-false").removeClass("d-none");
                    $(".baglanti-ok").addClass("d-none");
                    console.error('There was an error opening the serial port:', err);
                }
            }
            else {
                console.error('Web serial doesn\'t seem to be enabled in your browser. Try enabling it by visiting:');
                console.error('chrome://flags/#enable-experimental-web-platform-features');
                console.error('opera://flags/#enable-experimental-web-platform-features');
                console.error('edge://flags/#enable-experimental-web-platform-features');
            }
        }
        async read() {
            try {
                const readerData = await this.reader.read();
            //    console.log(readerData)
                return this.decoder.decode(readerData.value);
            }
            catch (err) {
                const errorMessage = `hata algılandı: ${err}`;
              //  console.error(errorMessage);
                return errorMessage;
            }
        }
    }

    const serialScaleController = new SerialScaleController();
    const connect = document.getElementById('connect-to-serial');
    const getSerialMessages = document.getElementById('get-serial-messages');

   
    function baglan() {
        console.log("baglan");
        serialScaleController.init();
    }
    /*
    window.setTimeout(function(){
        $(".baglan").trigger("click");
        baglan();

    },1000);
    */
    
  

    async function getSerialMessage() {
        try {
                var deger = await serialScaleController.read();
                var regex = /[+-]?\d+(\.\d+)?/g;
                var float = deger.match(regex).map(function(v) { return parseFloat(v); });
               // console.log(float);
                $("#qty").val(float);
            }
            catch (err) {
                const errorMessage = `hata algılandı: ${err}`;
              //  console.error(errorMessage);
                return errorMessage;
            }
        
        
    }
    window.setInterval(function(){
        getSerialMessage();
    },100);
    
  </script><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin/type/stoklar.blade.php ENDPATH**/ ?>