<?php $sorgu = db("stok_cikislari")->where("siparis_id",get("id"));
if(getisset("bugun")) {
    $sorgu = $sorgu->whereRaw('Date(created_at) = CURDATE()');
}
$sorgu = $sorgu->get();

?>
<div class="m-3">
    <table class="table table-striped table-hovert table-bordered table-xs ">
        <tr class="table-danger">
            <th>{{e2("BARKOD")}}</th>
            <th>{{e2("TARİH")}}</th>
            <th>{{e2("STOK BİLGİSİ")}}</th>
            <th>{{e2("MİKTAR")}}</th>
        </tr>
        <?php 
        $toplam = 0;
        foreach($sorgu AS $s) { 
            $toplam +=$s->qty;
            $stok = j($s->stok);
            $stok_json = j($stok['json']);
        ?>
        <tr>
            <td>{{$stok['slug']}}</td>
            <td>{{date("d.m.Y",strtotime($s->created_at))}}</td>
            <td>{{urun_ozellikleri($stok_json)}}</td>
            <td>{{nf($s->qty)}}</td>
        </tr> 
        <?php } ?>
        <tfoot>
        <tr class="table-warning">
        <th  colspan="2" class="text-right">{{e2("TOPLAM")}} :</th>
        <th>{{nf($toplam)}}</th>
        </tr>
    </tfoot>

    </table>
</div>