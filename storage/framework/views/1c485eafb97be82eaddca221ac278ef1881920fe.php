
<?php 
$urunler = contents_to_array("Ürünler");
$musteri = c(get("detay"));
$stok_cikislari = db("stok_cikislari")->where("musteri_id",get("detay"))->orderBy("id","DESC")->get();
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
    <script>
        window.print();
    </script>
</head>
<body>
<div class="print text-center">
       
       <table class="table text-center">
           <tr>
               <td>
                   <img src="<?php echo e(url("logo.svg")); ?>" class="m-5" width="300" alt="">
               </td>
               <td style="vertical-align:middle">
                  <h1><?php echo e($musteri->title); ?> / <?php echo e($musteri->title2); ?></h1>
               </td>
           </tr>
       </table>
        <table class="table">
            <tr>
                
                <th>Tarih</th>
                <th>Barkod</th>
                <th>Ürün</th>
                <th>Miktar</th>
            </tr>
            <?php foreach($stok_cikislari AS $s)  { 
                $stok = j($s->stok);
                $siparis = j($s->siparis);
                $urun = $urunler[$siparis['type']];
                ?>
                <tr>
                   
                    <td><?php echo e(date("d.m.Y H:i",strtotime($s->created_at))); ?></td>
                    <td>
                        <a href="?ajax=print-stok&id=<?php echo e($stok['slug']); ?>&noprint" title="<?php echo e($stok['slug']); ?> Barkoduna Ait Bilgiler" class="ajax_modal"><?php echo e($stok['slug']); ?></a>
                    </td>
                    <td><?php echo e($urun->title); ?></td>
                    <td><?php echo e($s->qty); ?></td>
                </tr> 
                <?php } ?>
        </table>
</div><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin-ajax/print-musteri-stok-cikis.blade.php ENDPATH**/ ?>