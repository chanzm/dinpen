<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use App\User;
use App\Unit_kerja;
use App\Detail_unit_kerja;
use App\Detail_transaksi;
use App\Transaksi;


class ApiController extends Controller
{
    public function index()
    {
    	return response()->json([
    		'message' => 'selamat datang'
    	],200);
    }

    public function login(Request $request)
    {
    	$credentials = [
    		'email' => $request->email,
    		'password' => $request->password
    	];

    	$token = null;
    	try
    	{
    		if (!$token = JwtAuth::attempt($credentials))
    		{
    			return response()->json([
                    'message' => 'Failed',
                    'token' => ""
                ],404);
    		}
    	}
    	catch (JwtAuthException $e)
    	{
    		return response()->json(["halo"=>"hai"],404);
    	}
    	return response()->json([
    		'message' => 'Success',
    		'token' => $token
    	],200);
    }

    public function detail(Request $request)
    {
        $flight  = \App\Unit_kerja::with('kepala.user','bendahara_bos.user','bendahara_unit.user','bank')->get();
        return response()->json([
            'message' => 'Success',
            'data' => $flight
        ],200);
    }

    public function detail_kepala(Request $request)
    {
        // $flight =  \App\User::with('kepala.unit')->get();
        $header = $request->header('Authorization');
        $pieces = explode(" ", $header);
        $user = JWTAuth::toUser($pieces[1]);
        $flight =  \App\User::with('kepala.unit')->where('id','=' ,$user->id)->get();
        return response()->json([
            'message' => 'Success',
            'data' => $flight
        ],200);
    }

    public function cek_imei(Request $request)
    {
        $header = $request->header('Authorization');
        $pieces = explode(" ", $header);
        $user = JWTAuth::toUser($pieces[1]);
        $flight =  \App\User::with('kepala.unit')->where('id','=' ,$user->id)->first();
        $imei = $flight->kepala->imei;
        return response()->json([
            'message' => 'Success',
            'data' => $imei
        ],200);
    }

    public function auth_imei(Request $request)
    {
        if ($request->imei==null)
        {
            return response()->json([
                'message' => 'Must fill imei',
                ],401);
        }
        else
        {
            $header = $request->header('Authorization');
            $pieces = explode(" ", $header);
            $user = JWTAuth::toUser($pieces[1]);
            $flight =  \App\User::with('kepala.unit')->where('id','=' ,$user->id)->first();
            $imei = $flight->kepala->imei;
            if ($imei == $request->imei)
            {
                return response()->json([
                'message' => 'Success validation',
                ],200);
            }
            else
            {
                JWTAuth::invalidate($pieces[1]);
                return response()->json([
                'message' => 'failed validation',
                ],200);
            }
        }
    }

    public function fill_imei(Request $request)
    {
        if ($request->imei==null)
        {
            return response()->json([
                'message' => 'Must fill imei',
                ],401);
        }
        else
        {
            $header = $request->header('Authorization');
            $pieces = explode(" ", $header);
            $user = JWTAuth::toUser($pieces[1]);
            $flight =  \App\User::with('kepala.unit')->where('id','=' ,$user->id)->first();
            $kepala = $flight->kepala;
            $test=$kepala->imei = $request->imei;
            $kepala->save();
            // dd($kepala);
            if($test)
            {
                return response()->json([
                'message' => 'Sucess Created',
                ],200);
            }
            else
            {
                return response()->json([
                'message' => 'Failed Created',
                ],200);
            }
        }
        
    }

    public function transaksi (Request $request)
    {
        $header = $request->header('Authorization');
        $pieces = explode(" ", $header);
        $user = JWTAuth::toUser($pieces[1]);
        $kapal =  \App\User::with('kepala.unit')->where('id','=' ,$user->id)->first();
        $unit_id = $kapal->kepala->unit_id;
        $flights  = \App\Transaksi::with('detail')->where('unit_id','=',$unit_id)->get();
        $hasil = [];
        foreach ($flights as $flight) {
            if($flight->detail->count()) {
                $hasil[] = $flight;
            }
        }

        return response()->json([
            'message' => 'Success',
            'data' => $hasil
        ],200);
    }

    public function detail_transaksi($id)
    {
        $flight  = \App\Transaksi::with('detail_of')->where('id_transaksi','=',$id)->first();
        return response()->json([
            'message' => 'Success',
            'data' => $flight
        ],200);
    }

    public function berhasil(Request $request)
    {
        $flight  = \App\Detail_transaksi::find($request->id);
        $flight->status = 1;
        return response()->json([
            'message' => 'Success',
            'data' => $flight
        ],200);
    }

    public function personal(Request $request)
    {
        $header = $request->header('Authorization');
        $pieces = explode(" ", $header);
        $user = JWTAuth::toUser($pieces[1]);
        $flight =  \App\User::with('kepala.unit')->where('id','=' ,$user->id)->first();
         return response()->json([
            'message' => 'Success',
            'data' => $flight
        ],200);
    }
}
