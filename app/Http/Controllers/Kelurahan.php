<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Aura\SqlQuery\QueryFactory;
use App\Helper\ControllerHelper;

class Kelurahan extends Controller {
    public function get(Request $request, $id = NULL) {
    	$query_factory = new QueryFactory(env('DB_CONNECTION'));
    	$select = $query_factory->newSelect();
    	$count 	= $query_factory->newSelect();
    	$select->from('ref_kelurahan AS kl')
    	->join('LEFT','ref_kecamatan AS kc','kl.kecamatan_id = kc.id')
    	->join('LEFT','ref_kab_kota AS kk','kc.kab_kota_id = kk.id')
    	->join('LEFT','ref_provinsi AS pr','kk.provinsi_id = pr.id');
    	$count->from('ref_kelurahan AS kl');

    	$count->cols(['COUNT(*) as jumlah']);
    	if($request->has('attributes') && $request->get('attributes') !== NULL && $request->get('attributes') !== '') {
    		$select->cols(ControllerHelper::stringToSingleArray($request->get('attributes'),['id'=>'kl.id']));
    	} else {
    		$select->cols(['kl.id','nama_kelurahan','kecamatan_id','nama_kecamatan','kab_kota_id','nama_kab_kota','provinsi_id','nama_provinsi']);
    	}

    	if($id) {
    		$select->where('kl.id = :id',['id'=>$id]);
	    	$data = DB::select($select->getStatement(),$select->getBindValues());

	    	return $this->afterMiddleware([
				'from'		=> "Kelurahan@get",
				'code'		=> 200,
				'status'	=> "success",
				'message'	=> "",
				'desc'		=> [],
				'data'		=> $data[0]
			]);
    	}

    	if($request->has('nama_kelurahan') && $request->get('nama_kelurahan') !== NULL && $request->get('nama_kelurahan') !== '') {
    		$select->where('nama_kelurahan ILIKE :nama_kelurahan',['nama_kelurahan'=>'%'.$request->get('nama_kelurahan').'%']);
    		$count->where('nama_kelurahan ILIKE :nama_kelurahan',['nama_kelurahan'=>'%'.$request->get('nama_kelurahan').'%']);
    	}
    	if($request->has('kecamatan_id') && $request->get('kecamatan_id') !== NULL && $request->get('kecamatan_id') !== '') {
    		$select->where('kecamatan_id = :kecamatan_id',['kecamatan_id'=>$request->get('kecamatan_id')]);
    		$count->where('kecamatan_id = :kecamatan_id',['kecamatan_id'=>$request->get('kecamatan_id')]);
    	}
    	if($request->has('nama_kecamatan') && $request->get('nama_kecamatan') !== NULL && $request->get('nama_kecamatan') !== '') {
    		$select->where('nama_kecamatan ILIKE :nama_kecamatan',['nama_kecamatan'=>'%'.$request->get('nama_kecamatan').'%']);
    		$count->where('nama_kecamatan ILIKE :nama_kecamatan',['nama_kecamatan'=>'%'.$request->get('nama_kecamatan').'%']);
    	}
    	if($request->has('kab_kota_id') && $request->get('kab_kota_id') !== NULL && $request->get('kab_kota_id') !== '') {
    		$select->where('kab_kota_id = :kab_kota_id',['kab_kota_id'=>$request->get('kab_kota_id')]);
    		$count->where('kab_kota_id = :kab_kota_id',['kab_kota_id'=>$request->get('kab_kota_id')]);
    	}
    	if($request->has('nama_kab_kota') && $request->get('nama_kab_kota') !== NULL && $request->get('nama_kab_kota') !== '') {
    		$select->where('nama_kab_kota ILIKE :nama_kab_kota',['nama_kab_kota'=>'%'.$request->get('nama_kab_kota').'%']);
    		$count->where('nama_kab_kota ILIKE :nama_kab_kota',['nama_kab_kota'=>'%'.$request->get('nama_kab_kota').'%']);
    	}
    	if($request->has('provinsi_id') && $request->get('provinsi_id') !== NULL && $request->get('provinsi_id') !== '') {
    		$select->where('provinsi_id = :provinsi_id',['provinsi_id'=>$request->get('provinsi_id')]);
    		$count->where('provinsi_id = :provinsi_id',['provinsi_id'=>$request->get('provinsi_id')]);
    	}
    	if($request->has('nama_provinsi') && $request->get('nama_provinsi') !== NULL && $request->get('nama_provinsi') !== '') {
    		$select->where('nama_provinsi ILIKE :nama_provinsi',['nama_provinsi'=>'%'.$request->get('nama_provinsi').'%']);
    		$count->where('nama_provinsi ILIKE :nama_provinsi',['nama_provinsi'=>'%'.$request->get('nama_provinsi').'%']);
    	}
    	if($request->has('in') && $request->get('in') !== NULL && $request->get('in') !== '') {
            $ins = ControllerHelper::stringToMultipleArray($request->get('in'));
            foreach ($ins as $in) {
                $column = array_shift($in);
                $select->where($column.' IN (:in)',['in'=>$in]);
            }
        }
        if($request->has('notIn') && $request->get('notIn') !== NULL && $request->get('notIn') !== '') {
            $notIns = ControllerHelper::stringToMultipleArray($request->get('notIn'));
            foreach ($notIns as $notIn) {
                $column = array_shift($notIn);
                $select->where($column.' NOT IN (:notIn)',['notIn'=>$notIn]);
            }
        }

    	$sort = 'id asc';
    	if($request->has('sort_by') && $request->get('sort_by') !== NULL && $request->get('sort_by') !== '') {
    		if($request->get('sort_by') == 'random' || $request->get('sort_by') == 'rand') {
    			if(env('DB_CONNECTION') == 'mysql') $select->orderBy(['rand()']);
    			else $select->orderBy(['random()']);
    		} else {
				$sort = $request->get('sort_by');
				if($request->has('sort_type') && $request->get('sort_type') !== NULL && $request->get('sort_type') !== '') {
					$sort .= ' ';
					$sort .= $request->get('sort_type');
		    	}
    		}
    	}
    	$select->orderBy([$sort]);

    	if($request->has('page') && $request->get('page') !== NULL && $request->get('page') !== '' && $request->has('limit') && $request->get('limit') !== NULL && $request->get('limit') !== '') {
    		$page 	= $request->get('page');
    		$limit 	= $request->get('limit');
    	} else {
    		$page 	= 1;
    		$limit 	= 100; 
    	}
		$select->limit($limit);
		$select->offset(($page-1)*$limit);

		$data = DB::select($select->getStatement(),$select->getBindValues());
		$jumlah = DB::select($count->getStatement(),$count->getBindValues());
    	return $this->afterMiddleware([
			'from'		=> "Kelurahan@get",
			'code'		=> 200,
			'status'	=> "success",
			'message'	=> "",
			'desc'		=> [],
			'data'		=> $data,
			'page'		=> intval($page),
			'limit'		=> intval($limit),
			'count'		=> intval($jumlah[0]->jumlah)

		]);
    }
}
