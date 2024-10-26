<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Respect\Validation\Validator as v;
use Illuminate\Support\Facades\DB;
use App\Helper\BcryptHelper;
use App\Helper\JsonwebtokenHelper;
use Carbon\Carbon;
use Hidehalo\Nanoid\Client;
use Aura\SqlQuery\QueryFactory;

class Login extends Controller {
	public function register(Request $request) {

		// Register harus menggunakan username, whatsapp, email dan password. untuk login nantinya
		// kalau salah satu tidak ada harus response 'fail'
		// email juga harus divalidasi, apakan sesuai format email
		$fail 			= FALSE;
		$message 		= '';
		$add_message 	= '';
		$desc 			= [];
		if(!$request->has('nama_user') || $request->post('nama_user') === '' || $request->post('nama_user') === NULL) {
    		$desc['nama_user'] = "required";
    		$message .= 'nama';
    		$fail = TRUE;
    	}
		if(!$request->has('username_user') || $request->post('username_user') === '' || $request->post('username_user') === NULL) {
    		$desc['username_user'] = "required";
    		$message .= ($fail?' dan ':'') . 'username';
    		$fail = TRUE;
    	}
    	if(!$request->has('whatsapp_user') || $request->post('whatsapp_user') === '' || $request->post('whatsapp_user') === NULL) {
    		$desc['whatsapp_user'] = "required";
    		$message .= ($fail?' dan ':'') . 'whatsapp';
    		$fail = TRUE;
    	} elseif(!v::startsWith('62')->numericVal()->validate($request->post('whatsapp_user'))) {
    		$desc['whatsapp_user'] = "not valid";
    		$add_message .= " 'whatsapp' harus berisi angka dan diawali dengan 62;"; 
    		$fail = TRUE;
    	}
    	if(!$request->has('email_user') || $request->post('email_user') === '' || $request->post('email_user') === NULL) {
    		$desc['email_user'] = "required";
    		$message .= ($fail?' dan ':'') . 'email';
    		$fail = TRUE;
    	} elseif(!v::email()->validate($request->post('email_user'))) {
    		$desc['email_user'] = "not valid";
    		$add_message .= " 'email' tidak valid;"; 
    		$fail = TRUE;
    	}
    	if(!$request->has('password_user') || $request->post('password_user') === '' || $request->post('password_user') === NULL) {
    		$desc['password_user'] = "required";
    		$message .= ($fail?' dan ':'') . 'password';
    		$fail = TRUE;
    	}
    	if($fail) {
    		return $this->afterMiddleware([
				'from'		=> "Login@register",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> ($message?$message." harus diisi":""). $add_message,
				'desc'		=> $desc,
				'data'		=> null
			]);
    	}
    	if($request->has('enroll_code') && $request->post('enroll_code') !== '' && $request->post('enroll_code') !== NULL) {
    		return $this->registerWithCode($request);
    	} else {
    		return $this->registerWithoutCode($request);
    	}
    }

