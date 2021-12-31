@extends('admin.master')

@section("title")
	{{e2("Dashboard")}}
@endsection
@section('content')

		<div class="content">
			{{col("col-md-12","Ürün İstatistikleri",15)}}
			@include("admin.type.istatistik.urun-stoklari")
			{{_col()}}
	
		</div>

@endsection
