<?php 
$musteriler = contents_to_array("Müşteriler"); 
$urunler = contents_to_array("Ürünler"); 
?>

<?php echo e(col("col-md-12","Yeni Çoklu Stok Çıkışı",3)); ?>

<?php 
$dizi = explode(",",get("ids"));
foreach($dizi AS $deger) {
     $siparis = db("siparisler")->where("id",$deger)->first();
    $musteri = $musteriler[$siparis->kid];
    $urun = $urunler[$siparis->type];
    $siparis_ozellikleri = j($siparis->json);
    //print2($urun);
     
     ?>
     <script>
          $(function(){
               $.get("?ajax=siparis-detay2",{
                    id : "<?php echo e($siparis->type); ?>",
                    siparis_id : "<?php echo e($siparis->id); ?>"
               },function(d){
                    $(".detay<?php echo e($deger); ?>").html(d);
                  
               });
               
              
          });
     </script>
     <table class="table table-bordered">
          <tr>
               <td>
                    <?php echo e(e2("ÜNVAN")); ?>: <br>
                    <strong><?php echo e($musteri->title); ?> <?php echo e($musteri->title2); ?></strong>
               </td>
               <td>
                    <?php echo e(e2("ÜRÜN")); ?>: <br>
                    <strong><?php echo e($urun->title); ?></strong>
               </td>
               <td>
                    <?php echo e(e2("SİPARİŞ BİLGİSİ")); ?>: <br>
                    <?php echo e(urun_ozellikleri($siparis_ozellikleri)); ?>

               </td>
               <td><?php echo e(e2("MİKTAR")); ?>

               <br>
                    <strong><?php echo e(nf($siparis->qty)); ?></strong>
               </td>
               <td width="300">
                    <div class="noprint">
                    <form action="?ekle" method="post" id="<?php echo e($deger); ?>" class="serialize<?php echo e($deger); ?>">
                         <?php echo e(csrf_field()); ?>

                         <input type="hidden" name="firma" value="<?php echo e($musteri->id); ?>">
                         <input type="hidden" name="siparis" value="<?php echo e($deger); ?>">
                         <div class="detay<?php echo e($deger); ?>"></div>
                    </form>
                    </div>

               </td>
               <script>
                    $(function(){
                         $("#satirlar<?php echo e($deger); ?>").html("Yükleniyor...").load("?ajax=siparis-stok-cikisi&id=<?php echo e($deger); ?>");
                         $(".serialize<?php echo e($deger); ?>").on("submit",function(){
                              
                              var bu = $(this);
                              var id= bu.attr("id");
                              var stok = $("#serialize<?php echo e($deger); ?> [name='stok']").val();
                              console.log("stok");
                              console.log(id);
                              bu.find(".right-fixed button").html("İşlem yapılıyor...");
                              bu.find("[type='submit']").html("İşlem yapılıyor...");
                              $.ajax({
                                   type : $(this).attr("method"),
                                   url : $(this).attr("action"),
                                   data : $(this).serialize(),
                                   success: function(d){
                                        var id = bu.attr("id");
                                        $(".detay<?php echo e($deger); ?> option[value='"+stok+"']").remove();
                                        $(".detay<?php echo e($deger); ?> .select2").trigger("change");
                                        $("#satirlar"+id).html("İşleniyor...").load("?ajax=siparis-stok-cikisi&id="+id);
                                   }

                              });
                              
                              return false;

                         });
                    });
               </script>
               <tr>
                    
                    <td colspan="5" id="satirlar<?php echo e($deger); ?>" ></td>
               </tr>
          </tr>
        
     </table>
    
     <hr>
     <?php 
} ?>
<?php echo e(_col()); ?><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin/type/stok-cikislari/coklu-stok-cikisi.blade.php ENDPATH**/ ?>