    private function registerWithoutCode(Request $request) {
    	// username dan email harus unik, karna akan digunakan untuk login nantinya
    	// jika sebelumnya sudah ada yang gunakan username atau email, tetapi belum diverifikasi, hapus saja
    	$check = DB::transaction(function () use ($request) {
    		// DB::delete("DELETE FROM users WHERE (username_user = ? OR email_user = ? OR whatsapp_user = ?) AND email_verified_at IS NULL",[$request->post('username_user'), $request->post('email_user'), $request->post('whatsapp_user')]);
	    	$check_username = DB::select("SELECT * FROM users uu WHERE uu.username_user = ?",[$request->post('username_user')]);
	    	$check_email = DB::select("SELECT * FROM users uu WHERE uu.email_user = ?",[$request->post('email_user')]);
	    	$check_whatsapp = DB::select("SELECT * FROM users uu WHERE uu.whatsapp_user = ?",[$request->post('whatsapp_user')]);
	    	return ['username_user'=>!empty($check_username),'email_user'=>!empty($check_email),'whatsapp_user'=>!empty($check_whatsapp)];
    	});
    	if($check['username_user']) {
    		return $this->afterMiddleware([
				'from'		=> "Login@register",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "'username_user' sudah digunakan",
				'desc'		=> [
					'username_user' => "'username_user' has been used"
				],
				'data'		=> null
			]);
    	}
    	if($check['whatsapp_user']) {
    		return $this->afterMiddleware([
				'from'		=> "Login@register",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "'whatsapp_user' sudah digunakan",
				'desc'		=> [
					'email_user' => "'whatsapp_user' has been used"
				],
				'data'		=> null
			]);
    	}
    	if($check['email_user']) {
    		return $this->afterMiddleware([
				'from'		=> "Login@register",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "'email_user' sudah digunakan",
				'desc'		=> [
					'email_user' => "'email_user' has been used"
				],
				'data'		=> null
			]);
    	}
    	$datauser = [];
    	$client = new Client();
    	$datauser['id'] = $client->formattedId('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
    	if($request->has('nama_user') && $request->post('nama_user') !== NULL && $request->post('nama_user') !== '') {
    		$datauser['nama_user'] = $request->post('nama_user');
    	}
    	if($request->has('email_user') && $request->post('email_user') !== NULL && $request->post('email_user') !== '') {
    		$datauser['email_user'] = $request->post('email_user');
    	}
    	if($request->has('whatsapp_user') && $request->post('whatsapp_user') !== NULL && $request->post('whatsapp_user') !== '') {
    		$datauser['whatsapp_user'] = $request->post('whatsapp_user');
    	}
    	if($request->has('username_user') && $request->post('username_user') !== NULL && $request->post('username_user') !== '') {
    		$datauser['username_user'] = $request->post('username_user');
    	}
    	if($request->has('password_user') && $request->post('password_user') !== NULL && $request->post('password_user') !== '') {
    		$datauser['password_user'] = BcryptHelper::hash($request->post('password_user'));
    	}
    	if($request->has('kelurahan_id') && $request->post('kelurahan_id') !== NULL && $request->post('kelurahan_id') !== '') {
    		$datauser['kelurahan_id'] = $request->post('kelurahan_id');
    	} elseif($request->has('kecamatan_id') && $request->post('kecamatan_id') !== NULL && $request->post('kecamatan_id') !== '') {
    		$datauser['kecamatan_id'] = $request->post('kecamatan_id');
    	} elseif($request->has('kab_kota_id') && $request->post('kab_kota_id') !== NULL && $request->post('kab_kota_id') !== '') {
    		$datauser['kab_kota_id'] = $request->post('kab_kota_id');
    	} elseif($request->has('provinsi_id') && $request->post('provinsi_id') !== NULL && $request->post('provinsi_id') !== '') {
    		$datauser['provinsi_id'] = $request->post('provinsi_id');
    	}
    	if($request->has('jenis_kelamin') && $request->post('jenis_kelamin') !== NULL && $request->post('jenis_kelamin') !== '') {
    		$datauser['jenis_kelamin'] = $request->post('jenis_kelamin');
    	}
    	if($request->has('tempat_lahir') && $request->post('tempat_lahir') !== NULL && $request->post('tempat_lahir') !== '') {
    		$datauser['tempat_lahir'] = $request->post('tempat_lahir');
    	}
    	if($request->has('tanggal_lahir') && $request->post('tanggal_lahir') !== NULL && $request->post('tanggal_lahir') !== '') {
    		$datauser['tanggal_lahir'] = $request->post('tanggal_lahir');
    	}
    	if($request->has('nik') && $request->post('nik') !== NULL && $request->post('nik') !== '') {
    		$datauser['nik'] = $request->post('nik');
    	}
    	if($request->has('jalan') && $request->post('jalan') !== NULL && $request->post('jalan') !== '') {
    		$datauser['jalan'] = $request->post('jalan');
    	}
    	if($request->has('dusun') && $request->post('dusun') !== NULL && $request->post('dusun') !== '') {
    		$datauser['dusun'] = $request->post('dusun');
    	}
    	if($request->has('rt') && $request->post('rt') !== NULL && $request->post('rt') !== '') {
    		$datauser['rt'] = $request->post('rt');
    	}
    	if($request->has('rw') && $request->post('rw') !== NULL && $request->post('rw') !== '') {
    		$datauser['rw'] = $request->post('rw');
    	}
    	if($request->has('no_rumah') && $request->post('no_rumah') !== NULL && $request->post('no_rumah') !== '') {
    		$datauser['no_rumah'] = $request->post('no_rumah');
    	}
    	if($request->has('blok') && $request->post('blok') !== NULL && $request->post('blok') !== '') {
    		$datauser['blok'] = $request->post('blok');
    	}
    	if($request->has('kode_pos') && $request->post('kode_pos') !== NULL && $request->post('kode_pos') !== '') {
    		$datauser['kode_pos'] = $request->post('kode_pos');
    	}
    	if($request->has('agama_id') && $request->post('agama_id') !== NULL && $request->post('agama_id') !== '') {
    		$datauser['agama_id'] = $request->post('agama_id');
    	}
    	if($request->has('pekerjaan_id') && $request->post('pekerjaan_id') !== NULL && $request->post('pekerjaan_id') !== '') {
    		$datauser['pekerjaan_id'] = $request->post('pekerjaan_id');
    	}
    	if($request->has('penghasilan_id') && $request->post('penghasilan_id') !== NULL && $request->post('penghasilan_id') !== '') {
    		$datauser['penghasilan_id'] = $request->post('penghasilan_id');
    	}
    	if($request->has('jenjang_id') && $request->post('jenjang_id') !== NULL && $request->post('jenjang_id') !== '') {
    		$datauser['jenjang_id'] = $request->post('jenjang_id');
    	}
    	if($request->has('tentang_id') && $request->post('tentang_id') !== NULL && $request->post('tentang_id') !== '') {
    		$datauser['tentang_id'] = $request->post('tentang_id');
    	}
    	$now = Carbon::now(new \DateTimeZone(env('APP_TIMEZONE','Asia/Jakarta')));
    	$datauser['created_at'] = $datauser['updated_at'] = $now;

    	$datarole = [];
    	$datarole['id'] = $client->formattedId('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
    	$datarole['user_id'] = $datauser['id'];
    	$datarole['role_id'] = 'RRRRRRRRRRRRRRRRRRRRR';
    	$datarole['created_at'] = $datarole['updated_at'] = $now;

    	$datas = DB::transaction(function () use ($datauser,$datarole) {
    		DB::table('users')->insert($datauser);
    		DB::table('user_role')->insert($datarole);
    		if(!empty($datauser['kelurahan_id'])){
    			$wilayah = DB::select("SELECT kl.kecamatan_id, kc.kab_kota_id, kk.provinsi_id FROM ref_kelurahan kl LEFT JOIN ref_kecamatan kc ON kl.kecamatan_id = kc.id LEFT JOIN ref_kab_kota kk ON kc.kab_kota_id = kk.id WHERE kl.id = ? LIMIT 1",[$datauser['kelurahan_id']]);
    			DB::table('users')->where('id',$user->id)->update(['kecamatan_id'=>$wilayah[0]->kecamatan_id,'kab_kota_id'=>$wilayah[0]->kab_kota_id,'provinsi_id'=>$wilayah[0]->provinsi_id]);
    		} elseif(!empty($datauser['kecamatan_id'])) {
    			$wilayah = DB::select("SELECT kc.kab_kota_id, kk.provinsi_id FROM ref_kecamatan kc LEFT JOIN ref_kab_kota kk ON kc.kab_kota_id = kk.id WHERE kc.id = ? LIMIT 1",[$datauser['kecamatan_id']]);
    			DB::table('users')->where('id',$user->id)->update(['kab_kota_id'=>$wilayah[0]->kab_kota_id,'provinsi_id'=>$wilayah[0]->provinsi_id]);
    		} elseif(!empty($datauser['kab_kota_id'])) {
    			$wilayah = DB::select("SELECT kk.provinsi_id FROM ref_kab_kota kk WHERE kk.id = ? LIMIT 1",[$datauser['kab_kota_id']]);
    			DB::table('users')->where('id',$user->id)->update(['provinsi_id'=>$wilayah[0]->provinsi_id]);
    		}
    		return DB::select("SELECT uu.id, password_user, nama_user, username_user, email_user, email_verified_at, whatsapp_user, whatsapp_verified_at FROM users uu WHERE uu.id = ?",[$datauser['id']]);
    	});
    	$data = $datas[0];

    	$data_role = DB::select("SELECT nama_role from user_role ur LEFT JOIN ms_role rl ON ur.role_id = rl.id WHERE ur.user_id = ?",[$data->id]);
    	$role = '';
    	if(!empty($data_role)) {
    		$arr = [];
    		foreach ($data_role as $row) {
    			array_push($arr,$row->nama_role);
    		}
    		$role = implode(',',$arr);
    	}
    	$data->role = $role;

    	$fe_data = array_filter((array) $data,  fn($key) => in_array($key, ['id','nama_user','username_user','whatsapp_user','whatsapp_verified_at','email_user','email_verified_at','role']), ARRAY_FILTER_USE_KEY);
        $token_data = array_filter((array) $data,  fn($key) => in_array($key, ['id','password_user','nama_user','username_user','whatsapp_user','whatsapp_verified_at','email_user','email_verified_at','role']), ARRAY_FILTER_USE_KEY);

    	return $this->afterMiddleware([
			'from'		=> "Login@registerWithoutCode",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> $fe_data,
			'token' 	=> JsonwebtokenHelper::sign($token_data)
		]);
    }

    private function registerWithCode(Request $request) {
    	// 'enroll_code' harus dicek terlebih dahulu
    	// kalau tidak ada : kemungkinan salah atau sudah digunakan
    	// kalau expired : berarti expired
    	$enroll_code = $request->post('enroll_code');
		$user = DB::table('users')->select('id','enroll_code','enroll_expired_at')->where('enroll_code',$enroll_code)->first();
		if($user) {
			$now = Carbon::now(new \DateTimeZone(env('APP_TIMEZONE','Asia/Jakarta')));
			$exp = Carbon::createFromFormat('Y-m-d H:i:sT',$user->enroll_expired_at);
			if($now->greaterThanOrEqualTo($exp)){
				return $this->afterMiddleware([
					'from'		=> "Login@registerWithCode",
					'code'		=> 400,
					'status'	=> "fail",
					'message'	=> "enroll code sudah kadaluarsa",
					'desc'		=> [
						'enroll_code' => "expired"
					],
					'data'		=> null
				]);
			}
		} else {
			return $this->afterMiddleware([
				'from'		=> "Login@registerWithCode",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "enroll code salah atau sudah digunakan",
				'desc'		=> [
					'enroll_code' => "wrong"
				],
				'data'		=> null
			]);
		}
    	// username dan email harus unik, karna akan digunakan untuk login nantinya
    	// jika sebelumnya sudah ada yang gunakan username atau email, tetapi belum diverifikasi, hapus saja
    	$check = DB::transaction(function () use ($request,$user) {
    		// DB::delete("DELETE FROM users WHERE (username_user = ? OR email_user = ? OR whatsapp_user = ?) AND email_verified_at IS NULL",[$request->post('username_user'), $request->post('email_user'), $request->post('whatsapp_user')]);
	    	$check_username = DB::select("SELECT * FROM users uu WHERE uu.username_user = ? AND uu.id <> ?",[$request->post('username_user'),$user->id]);
	    	$check_email = DB::select("SELECT * FROM users uu WHERE uu.email_user = ? AND uu.id <> ?",[$request->post('email_user'),$user->id]);
	    	$check_whatsapp = DB::select("SELECT * FROM users uu WHERE uu.whatsapp_user = ? AND uu.id <> ?",[$request->post('whatsapp_user'),$user->id]);
	    	return ['username_user'=>!empty($check_username),'email_user'=>!empty($check_email),'whatsapp_user'=>!empty($check_whatsapp)];
    	});
    	if($check['username_user']) {
    		return $this->afterMiddleware([
				'from'		=> "Login@register",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "'username_user' sudah digunakan",
				'desc'		=> [
					'username_user' => "'username_user' has been used"
				],
				'data'		=> null
			]);
    	}
    	if($check['whatsapp_user']) {
    		return $this->afterMiddleware([
				'from'		=> "Login@register",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "'whatsapp_user' sudah digunakan",
				'desc'		=> [
					'email_user' => "'whatsapp_user' has been used"
				],
				'data'		=> null
			]);
    	}
    	if($check['email_user']) {
    		return $this->afterMiddleware([
				'from'		=> "Login@register",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "'email_user' sudah digunakan",
				'desc'		=> [
					'email_user' => "'email_user' has been used"
				],
				'data'		=> null
			]);
    	}
    	$datauser = ['enroll_code'=>NULL];
    	// $client = new Client();
    	// $datauser['id'] = $client->formattedId('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
    	if($request->has('nama_user') && $request->post('nama_user') !== NULL && $request->post('nama_user') !== '') {
    		$datauser['nama_user'] = $request->post('nama_user');
    	}
    	if($request->has('email_user') && $request->post('email_user') !== NULL && $request->post('email_user') !== '') {
    		$datauser['email_user'] = $request->post('email_user');
    	}
    	if($request->has('whatsapp_user') && $request->post('whatsapp_user') !== NULL && $request->post('whatsapp_user') !== '') {
    		$datauser['whatsapp_user'] = $request->post('whatsapp_user');
    	}
    	if($request->has('username_user') && $request->post('username_user') !== NULL && $request->post('username_user') !== '') {
    		$datauser['username_user'] = $request->post('username_user');
    	}
    	if($request->has('password_user') && $request->post('password_user') !== NULL && $request->post('password_user') !== '') {
    		$datauser['password_user'] = BcryptHelper::hash($request->post('password_user'));
    	}
    	if($request->has('kelurahan_id') && $request->post('kelurahan_id') !== NULL && $request->post('kelurahan_id') !== '') {
    		$datauser['kelurahan_id'] = $request->post('kelurahan_id');
    	} elseif($request->has('kecamatan_id') && $request->post('kecamatan_id') !== NULL && $request->post('kecamatan_id') !== '') {
    		$datauser['kecamatan_id'] = $request->post('kecamatan_id');
    	} elseif($request->has('kab_kota_id') && $request->post('kab_kota_id') !== NULL && $request->post('kab_kota_id') !== '') {
    		$datauser['kab_kota_id'] = $request->post('kab_kota_id');
    	} elseif($request->has('provinsi_id') && $request->post('provinsi_id') !== NULL && $request->post('provinsi_id') !== '') {
    		$datauser['provinsi_id'] = $request->post('provinsi_id');
    	}
    	if($request->has('jenis_kelamin') && $request->post('jenis_kelamin') !== NULL && $request->post('jenis_kelamin') !== '') {
    		$datauser['jenis_kelamin'] = $request->post('jenis_kelamin');
    	}
    	if($request->has('tempat_lahir') && $request->post('tempat_lahir') !== NULL && $request->post('tempat_lahir') !== '') {
    		$datauser['tempat_lahir'] = $request->post('tempat_lahir');
    	}
    	if($request->has('tanggal_lahir') && $request->post('tanggal_lahir') !== NULL && $request->post('tanggal_lahir') !== '') {
    		$datauser['tanggal_lahir'] = $request->post('tanggal_lahir');
    	}
    	if($request->has('nik') && $request->post('nik') !== NULL && $request->post('nik') !== '') {
    		$datauser['nik'] = $request->post('nik');
    	}
    	if($request->has('jalan') && $request->post('jalan') !== NULL && $request->post('jalan') !== '') {
    		$datauser['jalan'] = $request->post('jalan');
    	}
    	if($request->has('dusun') && $request->post('dusun') !== NULL && $request->post('dusun') !== '') {
    		$datauser['dusun'] = $request->post('dusun');
    	}
    	if($request->has('rt') && $request->post('rt') !== NULL && $request->post('rt') !== '') {
    		$datauser['rt'] = $request->post('rt');
    	}
    	if($request->has('rw') && $request->post('rw') !== NULL && $request->post('rw') !== '') {
    		$datauser['rw'] = $request->post('rw');
    	}
    	if($request->has('no_rumah') && $request->post('no_rumah') !== NULL && $request->post('no_rumah') !== '') {
    		$datauser['no_rumah'] = $request->post('no_rumah');
    	}
    	if($request->has('blok') && $request->post('blok') !== NULL && $request->post('blok') !== '') {
    		$datauser['blok'] = $request->post('blok');
    	}
    	if($request->has('kode_pos') && $request->post('kode_pos') !== NULL && $request->post('kode_pos') !== '') {
    		$datauser['kode_pos'] = $request->post('kode_pos');
    	}
    	if($request->has('agama_id') && $request->post('agama_id') !== NULL && $request->post('agama_id') !== '') {
    		$datauser['agama_id'] = $request->post('agama_id');
    	}
    	if($request->has('pekerjaan_id') && $request->post('pekerjaan_id') !== NULL && $request->post('pekerjaan_id') !== '') {
    		$datauser['pekerjaan_id'] = $request->post('pekerjaan_id');
    	}
    	if($request->has('penghasilan_id') && $request->post('penghasilan_id') !== NULL && $request->post('penghasilan_id') !== '') {
    		$datauser['penghasilan_id'] = $request->post('penghasilan_id');
    	}
    	if($request->has('jenjang_id') && $request->post('jenjang_id') !== NULL && $request->post('jenjang_id') !== '') {
    		$datauser['jenjang_id'] = $request->post('jenjang_id');
    	}
    	if($request->has('tentang_id') && $request->post('tentang_id') !== NULL && $request->post('tentang_id') !== '') {
    		$datauser['tentang_id'] = $request->post('tentang_id');
    	}
    	$now = Carbon::now(new \DateTimeZone(env('APP_TIMEZONE','Asia/Jakarta')));
    	$datauser['updated_at'] = $now;

    	// $datarole = [];
    	// $datarole['id'] = $client->formattedId('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
    	// $datarole['user_id'] = $datauser['id'];
    	// $datarole['role_id'] = 'RRRRRRRRRRRRRRRRRRRRR';
    	// $datarole['created_at'] = $datarole['updated_at'] = $now;

    	$datas = DB::transaction(function () use ($user,$datauser) {
    		DB::table('users')->where('id',$user->id)->update($datauser);
    		if(!empty($datauser['kelurahan_id'])){
    			$wilayah = DB::select("SELECT kl.kecamatan_id, kc.kab_kota_id, kk.provinsi_id FROM ref_kelurahan kl LEFT JOIN ref_kecamatan kc ON kl.kecamatan_id = kc.id LEFT JOIN ref_kab_kota kk ON kc.kab_kota_id = kk.id WHERE kl.id = ? LIMIT 1",[$datauser['kelurahan_id']]);
    			DB::table('users')->where('id',$user->id)->update(['kecamatan_id'=>$wilayah[0]->kecamatan_id,'kab_kota_id'=>$wilayah[0]->kab_kota_id,'provinsi_id'=>$wilayah[0]->provinsi_id]);
    		} elseif(!empty($datauser['kecamatan_id'])) {
    			$wilayah = DB::select("SELECT kc.kab_kota_id, kk.provinsi_id FROM ref_kecamatan kc LEFT JOIN ref_kab_kota kk ON kc.kab_kota_id = kk.id WHERE kc.id = ? LIMIT 1",[$datauser['kecamatan_id']]);
    			DB::table('users')->where('id',$user->id)->update(['kab_kota_id'=>$wilayah[0]->kab_kota_id,'provinsi_id'=>$wilayah[0]->provinsi_id]);
    		} elseif(!empty($datauser['kab_kota_id'])) {
    			$wilayah = DB::select("SELECT kk.provinsi_id FROM ref_kab_kota kk WHERE kk.id = ? LIMIT 1",[$datauser['kab_kota_id']]);
    			DB::table('users')->where('id',$user->id)->update(['provinsi_id'=>$wilayah[0]->provinsi_id]);
    		}
    		return DB::select("SELECT uu.id, password_user, nama_user, username_user, email_user, email_verified_at, whatsapp_user, whatsapp_verified_at FROM users uu WHERE uu.id = ?",[$user->id]);
    	});
    	$data = $datas[0];

    	$data_role = DB::select("SELECT nama_role from user_role ur LEFT JOIN ms_role rl ON ur.role_id = rl.id WHERE ur.user_id = ?",[$data->id]);
    	$role = '';
    	if(!empty($data_role)) {
    		$arr = [];
    		foreach ($data_role as $row) {
    			array_push($arr,$row->nama_role);
    		}
    		$role = implode(',',$arr);
    	}
    	$data->role = $role;

    	$fe_data = array_filter((array) $data,  fn($key) => TRUE, ARRAY_FILTER_USE_KEY);
        $token_data = array_filter((array) $data,  fn($key) => TRUE, ARRAY_FILTER_USE_KEY);

    	return $this->afterMiddleware([
			'from'		=> "Login@registerWithCode",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> $fe_data,
			'token' 	=> JsonwebtokenHelper::sign($token_data)
		]);
    }

    public function enroll(Request $request) {
    	$datauser = [];

    	$client = new Client();
    	$datauser['id'] = $client->formattedId('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
    	
    	if($request->has('whatsapp_user') && $request->post('whatsapp_user') !== NULL && $request->post('whatsapp_user') !== '') {
    		if(v::startsWith('62')->numericVal()->validate($request->post('whatsapp_user'))) {
	    		$datauser['whatsapp_user'] = $request->post('whatsapp_user');
    		} else {
    			return $this->afterMiddleware([
	    			'from'		=> "Login@enroll",
					'code'		=> 400,
					'status'	=> "fail",
					'message'	=> "'whatsapp' harus berisi angka dan diawali dengan 62",
					'desc'		=> [
						'whatsapp_user' => 'not valid'
					],
					'data'		=> NULL
				]);	
    		}
    	} else {
    		return $this->afterMiddleware([
    			'from'		=> "Login@enroll",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "'Whatsapp' harus diisi",
				'desc'		=> [
					'whatsapp_user' => 'required'
				],
				'data'		=> NULL
			]);
    	}

    	if($request->has('email_user'))
    		$datauser['email_user'] = $request->post('email_user');

    	if($request->has('nama_user'))
    		$datauser['nama_user'] = $request->post('nama_user');

    	$datauser['enroll_code'] = $client->formattedId('0123456789',6);
    	$datauser['enroll_expired_at'] = Carbon::now(new \DateTimeZone(env('APP_TIMEZONE','Asia/Jakarta')))->addDays(3);

    	$now = Carbon::now(new \DateTimeZone(env('APP_TIMEZONE','Asia/Jakarta')));
    	$datauser['created_at'] = $datauser['updated_at'] = $now;

    	$datarole = [];
    	$datarole['id'] = $client->formattedId('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
    	$datarole['user_id'] = $datauser['id'];
    	$datarole['role_id'] = 'AAAAAAAAAAAAAAAAAAAAA';
    	$datarole['created_at'] = $datarole['updated_at'] = $now;

    	$status = DB::transaction(function () use ($datauser,$datarole) {
    		$check = DB::table('users')->where('whatsapp_user',$datauser['whatsapp_user'])->first();
    		if($check) return FALSE;

	    	DB::table('users')->insert($datauser);
	    	DB::table('user_role')->insert($datarole);
	    	return TRUE;
    	});

    	if($status) {
	    	return $this->afterMiddleware([
	    		'from' 		=> "Login@enroll",
	    		'code' 		=> 201,
	    		'status' 	=> "success",
	    		'message' 	=> "",
	    		'desc' 		=> [],
	    		'data' 		=> NULL
	    	]);
    	} else {
    		return $this->afterMiddleware([
	    		'from' 		=> "Login@enroll",
	    		'code' 		=> 400,
	    		'status' 	=> "error",
	    		'message' 	=> "'whatsapp' sudah digunakan",
	    		'desc' 		=> [
	    			'whatsapp_user' => "has been used"
	    		],
	    		'data' 		=> NULL
	    	]);
    	}
    }

    public function login(Request $request) {
    	$query_factory = new QueryFactory(env('DB_CONNECTION'));
    	$select = $query_factory->newSelect();
    	$select->from('users AS uu');
    	$select->where('deleted_at IS NULL');
    	$select->cols(['uu.id','password_user', 'nama_user', 'username_user', 'email_user', 'email_verified_at', 'whatsapp_user', 'whatsapp_verified_at']);
    	$select->limit(1);

    	$username 	= NULL;
    	$email 		= NULL;
    	$whatsapp 	= NULL;

    	$password 	= NULL;

    	if(!$request->has('username') || $request->post('username') === '' || $request->post('username') === NULL) {
    		return $this->afterMiddleware([
				'from'		=> "Login@login",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "username harus diisi",
				'desc'		=> [],
				'data'		=> NULL,
				'token' 	=> ""
			]);
    	} else {
    		if(v::startsWith('62')->numericVal()->validate($request->post('username'))) {
    			$whatsapp = $request->post('username');
    		} elseif (v::email()->validate($request->post('username'))) {
    			$email = $request->post('username');
    		} else {
    			$username = $request->post('username');
    		}
    	}
    	if(!$request->has('password') || $request->post('password') === '' || $request->post('password') === NULL) {
    		return $this->afterMiddleware([
				'from'		=> "Login@login",
				'code'		=> 400,
				'status'	=> "fail",
				'message'	=> "password harus diisi",
				'desc'		=> [],
				'data'		=> NULL,
				'token' 	=> ""
			]);
    	} else {
    		$password = $request->post('password');
    	}

    	if($whatsapp) {
    		$select->where('whatsapp_user = :whatsapp',['whatsapp'=>$whatsapp]);
    	}
    	if($email) {
    		$select->where('email_user = :email',['email'=>$email]);
    	}
    	if($username) {
    		$select->where('username_user = :username',['username'=>$username]);
    	}
    	$datas = DB::select($select->getStatement(),$select->getBindValues());
    	if(empty($datas)) {
    		return $this->afterMiddleware([
				'from'		=> "Login@login",
				'code'		=> 400,
				'status'	=> "error",
				'message'	=> "username tidak ditemukan",
				'desc'		=> [],
				'data'		=> [],
				'token' 	=> ""
			]);
    	}
    	$data = $datas[0];
    	if(!BcryptHelper::compare($password,$data->password_user)) {
    		return $this->afterMiddleware([
				'from'		=> "Login@login",
				'code'		=> 400,
				'status'	=> "error",
				'message'	=> "password salah",
				'desc'		=> [],
				'data'		=> [],
				'token' 	=> ""
			]);
    	}


    	$data_role = DB::select("SELECT nama_role from user_role ur LEFT JOIN ms_role rl ON ur.role_id = rl.id WHERE ur.user_id = ?",[$data->id]);
    	$role = '';
    	if(!empty($data_role)) {
    		$arr = [];
    		foreach ($data_role as $row) {
    			array_push($arr,$row->nama_role);
    		}
    		$role = implode(',',$arr);
    	}
    	$data->role = $role;

    	$fe_data = array_filter((array) $data,  fn($key) => in_array($key, ['id','nama_user','username_user','whatsapp_user','whatsapp_verified_at','email_user','email_verified_at','role']), ARRAY_FILTER_USE_KEY);
        $token_data = array_filter((array) $data,  fn($key) => in_array($key, ['id','password_user','nama_user','username_user','whatsapp_user','whatsapp_verified_at','email_user','email_verified_at','role']), ARRAY_FILTER_USE_KEY);

    	return $this->afterMiddleware([
			'from'		=> "Login@login",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> $fe_data,
			'token' 	=> JsonwebtokenHelper::sign($token_data)
		]);
    }
}
