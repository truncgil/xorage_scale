<?php echo e(col("col-md-12","Yeni Sipariş Formu")); ?>

        <?php if(getisset("ekle")) {
            $post = $_POST;
            unset($post['_token']);
            unset($post['kid']);
            unset($post['type']);
            unset($post['date']);
            unset($post['html']);
            ekle([
                "kid" => post("kid"),
                "qty" => post("qty"),
                "type" => post("type"),
                "html" => post("html"),
                "json" => json_encode_tr($post),
                "date" => post("date")
            ],"siparisler");
            bilgi("Sipariş başarıyla oluşturuldu");
        }
        if(getisset("guncelle")) {
            $post = $_POST;
            unset($post['_token']);
            unset($post['kid']);
            unset($post['type']);
            unset($post['date']);
            unset($post['html']);
            db("siparisler")
            ->where("id",post("id"))
            ->update([
                "kid" => post("kid"),
                "qty" => post("qty"),
                "type" => post("type"),
                "html" => post("html"),
                "json" => json_encode_tr($post),
                "date" => post("date")
            ]);
            bilgi("{$_POST['id']} Numaralı sipariş başarıyla güncellendi");
        }
        $action= "?ekle";
        $btn_text = "Siparişi Oluştur";
        $html = "";
        if(getisset("duzenle")) {
            $siparis = db("siparisler")->where("id",get("duzenle"))->first();
            $action = "?guncelle";
            $btn_text = "Siparişi Güncelle";
            $html = $siparis->html;
        }
         ?>
            <form action="<?php echo e($action); ?>" method="post">
                <?php if(getisset("duzenle")) {
                     ?>
                     <input type="hidden" name="id" value="<?php echo e(get("duzenle")); ?>">
                     <?php 
                } ?>
                <?php echo e(csrf_field()); ?>

                <?php echo e(e2("FİRMA ÜNVANI")); ?>

                <select name="kid" class="form-control select2" required id="kid">
                        <option value="">Seçiniz</option>
                    <?php foreach($firmalar AS $f) { ?>
                        <option value="<?php echo e($f->id); ?>"><?php echo e($f->title); ?> / <?php echo e($f->title2); ?></option>
                    <?php } ?>
                </select>
                <?php echo e(e2("ÜRÜN:")); ?>

                <select name="type" class="form-control select2 urun-sec" required id="type">
                        <option value="">Seçiniz</option>
                    <?php foreach($urunler AS $u) { ?>
                        <option value="<?php echo e($u->id); ?>"><?php echo e($u->title); ?></option>
                    <?php } ?>
                </select>
                <div class="alt-detay"></div>
                <?php echo e(e2("SİPARİŞ MİKTARI (KG): ")); ?>

                <input type="number" class="form-control" name="qty" step="any" value="" required id="qty">
                <?php echo e(e2("SİPARİŞ NOTLARI: ")); ?>

                <textarea name="html" id="html" cols="30" rows="10" class="form-control"><?php echo e($html); ?></textarea>
                <?php echo e(e2("TERMİN TARİHİ (HEDEFLENEN YÜKLEME TARİHİ)")); ?>:
                <input type="date" name="date" required class="form-control" id="date">
                <button class="mt-10 btn btn-primary"><?php echo e($btn_text); ?></button>
            </form>
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
                    <?php if(getisset("duzenle"))  {
                        
                         $j = j($siparis->json);
                         foreach($j AS $alan=> $deger) {
                              ?>
                            //  $("")
                              <?php 
                         }
                         ?>
                         $("#qty").val("<?php echo e($siparis->qty); ?>");
                        // $("#html").val("<?php echo e($siparis->html); ?>");
                         $("#type").val("<?php echo e($siparis->type); ?>").trigger("change");
                         $("#kid").val("<?php echo e($siparis->kid); ?>");
                         $("#date").val("<?php echo e($siparis->date); ?>");
                         window.setTimeout(function(){
<?php 
    foreach($j AS $alan=> $deger) {
        ?>
    $("[name='<?php echo e($alan); ?>']").val("<?php echo e($deger); ?>");
        <?php 
   }
    ?>
                         },2000);
                         <?php 
                    }?>
                }); 
            </script>
        <?php echo e(_col()); ?><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin/type/siparisler/yeni-siparis-formu.blade.php ENDPATH**/ ?>