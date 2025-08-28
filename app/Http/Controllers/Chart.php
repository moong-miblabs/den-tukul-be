<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Aura\SqlQuery\QueryFactory;

class Chart extends Controller {

	public function evaluasiPengetahuan() {
		$data = DB::transaction(function() {
			$tepat1 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 1");
			$meleset1 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 1");

			$tepat2 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 2");
			$meleset2 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 2");

			$tepat3 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 3");
			$meleset3 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 3");

			$tepat4 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 4");
			$meleset4 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 4");

			$tepat5 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 5");
			$meleset5 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 5");

			$tepat6 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 6");
			$meleset6 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 6");

			$tepat7 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 7");
			$meleset7 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 7");

			$tepat8 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 8");
			$meleset8 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 8");

			$tepat9 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 9");
			$meleset9 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 9");

			$tepat10 = DB::scalar("SELECT COUNT(et.id) as jumlah_tepat FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 1 AND n = 10");
			$meleset10 = DB::scalar("SELECT COUNT(et.id) as jumlah_meleset FROM evaluasi_pengetahuan et LEFT JOIN user_role ur ON et.user_role_id = ur.id WHERE et.deleted_at IS NULL AND ur.deleted_at IS NULL AND s = 0 AND n = 10");

			return ['tepat'=>[$tepat1,$tepat2,$tepat3,$tepat4,$tepat5,$tepat6,$tepat7,$tepat8,$tepat9,$tepat10],'meleset'=>[$meleset1,$meleset2,$meleset3,$meleset4,$meleset5,$meleset6,$meleset7,$meleset8,$meleset9,$meleset10]];
		});

		return $this->afterMiddleware([
            'from'      => "Chart@evaluasiPengetahuan",
            'code'      => 200,
            'status'    => "success",
            'message'   => "",
            'desc'      => [],
            'data'      => $data
        ]);
	}

	public function deteksi() {
		$data = DB::transaction(function() {
			$assoc = [];

			$assoc['batuk']['seq'] = 1;
			$assoc['batuk']['title'] = "Batuk Berkepanjangan";
			$assoc['batuk']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q1 = '1'");

			$assoc['penurunan berat badan']['seq'] = 2;
			$assoc['penurunan berat badan']['title'] = "Penurunan Berat Badan";
			$assoc['penurunan berat badan']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q2 = '1'");

			$assoc['demam']['seq'] = 3;
			$assoc['demam']['title'] = "Demam Ringan";
			$assoc['demam']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q3 = '1'");

			$assoc['keringat malam']['seq'] = 4;
			$assoc['keringat malam']['title'] = "Keringat Malam";
			$assoc['keringat malam']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q4 = '1'");

			$assoc['kelelahan']['seq'] = 5;
			$assoc['kelelahan']['title'] = "Kelelahan dan Kelemahan";
			$assoc['kelelahan']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q5 = '1'");

			$assoc['nyeri dada']['seq'] = 6;
			$assoc['nyeri dada']['title'] = "Nyeri Dada";
			$assoc['nyeri dada']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q6 = '1'");

			$assoc['sesak nafas']['seq'] = 7;
			$assoc['sesak nafas']['title'] = "Sesak Napas";
			$assoc['sesak nafas']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q7 = '1'");

			$assoc['kehilangan nafsu makan']['seq'] = 8;
			$assoc['kehilangan nafsu makan']['title'] = "Kehilangan Nafsu Makan";
			$assoc['kehilangan nafsu makan']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q8 = '1'");

			$assoc['pembengkakan kelenjar getah bening']['seq'] = 9;
			$assoc['pembengkakan kelenjar getah bening']['title'] = "Pembengkakan Kelenjar Getah Bening";
			$assoc['pembengkakan kelenjar getah bening']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q9 = '1'");

			$assoc['pucat']['seq'] = 10;
			$assoc['pucat']['title'] = "Kulit Pucat";
			$assoc['pucat']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q10 = '1'");

			$assoc['perubahan prilaku']['seq'] = 11;
			$assoc['perubahan prilaku']['title'] = "Perubahan Perilaku";
			$assoc['perubahan prilaku']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q11 = '1'");

			$assoc['gangguan pertumbuhan']['seq'] = 12;
			$assoc['gangguan pertumbuhan']['title'] = "Gangguan Pertumbuhan";
			$assoc['gangguan pertumbuhan']['jum'] = DB::scalar("SELECT COUNT(d.id) as jumlah FROM deteksi d LEFT JOIN user_role ur ON d.user_role_id = ur.id WHERE d.deleted_at IS NULL AND ur.deleted_at IS NULL AND q12 = '1'");

			return $assoc;
		});

		return $this->afterMiddleware([
            'from'      => "Chart@deteksi",
            'code'      => 200,
            'status'    => "success",
            'message'   => "",
            'desc'      => [],
            'data'      => $data
        ]);
	}

	public function evaluasiPraktik() {
		$data = DB::transaction(function () {
			$praktik_baik = DB::scalar("SELECT COUNT(*) as jumlah FROM evaluasi_praktik_result rp LEFT JOIN user_role ur ON rp.user_role_id = ur.id WHERE rp.deleted_at IS NULL AND ur.deleted_at IS NULL AND c = 'Baik'");
			$praktik_kurang = DB::scalar("SELECT COUNT(*) as jumlah FROM evaluasi_praktik_result rp LEFT JOIN user_role ur ON rp.user_role_id = ur.id WHERE rp.deleted_at IS NULL AND ur.deleted_at IS NULL AND c = 'Kurang'");

			return ['praktik baik' => $praktik_baik, 'praktik kurang' => $praktik_kurang];
		});

		return $this->afterMiddleware([
            'from'      => "Chart@evaluasiPraktik",
            'code'      => 200,
            'status'    => "success",
            'message'   => "",
            'desc'      => [],
            'data'      => $data
        ]);
	}

	public function evaluasiSikap() {
		$data = DB::transaction(function () {
			$sikap_mendukung = DB::scalar("SELECT COUNT(*) as jumlah FROM evaluasi_sikap_result sp LEFT JOIN user_role ur ON sp.user_role_id = ur.id WHERE sp.deleted_at IS NULL AND ur.deleted_at IS NULL AND c = 'Positif'");
			$sikap_tidak_mendukung = DB::scalar("SELECT COUNT(*) as jumlah FROM evaluasi_sikap_result sp LEFT JOIN user_role ur ON sp.user_role_id = ur.id WHERE sp.deleted_at IS NULL AND ur.deleted_at IS NULL AND c = 'Negatif'");

			return ['mendukung' => $sikap_mendukung, 'tidak mendukung' => $sikap_tidak_mendukung];
		});

		return $this->afterMiddleware([
            'from'      => "Chart@evaluasiSikap",
            'code'      => 200,
            'status'    => "success",
            'message'   => "",
            'desc'      => [],
            'data'      => $data
        ]);
	}
}