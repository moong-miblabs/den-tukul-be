<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Helper\JsonwebtokenHelper;
use Illuminate\Support\Facades\DB;

class IsResponden {
    
    public function handle(Request $request, Closure $next): Response {
        $token = NULL;
        if($request->bearerToken()) {
            $token = $request->bearerToken();
        } elseif($request->header('Authorization')) {
            $authorization = $request->header('Authorization');
            $authorizations= explode(' ', $authorization);
            if(count($authorizations) > 1) {
                $token = $authorizations[1];
            } else {
                $token = $authorization;
            }
        } elseif($request->header('authorization')) {
            $authorization = $request->header('authorization');
            $authorizations= explode(' ', $authorization);
            if(count($authorizations) > 1) {
                $token = $authorizations[1];
            } else {
                $token = $authorization;
            }
        } elseif($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch') || $request->isMethod('delete')) {
            $token = $request->input('token');
        } elseif ($request->isMethod('get') || $request->isMethod('put') || $request->isMethod('patch') || $request->isMethod('delete')) {
            $token = $request->query('token');
        }

        if(!$token){
            return response()->json([
                'code'      => 401,
                'status'    => "error",
                'message'   => "Unauthorized",
                'desc'      => ['token' => 'required'],
                'data'      => NULL
            ],200);
        }

        // bypass
        if($token == 'CV.MIB Labs' && $request->isMethod('get')) return $next($request);

        $decoded = JsonwebtokenHelper::verify($token);
        if($decoded['error'] === FALSE){
            $data_token = $decoded['data'];
            $users = DB::select("SELECT ur.id, user_id, role_id FROM user_role ur LEFT JOIN users uu ON ur.user_id = uu.id LEFT JOIN ms_role mr ON ur.role_id = mr.id where uu.id = ? AND uu.password_user = ? AND uu.deleted_at IS NULL AND mr.nama_role = 'RESPONDEN' limit 1",[$data_token->id,$data_token->password_user]);
            if(!empty($users)) {
                $request->data_token    = $data_token;
                $request->data_user     = $users[0];
                return $next($request);
            } else {
                return response()->json([
                    'code'      => 401,
                    'status'    => "error",
                    'message'   => "Unauthorized",
                    'desc'      => ['token' => 'rejected'],
                    'data'      => NULL
                ],200);    
            }
        } else {
            return response()->json([
                'code'      => 401,
                'status'    => "error",
                'message'   => "Unauthorized",
                'desc'      => ['token' => 'error'],
                'data'      => NULL
            ],200);
        }
    }
}