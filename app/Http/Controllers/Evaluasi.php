<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hidehalo\Nanoid\Client;

class Evaluasi extends Controller {
	public function register(Request $request) {
		$data_user = $request->data_user;
		$client = new Client();
		$now = Carbon::now(new \DateTimeZone(env('APP_TIMEZONE','Asia/Jakarta')));

		$data = $request->post('data');

		$et = array_filter($data, fn($row) => $row['tipe'] == 'et');
		$es = array_filter($data, fn($row) => $row['tipe'] == 'es');
		$ep = array_filter($data, fn($row) => $row['tipe'] == 'ep');
		$em = array_filter($data, fn($row) => $row['tipe'] == 'em');
		$ed = array_filter($data, fn($row) => $row['tipe'] == 'ed');

		$et_mod = array_map(function($row) use ($client,$data_user,$now) {
			unset($row['tipe']);
			$row['id'] = $client->formattedId('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',21);
			$row['user_role_id'] = $data_user->id;
			$row['created_at'] = $now;
			$row['updated_at'] = $now;
			return $row;
		}, $et);

		$es_mod = array_map(function($row) use ($client,$data_user,$now) {
			unset($row['tipe']);
			$row['id'] = $client->formattedId('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',21);
			$row['user_role_id'] = $data_user->id;
			$row['created_at'] = $now;
			$row['updated_at'] = $now;
			return $row;
		}, $es);

		$ep_mod = array_map(function($row) use ($client,$data_user,$now) {
			unset($row['tipe']);
			$row['id'] = $client->formattedId('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',21);
			$row['user_role_id'] = $data_user->id;
			$row['created_at'] = $now;
			$row['updated_at'] = $now;
			return $row;
		}, $ep);

		$em_mod = array_map(function($row) use ($client,$data_user,$now) {
			unset($row['tipe']);
			$row['id'] = $client->formattedId('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',21);
			$row['user_role_id'] = $data_user->id;
			$row['created_at'] = $now;
			$row['updated_at'] = $now;
			return $row;
		}, $em);

		$ed_mod = array_map(function($row) use ($client,$data_user,$now) {
			unset($row['tipe']);
			$row['id'] = $client->formattedId('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',21);
			$row['user_role_id'] = $data_user->id;
			$row['created_at'] = $now;
			$row['updated_at'] = $now;
			return $row;
		}, $ed);

		DB::transaction(function () use ($et_mod,$es_mod,$ep_mod,$em_mod,$ed_mod) {
		    DB::table('evaluasi_pengetahuan')->insert($et_mod);
		    DB::table('evaluasi_sikap')->insert($es_mod);
		    DB::table('evaluasi_praktik')->insert($ep_mod);
		    DB::table('evaluasi_motivasi')->insert($em_mod);
		    DB::table('evaluasi_dukungan')->insert($ed_mod);
		});

		return $this->afterMiddleware([
			'from'		=> "Evaluasi@register",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> null
		]);
	}

