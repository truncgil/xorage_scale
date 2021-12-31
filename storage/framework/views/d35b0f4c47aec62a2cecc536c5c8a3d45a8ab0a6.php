<?php $siparis = db("siparisler")->where("id",get("id"))->first();
$siparis_json = j($siparis->json);
$stok_cikis_sayim = @stok_cikis_sayim([get("id")]);
if(isset($stok_cikis_sayim[get("id")])) {
    $sayim = $stok_cikis_sayim[get("id")];
}  else {
    $sayim = 0;
}

$musteri = c($siparis->kid);
$stok_cikislari = db("stok_cikislari")->where("siparis_id",get("id"))->get();
$urunler = contents_to_array("Ürünler");

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Yazdır</title>	
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body {
            background:white;
        }
        .print {
            width:1000px;
            border:solid 1px #c6c6c6;
            padding:10px;
            margin:0 auto;
        }
    </style>
</head>
<body>
    <div class="print text-center">
       
        <table class="table text-center">
            <tr>
                <td>
                    <img src="<?php echo e(url("logo.svg")); ?>" class="m-5" width="300" alt="">
                </td>
                <td style="vertical-align:middle">
                   <h1><?php echo e($musteri->id); ?></h1>
                </td>
            </tr>
        </table>
        <strong><?php echo e(e2("SİPARİŞ NOTLARI")); ?></strong> <br>
        <?php echo e($siparis->html); ?> <br>
        <strong><?php echo e(e2("SİPARİŞ BİLGİSİ")); ?></strong>
        <table class="table table-bordered">
                <tr>
                    <th><?php echo e(e2("ÜRÜN ADI")); ?></th>
                    <td><?php echo e($urunler[$siparis->type]->title); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(e2("SİPARİŞ TARİHİ")); ?></th>
                    <td><?php echo e(date("d.m.Y H:i",strtotime($siparis->created_at))); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(e2("TERMİN TARİHİ")); ?></th>
                    <td><?php echo e(date("d.m.Y",strtotime($siparis->date))); ?></td>
                </tr>
            <?php foreach($siparis_json AS $alan => $deger) {
                $alan = alan_text($alan);
                if($alan=="qty") {
                    $alan = "MİKTAR";
                    $deger = nf($deger) . " KG";
                }
                ?>
                <tr>
                    <th><?php echo e($alan); ?></th>
                    <td><?php echo e($deger); ?></td>
                </tr>
                <?php 
            } ?>
               
        </table>
        <strong><?php echo e(e2("SEVK EDİLEN STOK ÇIKIŞLARI")); ?></strong>
        <table class="table text-center table-bordered">
            <tr>
                <th><?php echo e(e2("ÜRÜN KODU")); ?></th>
                <th><?php echo e(e2("BARKOD")); ?></th>
                <th><?php echo e(e2("ÜRÜN ADI")); ?></th>
                <th><?php echo e(e2("TARİH")); ?></th>
                <th><?php echo e(e2("MİKTAR")); ?></th>
            </tr>
        <?php foreach($stok_cikislari AS $sc)  { 
            $siparis = j($sc->siparis);
            $stok = j($sc->stok);
           $urun_id = $siparis['type'];
            if(isset($urunler[$urun_id])) {
                $urun = $urunler[$urun_id];
          ?>
             <tr>
                <td><?php echo e($urun->id); ?></td>
                <td><?php echo e($stok['slug']); ?></td>
                 <td><?php echo e($urun->title); ?></td>
                 <td><?php echo e(date("d.m.Y H:i",strtotime($sc->created_at))); ?></td>
                 <td><?php echo e(nf($sc->qty)); ?></td>
             </tr> 
             <?php } ?>
         <?php } ?>
        </table>
    </div>
</body>
</html>
<script>
    <?php if(!getisset("noprint")) {
         ?>
         window.print();
         <?php 
    } ?>
</script>


<?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin-ajax/print-siparis2.blade.php ENDPATH**/ ?>