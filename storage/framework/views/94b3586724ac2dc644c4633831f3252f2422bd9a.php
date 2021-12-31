<?php echo e(col("col-md-12 filtrele","Filtrele",2)); ?>

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
                            <input type="date" name="date1"  value="<?php echo e(get("date1")); ?>" id="" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <?php echo e(e2("İŞLEM TARİHİ BİTİŞ")); ?> : 
                            <input type="date" name="date2"  value="<?php echo e(get("date2")); ?>" id="" class="form-control">
                        </div>
                       
                       
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary mt-10" name="filtre" value="ok"><?php echo e(e2("FİLTRELE")); ?></button>
                        </div>
                    </div>
                    
                   
                    
                    
                    

                </form>
    <?php echo e(_col()); ?><?php /**PATH E:\Works\xampp7\htdocs\bta\resources\views/admin/type/stok-cikislari/filtrele.blade.php ENDPATH**/ ?>