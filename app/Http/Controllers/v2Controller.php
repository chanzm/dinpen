<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Master;
use JWTAuth;
use App\Position;
use DB;
use FilesystemIterator;
use Session;
use App\FotoStatus;
class v2Controller extends Controller
{
    public function welcome()
    {
        $message = "success";
        $data = "Selamat Datang V2";
        return response()->json(compact('message','data'),200);
    }
    public function login(Request $request)
    {
        $now = date_create()->format('Y-m-d H:i:s');
        // safety method
        if($request->isMethod('Post'))
        {
            // inisiai Json
            $data=[];
            $data ['nip'] = null;
            $data ['nama'] = null;
            $data ['token'] = null;
            $data ['posisi'] = null;
            $data ['imei'] = null;
            $data ['ttd'] = null;
            // safety field
            if ($request->nip == null and $request->password == null)
            {
                $message = "Fill all Comlumn";
                return response()->json(compact('message','data'),400);
            }
            // get user
            $user = Master::where('user_id','=',$request->nip)->where('user_password','=',md5($request->password))->first();
            if ($user)
            {
                // make token
                $token = JWTAuth::fromUser($user);

                // insert to table generate
                $check = DB::table('public.Tabel_Generate')->where('id_user',$user->user_id)->count();
                if($check==0)
                {
                    $server_token = DB::table('public.Tabel_Generate')->where('id_user',$user->user_id)->insert(['token'=>$token,'id_user'=>$user->user_id,'generate_time'=>$now]);
                }
                else{
                    $server_token = DB::table('public.Tabel_Generate')->where('id_user',$user->user_id)->update(['token'=>$token,'generate_time'=>$now]);
                }
                // find user position
                $posisi = DB::table('public.schema_akses')->where('user_id','=',$request->nip)->first();
                $data ['nip'] = $user->user_id;
                $data ['nama'] = $user->user_name;
                $data ['token'] = $token;
                $data ['posisi'] = $posisi->level_id;
                $data ['imei'] = $user->imei;
                $data ['ttd'] = $user->status_ttd;
                $message = "success";

            }
            else
            {
                // not found
                $message = "Not Found";
            }
            return response()->json(compact('message','data'),200);
        }
        else
        {
            $message = "Method Not Allowed";
            return response()->json(compact('message','data'),405);
        }
    }
    public function sekolah(Request $request){
        if($request->isMethod('Post')) {
            if($request->nip==null)
            {
                $message = "Fill all Comlumn";
                return response()->json(compact('message','data'),400);
            }
            else {
                $token = DB::table('Tabel_Generate')
                    ->where('id_user',$request->nip)
                    ->select('token')
                    ->first();
                $param_tanggal = $request->tanggal;
                $param_nip = $request->nip;
                $first = md5(md5($param_tanggal).md5($param_nip));

                $now = date_create()->format('d/m/Y');
                $second =md5($token->token);
                $md5_sign = md5($first.$second);
                if($md5_sign==$request->parammd5)
                {
                    $sekolah = DB::table('public.detail_kepala_sekolah_unit_kerja')
                        ->leftjoin('public.unit_kerja','public.detail_kepala_sekolah_unit_kerja.unit_id','public.unit_kerja.unit_id')
                        ->where('nip_kepala_sekolah','=',$request->nip)
                        ->whereNotNull('periode_awal_kepala_sekolah')
                        ->whereNotNull('periode_akhir_kepala_sekolah')
                        ->where('periode_awal_kepala_sekolah','<=',$now)
                        ->where('periode_akhir_kepala_sekolah','>=',$now)
                        ->where('verified',true)
                        ->select('public.detail_kepala_sekolah_unit_kerja.unit_id','public.unit_kerja.unit_name')
                        ->get();
                    $message = "success";
                    $data=[];
                    if ($sekolah)
                    {
                        $data ['sekolah'] =$sekolah;
                    }
                    else
                    {
                        $data ['sekolah'] =[];
                    }
                    return response()->json(compact('message','data'),200);
                }
                else
                {
                    $message = "fail params";
                    $data=[];
                    return response()->json(compact('message','data'),200);
                }

            }

        }
        else
        {
            $message = "Method Not Allowed";
            return response()->json(compact('message','data'),405);
        }

    }

}


