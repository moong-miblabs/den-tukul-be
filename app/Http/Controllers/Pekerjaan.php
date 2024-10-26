<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Aura\SqlQuery\QueryFactory;
use App\Helper\ControllerHelper;

class Pekerjaan extends Controller {
    public function get(Request $request, $id = NULL) {
    	$query_factory = new QueryFactory(env('DB_CONNECTION'));
    	$select = $query_factory->newSelect();
    	$count 	= $query_factory->newSelect();
    	$select->from('ref_pekerjaan AS pk');
    	$count->from('ref_pekerjaan AS pk');

    	$count->cols(['COUNT(*) as jumlah']);
    	if($request->has('attributes') && $request->get('attributes') !== NULL && $request->get('attributes') !== '') {
    		$select->cols(ControllerHelper::stringToSingleArray($request->get('attributes')));
    	} else {
    		$select->cols(['id','nama_pekerjaan']);
    	}

    	if($id) {
    		$select->where('id = :id',['id'=>$id]);
	    	$data = DB::select($select->getStatement(),$select->getBindValues());

	    	return $this->afterMiddleware([
				'from'		=> "Pekerjaan@get",
				'code'		=> 200,
				'status'	=> "success",
				'message'	=> "",
				'desc'		=> [],
				'data'		=> $data[0]
			]);
    	}

    	if($request->has('nama_pekerjaan') && $request->get('nama_pekerjaan') !== NULL && $request->get('nama_pekerjaan') !== '') {
    		$select->where('nama_pekerjaan ILIKE :nama_pekerjaan',['nama_pekerjaan'=>'%'.$request->get('nama_pekerjaan').'%']);
    		$count->where('nama_pekerjaan ILIKE :nama_pekerjaan',['nama_pekerjaan'=>'%'.$request->get('nama_pekerjaan').'%']);
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
				$sort .= $request->get('sort_by');
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
			'from'		=> "Pekerjaan@get",
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