	public function list(Request $request) {
		// $columns = "ur.id,ur.user_id,ur.role_id,ur.created_at,ur.updated_at";
		// $column_user = "uu.id AS uu__id,uu.sso_id AS uu__sso_id,uu.nama_user AS uu__nama_user,uu.email_user AS uu__email_user,uu.email_code AS uu__email_code,uu.email_expired_at AS uu__email_expired_at,uu.email_verified_at AS uu__email_verified_at,uu.whatsapp_user AS uu__whatsapp_user,uu.whatsapp_code AS uu__whatsapp_code,uu.whatsapp_expired_at AS uu__whatsapp_expired_at,uu.whatsapp_verified_at AS uu__whatsapp_verified_at,uu.username_user AS uu__username_user,uu.password_user AS uu__password_user,uu.code AS uu__code,uu.code_expired_at AS uu__code_expired_at,uu.enrolled_by AS uu__enrolled_by,uu.enroll_code AS uu__enroll_code,uu.enroll_expired_at AS uu__enroll_expired_at,uu.provinsi_id AS uu__provinsi_id,uu.kab_kota_id AS uu__kab_kota_id,uu.kecamatan_id AS uu__kecamatan_id,uu.kelurahan_id AS uu__kelurahan_id,uu.jenis_kelamin AS uu__jenis_kelamin,uu.marital AS uu__marital,uu.tempat_lahir AS uu__tempat_lahir,uu.tanggal_lahir AS uu__tanggal_lahir,uu.nik AS uu__nik,uu.jalan AS uu__jalan,uu.dusun AS uu__dusun,uu.rt AS uu__rt,uu.rw AS uu__rw,uu.no_rumah AS uu__no_rumah,uu.blok AS uu__blok,uu.kode_pos AS uu__kode_pos,uu.agama_id AS uu__agama_id,uu.pekerjaan_id AS uu__pekerjaan_id,uu.penghasilan_id AS uu__penghasilan_id,uu.jenjang_id AS uu__jenjang_id,uu.foto_profil AS uu__foto_profil,uu.tentang AS uu__tentang,uu.created_at AS uu__created_at,uu.updated_at AS uu__updated_at";
		$data = DB::select("
			SELECT ur.id, nama_user AS uu__nama_user
			FROM user_role ur
			LEFT JOIN users uu ON ur.user_id = uu.id
			WHERE
				ur.deleted_at IS NULL
				AND EXISTS (SELECT * FROM evaluasi_pengetahuan et WHERE et.deleted_at IS NULL AND ur.id = et.user_role_id)
				AND EXISTS (SELECT * FROM evaluasi_sikap es WHERE es.deleted_at IS NULL AND ur.id = es.user_role_id)
				AND EXISTS (SELECT * FROM evaluasi_praktik ep WHERE ep.deleted_at IS NULL AND ur.id = ep.user_role_id)
				AND EXISTS (SELECT * FROM evaluasi_motivasi em WHERE em.deleted_at IS NULL AND ur.id = em.user_role_id)
				AND EXISTS (SELECT * FROM evaluasi_dukungan ed WHERE ed.deleted_at IS NULL AND ur.id = ed.user_role_id)
		");

		return $this->afterMiddleware([
			'from'		=> "Evaluasi@list",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> $data
		]);
	}

	public function listCreatedAt(Request $request, $user_role_id) {
		$data = DB::select("
			SELECT ur.id,uu.nama_user AS uu__nama_user,uu.jenis_kelamin AS uu__jenis_kelamin,uu.tanggal_lahir AS uu__tanggal_lahir,uu.agama_id AS uu__agama_id,uu.jenjang_id AS uu__jenjang_id
			FROM user_role ur
			LEFT JOIN users uu ON ur.user_id = uu.id
			WHERE ur.id = :user_role_id
		",['user_role_id'=>$user_role_id]);

		$new_data = array_map(function($row) use ($user_role_id) {
			$row->created_ats = DB::select("SELECT DISTINCT(created_at) FROM evaluasi_pengetahuan et WHERE et.deleted_at IS NULL AND user_role_id = :user_role_id ORDER BY created_at DESC",['user_role_id'=>$user_role_id]);
			return $row;
		},$data); 

		return $this->afterMiddleware([
			'from'		=> "Evaluasi@listCreatedAt",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> $new_data
		]);
	}

	public function detailsById(Request $request, $user_role_id, $created_at) {
		// $column_evaluasi_pengetahuan 	= "et.id AS et__id,et.user_role_id AS et__user_role_id,et.n AS et__n,et.a AS et__a,et.created_at AS et__created_at,et.updated_at AS et__updated_at";
		// $column_evaluasi_sikap 			= "es.id AS es__id,es.user_role_id AS es__user_role_id,es.n AS es__n,es.a AS es__a,es.created_at AS es__created_at,es.updated_at AS es__updated_at";
		// $column_evaluasi_praktik 		= "ep.id AS ep__id,ep.user_role_id AS ep__user_role_id,ep.n AS ep__n,ep.a AS ep__a,ep.created_at AS ep__created_at,ep.updated_at AS ep__updated_at";
		// $column_evaluasi_motivasi 		= "em.id AS em__id,em.user_role_id AS em__user_role_id,em.n AS em__n,em.a AS em__a,em.created_at AS em__created_at,em.updated_at AS em__updated_at";
		// $column_evaluasi_dukungan 		= "ed.id AS ed__id,ed.user_role_id AS ed__user_role_id,ed.n AS ed__n,ed.a AS ed__a,ed.created_at AS ed__created_at,ed.updated_at AS ed__updated_at";

		$data = DB::select("
			SELECT ur.id,uu.nama_user AS uu__nama_user,uu.jenis_kelamin AS uu__jenis_kelamin,uu.tanggal_lahir AS uu__tanggal_lahir,uu.agama_id AS uu__agama_id,uu.jenjang_id AS uu__jenjang_id
			FROM user_role ur
			LEFT JOIN users uu ON ur.user_id = uu.id
			WHERE ur.id = :user_role_id
		",['user_role_id'=>$user_role_id]);

		$new_data = array_map(function($row) use ($user_role_id, $created_at) {
			$row->evaluasi_pengetahuan 	= DB::select("SELECT n,a FROM evaluasi_pengetahuan et WHERE et.deleted_at IS NULL AND et.user_role_id = :user_role_id AND et.created_at = :created_at ORDER BY n ASC",['user_role_id'=>$user_role_id,'created_at'=>$created_at]);
			$row->evaluasi_sikap 		= DB::select("SELECT n,a FROM evaluasi_sikap es WHERE es.deleted_at IS NULL AND es.user_role_id = :user_role_id AND es.created_at = :created_at ORDER BY n ASC",['user_role_id'=>$user_role_id,'created_at'=>$created_at]);
			$row->evaluasi_praktik 		= DB::select("SELECT n,a FROM evaluasi_praktik ep WHERE ep.deleted_at IS NULL AND ep.user_role_id = :user_role_id AND ep.created_at = :created_at ORDER BY n ASC",['user_role_id'=>$user_role_id,'created_at'=>$created_at]);
			$row->evaluasi_motivasi 	= DB::select("SELECT n,a FROM evaluasi_motivasi em WHERE em.deleted_at IS NULL AND em.user_role_id = :user_role_id AND em.created_at = :created_at ORDER BY n ASC",['user_role_id'=>$user_role_id,'created_at'=>$created_at]);
			$row->evaluasi_dukungan 	= DB::select("SELECT n,a FROM evaluasi_dukungan ed WHERE ed.deleted_at IS NULL AND ed.user_role_id = :user_role_id AND ed.created_at = :created_at ORDER BY n ASC",['user_role_id'=>$user_role_id,'created_at'=>$created_at]);
			return $row;
		},$data);

		return $this->afterMiddleware([
			'from'		=> "Evaluasi@detailsById",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> $new_data[0]
		]);
	}
}