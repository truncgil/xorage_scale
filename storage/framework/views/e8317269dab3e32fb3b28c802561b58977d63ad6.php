<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Contents;
use Illuminate\Support\Facades\DB;
		$post = $request->all();
		DB::table("contents")
            ->where('id', $post['id'])
            ->update(["cover" => ""]);
		$return = back();
		echo $return; ?><?php /**PATH /home/pgutrunc/bta.truncgil.com/resources/views/admin-ajax/cover-delete.blade.php ENDPATH**/ ?>