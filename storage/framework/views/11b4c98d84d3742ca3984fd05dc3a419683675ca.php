<?php 
$musteriler = contents_to_array("Müşteriler"); 
$urunler = contents_to_array("Ürünler"); 
?>

<?php echo e(col("col-md-12","Yeni Çoklu Stok Çıkışı",3)); ?>

<div class="btn btn-success stok-cikisi-yazdir"><i class="fa fa-print"></i> <?php echo e(e2("Stok Çıkışlarını Yazdır")); ?></div>
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
               $.get("?ajax=siparis-detay3",{
                    id : "<?php echo e($siparis->type); ?>",
                    siparis_id : "<?php echo e($siparis->id); ?>"
               },function(d){
                    $(".detay<?php echo e($deger); ?>").html(d);
                  
               });
               $(".stok-cikisi-yazdir").on("click",function(){
                         $(".gecmis-stok-cikislari").addClass("noprint");
                         $(".filtrele").addClass("noprint");
                         window.print();
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
                         <div class="btn-group">
                              <div class="btn btn-primary bugun<?php echo e($deger); ?>"><?php echo e(e2("Bugünkü")); ?></div>
                              <div class="btn btn-primary tumu<?php echo e($deger); ?>"><?php echo e(e2("Tüm Zamanlar")); ?></div>
                         </div>
                    </div>

               </td>
               <script>
                    $(function(){
                         $("#satirlar<?php echo e($deger); ?>").load("?ajax=siparis-stok-cikisi&id=<?php echo e($deger); ?>");
                         $(".bugun<?php echo e($deger); ?>").on("click",function(){
                              $("#satirlar<?php echo e($deger); ?>").load("?ajax=siparis-stok-cikisi&id=<?php echo e($deger); ?>&bugun");
                         });
                         $(".tumu<?php echo e($deger); ?>").on("click",function(){
                              $("#satirlar<?php echo e($deger); ?>").load("?ajax=siparis-stok-cikisi&id=<?php echo e($deger); ?>");
                         });
                         $(".serialize<?php echo e($deger); ?>").on("submit",function(){
                              
                              var bu = $(this);
                              var id= bu.attr("id");
                              var stok = $("#serialize<?php echo e($deger); ?> [name='stok']").val();
                              console.log("stok");
                              console.log(id);
                             
                              $.ajax({
                                   type : $(this).attr("method"),
                                   url : $(this).attr("action"),
                                   data : $(this).serialize(),
                                   success: function(d){
                                        var id = bu.attr("id");
                                        $('.detay<?php echo e($deger); ?> option:selected').remove();
                                        $(".detay<?php echo e($deger); ?> .select2").trigger("change");
                                        $("#satirlar"+id).load("?ajax=siparis-stok-cikisi&id="+id);
                                        
                                   }

                              });
                              
                              return false;

                         });
                    });
               </script>
               <tr>
                    
                    <td colspan="4" id="satirlar<?php echo e($deger); ?>" ></td>
                    <td>
                         <form action="?ekle" method="post" id="<?php echo e($deger); ?>" class="serialize<?php echo e($deger); ?>">
                              <?php echo e(csrf_field()); ?>

                              <input type="hidden" name="firma" value="<?php echo e($musteri->id); ?>">
                              <input type="hidden" name="siparis" value="<?php echo e($deger); ?>">
                              <div class="detay<?php echo e($deger); ?>"></div>
                         </form>

                    </td>
               </tr>
          </tr>
        
     </table>
    
     <hr>
     <?php 
} ?>
<?php echo e(_col()); ?><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin/type/stok-cikislari/coklu-stok-cikisi.blade.php ENDPATH**/ ?>