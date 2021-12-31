<?php $siparis = db("stoklar")->where("id",get("id"))->first();
$j = j($siparis->json);
print2($j);
?><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin-ajax/info-siparis.blade.php ENDPATH**/ ?>