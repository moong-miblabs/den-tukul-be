<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hidehalo\Nanoid\Client;

class Deteksi extends Controller {
	public function register(Request $request) {
		$q1 = $request->post('q1');
		$q2 = $request->post('q2');
		$q3 = $request->post('q3');
		$q4 = $request->post('q4');
		$q5 = $request->post('q5');
		$q6 = $request->post('q6');
		$q7 = $request->post('q7');
		$q8 = $request->post('q8');
		$q9 = $request->post('q9');
		$q10 = $request->post('q10');
		$q11 = $request->post('q11');
		$q12 = $request->post('q12');
		$total = 0;
		if($q1=='1') $total++;
		if($q2=='1') $total++;
		if($q3=='1') $total++;
		if($q4=='1') $total++;
		if($q5=='1') $total++;
		if($q6=='1') $total++;
		if($q7=='1') $total++;
		if($q8=='1') $total++;
		if($q9=='1') $total++;
		if($q10=='1') $total++;
		if($q11=='1') $total++;
		if($q12=='1') $total++;
		$klasifikasi = "";
		if($total>=2) $klasifikasi = "P";
		else $klasifikasi = "N";

		$client = new Client();
		$id = $client->formattedId('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',21);
		$now = Carbon::now(new \DateTimeZone(env('APP_TIMEZONE','Asia/Jakarta')));
		DB::insert("INSERT INTO deteksi(id,user_role_id,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,total,klasifikasi,created_at,updated_at)
			VALUES (:id,:user_role_id,:q1,:q2,:q3,:q4,:q5,:q6,:q7,:q8,:q9,:q10,:q11,:q12,:total,:klasifikasi,:created_at,:updated_at)",
		[
			'id' => $id,
			'user_role_id' => $request->data_user->id,
			'q1' => $q1,
			'q2' => $q2,
			'q3' => $q3,
			'q4' => $q4,
			'q5' => $q5,
			'q6' => $q6,
			'q7' => $q7,
			'q8' => $q8,
			'q9' => $q9,
			'q10' => $q10,
			'q11' => $q11,
			'q12' => $q12,
			'total' => $total,
			'klasifikasi'=> $klasifikasi,
			'created_at' => $now,
			'updated_at' => $now
		]);

		return $this->afterMiddleware([
			'from'		=> "Deteksi@register",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> [
				'id' => $id,
				'user_role_id' => $request->data_user->id,
				'q1' => $q1,
				'q2' => $q2,
				'q3' => $q3,
				'q4' => $q4,
				'q5' => $q5,
				'q6' => $q6,
				'q7' => $q7,
				'q8' => $q8,
				'q9' => $q9,
				'q10' => $q10,
				'q11' => $q11,
				'q12' => $q12,
				'total' => $total,
				'klasifikasi'=> $klasifikasi,
				'created_at' => $now,
				'updated_at' => $now
			]
		]);
    }

    public function get(Request $request) {
		$data = DB::select("SELECT d.id, u.nama_user, d.total, d.klasifikasi, d.created_at FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id LEFT JOIN users u ON ur.user_id = u.id WHERE d.deleted_at IS NULL ORDER BY d.created_at DESC");
		$new_data = [];
		$i = 1;
		foreach ($data as $row) {
			$row->no = $i;
			array_push($new_data, $row);
			$i++;
		}
		return $this->afterMiddleware([
			'from'		=> "Deteksi@get",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> $new_data
		]);
    }
}
