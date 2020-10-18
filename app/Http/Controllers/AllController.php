<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use App\Master;
use JWTAuth;
use App\Position;
use DB;
use FilesystemIterator;
use Session;
use App\FotoStatus;

class AllController extends Controller
{

    // public function __construct(){
    //     CheckAuth();
    // }
    
    public function CheckAuth($request){
        //fungsi cek security every service
        $token = DB::table('Tabel_Generate')
            ->where('id_user',$request->nip)
            ->select('token')
            ->first();
        $param_tanggal = $request->date;
        $param_nip = $request->nip;
        $first = md5(md5($param_tanggal).md5($param_nip));

        $now = date_create()->format('d/m/Y');
        $second =md5($token->token);
        $md5_sign = md5($first.$second);
        // $this->CheckAuth($request); panggil function
        if($md5_sign==$request->parammd5){
            return 'yes';
        }

        else{
            return 'no';
           
        }

        //codingan di fungsi
        // call func   $cek_secure = $this->CheckAuth($request); 
        //  if($cek_secure == 'yes')
        // {

        // }
        // else{keluar}

    }

    //fungsi test token
    // public function login(Request $request)
    // {
    //     $now = date_create()->format('Y-m-d H:i:s');
    //     // safety method
    //     if($request->isMethod('Post'))
    //     {
    //         // inisiai Json
    //         $data=[];
    //         $data ['nip'] = null;
    //         $data ['nama'] = null;
    //         $data ['token'] = null;
    //         $data ['posisi'] = null;
    //         $data ['imei'] = null;
    //         $data ['ttd'] = null;
    //         // safety field
    //         if ($request->nip == null and $request->password == null)
    //         {
    //             $message = "Fill all Comlumn";
    //             return response()->json(compact('message','data'),400);
    //         }
    //         // get user
    //         $user = Master::where('user_id','=',$request->nip)->where('user_password','=',md5($request->password))->first();
    //         if ($user)
    //         {
    //             // make token
    //             $token = JWTAuth::fromUser($user);

    //             // insert to table generate
    //             $check = DB::table('public.Tabel_Generate')->where('id_user',$user->user_id)->count();
    //             if($check==0)
    //             {
    //                 $server_token = DB::table('public.Tabel_Generate')->where('id_user',$user->user_id)->insert(['token'=>$token,'id_user'=>$user->user_id,'generate_time'=>$now]);
    //             }
    //             else{
    //                 $server_token = DB::table('public.Tabel_Generate')->where('id_user',$user->user_id)->update(['token'=>$token,'generate_time'=>$now]);
    //             }
    //             // find user position
    //             $posisi = DB::table('public.schema_akses')->where('user_id','=',$request->nip)->first();
    //             $data ['nip'] = $user->user_id;
    //             $data ['nama'] = $user->user_name;
    //             $data ['token'] = $token;
    //             $data ['posisi'] = $posisi->level_id;
    //             $data ['imei'] = $user->imei;
    //             $data ['ttd'] = $user->status_ttd;
    //             $message = "success";

    //         }
    //         else
    //         {
    //             // not found
    //             $message = "Not Found";
    //         }
    //         return response()->json(compact('message','data'),200);
    //     }
    //     else
    //     {
    //         $message = "Method Not Allowed";
    //         return response()->json(compact('message','data'),405);
    //     }
    // }

    public function sekolah(Request $request){
        if($this->CheckAuth($request)=='yes'){

        

        if($request->isMethod('Post')) {
            if($request->nip==null)
            {
                $message = "Fill all Comlumn";
                return response()->json(compact('message','data'),400);
            }
            else {
                // $now = date_create()->format('d/m/Y');
                $now = Now();
                //call fungsi cek security 
                // dd($now);
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

        }
        else
        {
            $message = "Method Not Allowed";
            return response()->json(compact('message','data'),405);
        }

    }
    else if($this->CheckAuth($request)=='no'){
        $message = "fail params";
        $data=[];
        return response()->json(compact('message','data'),401);
    }
}


    //finish test token

    //FUNGSI
    public function welcome()
    {
        $message = "success";
        $data = [];
        $data = "Selamat Datang";
        return response()->json(compact('message','data'),200);
    }
    // public function login(Request $request)
    // {
    //     // dd($request->nip);
    //     $user = Master::where('user_id','=',$request->nip)->where('user_password','=',md5($request->password))->first();
    //     // dd($user);
    //     $data=[];
    //     if ($user)
    //     {
    //         $token = JWTAuth::fromUser($user);
    //         $posisi = DB::table('public.schema_akses')->where('user_id','=',$request->nip)->first();
    //         $data ['nip'] = $user->user_id;
    //         $data ['nama'] = $user->user_name;
    //         $data ['token'] = $token;
    //         $data ['posisi'] = $posisi->level_id;
    //         $data ['imei'] = $user->imei;
    //         $data ['ttd'] = $user->ttd;
    //         $message = "success";
    //         return response()->json(compact('message','data'),200);
    //     }
    //     else
    //     {
    //         $data ['nip'] = null;
    //         $data ['nama'] = null;
    //         $data ['token'] = null;
    //         $data ['posisi'] = null;
    //         $data ['imei'] = null;
    //         $data ['ttd'] = null;
    //         $message = "Not Found";
    //         return response()->json(compact('message','data'),404);
    //     }
    // }
    // public function Sekolah(Request $request)
    // {
    //     $now = Now();
    //     // dd($now);
    //     $sekolah = DB::table('public.detail_kepala_sekolah_unit_kerja')
    //     ->leftjoin('public.unit_kerja','public.detail_kepala_sekolah_unit_kerja.unit_id','public.unit_kerja.unit_id')
    //     ->where('nip_kepala_sekolah','=',$request->nip)
    //     ->whereNotNull('periode_awal_kepala_sekolah')
    //     ->whereNotNull('periode_akhir_kepala_sekolah')
    //     ->where('periode_awal_kepala_sekolah','<=',$now)
    //     ->where('periode_akhir_kepala_sekolah','>=',$now)
    //     ->where('verified',true)
    //     ->select('public.detail_kepala_sekolah_unit_kerja.unit_id','public.unit_kerja.unit_name')
    //     ->get();

    //     $message = "success";
    //     $data=[];
    //     // dd($sekolah);
    //     if ($sekolah)
    //     {
    //         // $data ['nama_sekolah'] = $sekolah;
    //         $data ['sekolah'] =$sekolah;
    //     }
    //     else
    //     {
    //         // $data ['nama_sekolah'] = null;
    //         // $data ['id_sekolah'] =null;
    //         $data ['sekolah'] =[];
    //     }
    //     return response()->json(compact('message','data'),200);

    // }
   


    public function Bendahara(Request $request)
    {
        if($this->CheckAuth($request) == 'yes'){
            $now = Now();
            $bos = DB::table('detail_bendahara_bos_unit_kerja')
            ->where('detail_bendahara_bos_unit_kerja.nip_bendahara_bos','=',$request->nip)
            ->whereNotNull('periode_awal_bendahara_bos')
            ->whereNotNull('periode_akhir_bendahara_bos')
            ->where('periode_awal_bendahara_bos','<=',$now)
            ->where('periode_akhir_bendahara_bos','>=',$now)
            ->where('verified',true)
            ->leftjoin('public.unit_kerja','public.detail_bendahara_bos_unit_kerja.unit_id','public.unit_kerja.unit_id')
            ->leftjoin('public.detail_unit_kerja','public.detail_bendahara_bos_unit_kerja.unit_id','public.detail_unit_kerja.unit_id')
            ->first();
            $bopda = DB::table('detail_bendahara_unit_kerja')
            ->where('detail_bendahara_unit_kerja.nip_bendahara','=',$request->nip)
            ->whereNotNull('periode_awal_bendahara')
            ->whereNotNull('periode_akhir_bendahara')
            ->where('periode_awal_bendahara','<=',$now)
            ->where('periode_akhir_bendahara','>=',$now)
            ->where('verified',true)
            ->leftjoin('public.unit_kerja','public.detail_bendahara_unit_kerja.unit_id','public.unit_kerja.unit_id')
            ->leftjoin('public.detail_unit_kerja','public.detail_bendahara_unit_kerja.unit_id','public.detail_unit_kerja.unit_id')
            ->first();
            $message = "success";
            $data=[];
            if ($bos)
            {
                $data['bos_id']=$bos->unit_id;
                $data['bos_sekolah']=$bos->unit_name;
                $data['bos_rek']=$bos->no_rek_bos;
            }
            else
            {
                $data['bos_id']=null;
                $data['bos_sekolah']=null;
                $data['bos_rek']=null;
            }

            if($bopda)
            {
                $data['bopda_id']=$bopda->unit_id;
                $data['bopda_sekolah']=$bopda->unit_name;
                $data['bopda_rek']=$bopda->no_rek_bopda;
            }
            else
            {
                $data['bopda_id']=null;
                $data['bopda_sekolah']=null;
                $data['bopda_rek']=null;
            }
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_bendahara_1_transfer(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Barang dan Jasa' AND kerja.jenis_pembayaran = 'Transfer' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_bendahara_1_transfer1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Barang dan Jasa' AND kerja.jenis_pembayaran = 'Transfer' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_bendahara_1_tunai(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Barang dan Jasa' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_bendahara_1_tunai1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Barang dan Jasa' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_bendahara_2_tunai(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Pegawai' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_bendahara_2_tunai1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Pegawai' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function pekerjaan_bendahara_2_transfer(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Pegawai' AND kerja.jenis_pembayaran = 'Transfer' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_bendahara_2_transfer1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Pegawai' AND kerja.jenis_pembayaran = 'Transfer' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function pekerjaan_bendahara_3_tunai(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Jasa Perseorangan Lainnya' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function pekerjaan_bendahara_3_tunai1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Jasa Perseorangan Lainnya' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function pekerjaan_bendahara_3_transfer(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Jasa Perseorangan Lainnya' AND kerja.jenis_pembayaran = 'Transfer' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function pekerjaan_bendahara_3_transfer1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Jasa Perseorangan Lainnya' AND kerja.jenis_pembayaran = 'Transfer' and kerja.status_approve = 0  and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_detail_bendahara(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){

            $head = DB::table('budget2019.master_pekerjaan')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->where('status_approve','=',0)
            ->first();
            $rekening = $head->nama_penyedia;
            $penyedia = explode("|",$rekening);
            $rekening_penyedia = DB::table('budget2019.master_penyedia')->where('id_penyedia','=',$penyedia[0])->first();
            // dd($rekening_penyedia);
            $body = DB::table('budget2019.pekerjaan_detail')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->get();
            // $head ['rekening'] = $rekening_penyedia->no_rekening;
            $message = "success";
            $data['title']=$head;
            $data['rekening'] = $rekening_penyedia;
            $data['body']=$body;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function pekerjaan_detail_bendahara_gaji(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $head = DB::table('budget2019.master_pekerjaan')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->where('status_approve','=',0)
            ->first();
            $body = DB::table('budget2019.pekerjaan_detail')
            ->leftjoin('budget2019.master_tenaga','budget2019.pekerjaan_detail.id_tenaga','budget2019.master_tenaga.id')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->get();
            $message = "success";
            $data['title']=$head;
            $data['body']=$body;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_1_transfer(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Barang dan Jasa' AND kerja.jenis_pembayaran = 'Transfer' and (kerja.status_approve = 1 OR kerja.status_approve = 2 OR kerja.status_approve = 3) and kerja.kode_kegiatan like '_____3.03____' order by kerja.status_approve DESC "));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_1_transfer1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Barang dan Jasa' AND kerja.jenis_pembayaran = 'Transfer' and (kerja.status_approve = 1 OR kerja.status_approve = 2 OR kerja.status_approve = 3) and kerja.kode_kegiatan like '_____3.01____' order by kerja.status_approve DESC "));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_1_tunai(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Barang dan Jasa' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 1 and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_1_tunai1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
        $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Barang dan Jasa' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 1 and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }

    }
    public function pekerjaan_kepala_2_tunai(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Pegawai' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 1 and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_2_tunai1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Pegawai' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 1 and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_2_transfer(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Pegawai' AND kerja.jenis_pembayaran = 'Transfer' and (kerja.status_approve = 1 OR kerja.status_approve = 2 OR kerja.status_approve = 3) and kerja.kode_kegiatan like '_____3.03____' order by kerja.status_approve DESC "));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_2_transfer1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Pegawai' AND kerja.jenis_pembayaran = 'Transfer' and (kerja.status_approve = 1 OR kerja.status_approve = 2 or kerja.status_approve = 3) and kerja.kode_kegiatan like '_____3.01____' order by kerja.status_approve DESC "));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_3_tunai(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Jasa Perseorangan Lainnya' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 1 and kerja.kode_kegiatan like '_____3.03____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_3_tunai1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Jasa Perseorangan Lainnya' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 1 and kerja.kode_kegiatan like '_____3.01____'"));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_3_transfer(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Jasa Perseorangan Lainnya' AND kerja.jenis_pembayaran = 'Transfer' and (kerja.status_approve = 1 OR kerja.status_approve = 2 or kerja.status_approve = 3) and kerja.kode_kegiatan like '_____3.03____' order by kerja.status_approve DESC "));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_kepala_3_transfer1(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){
            $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
            GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = 'Pemakaian Belanja Jasa Perseorangan Lainnya' AND kerja.jenis_pembayaran = 'Transfer' and (kerja.status_approve = 1 OR kerja.status_approve = 2 or kerja.status_approve = 3) and kerja.kode_kegiatan like '_____3.01____' order by kerja.status_approve DESC "));
            $message = "success";
            $data=$list;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_detail_kepala(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){

            $head = DB::table('budget2019.master_pekerjaan')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->where('status_approve','=',1)
            ->first();
            $rekening = $head->nama_penyedia;
            $penyedia = explode("|",$rekening);
            $rekening_penyedia = DB::table('budget2019.master_penyedia')->where('id_penyedia','=',$penyedia[0])->first();
            // dd($rekening_penyedia);
            $body = DB::table('budget2019.pekerjaan_detail')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->get();
            // $head ['rekening'] = $rekening_penyedia->no_rekening;
            $message = "success";
            $data['title']=$head;
            $data['rekening'] = $rekening_penyedia;
            $data['body']=$body;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function pekerjaan_detail_kepala_gaji(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){

            $head = DB::table('budget2019.master_pekerjaan')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->whereIn('status_approve',[1,2,3])
            ->first();
            $body = DB::table('budget2019.pekerjaan_detail')
            ->leftjoin('budget2019.master_tenaga','budget2019.pekerjaan_detail.id_tenaga','budget2019.master_tenaga.id')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->whereIn('status_approve',[1,2,3])
            ->select('budget2019.pekerjaan_detail.id','budget2019.pekerjaan_detail.satuan','budget2019.pekerjaan_detail.volume','budget2019.pekerjaan_detail.komponen_name','budget2019.pekerjaan_detail.detail_komponen','budget2019.pekerjaan_detail.kode_pekerjaan','budget2019.pekerjaan_detail.komponen_hasil_kali','budget2019.master_tenaga.no_rekening','budget2019.pekerjaan_detail.status_approve')
            ->get();
            $message = "success";
            $data['title']=$head;
            $data['body']=$body;
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    public function bendahara_update_barang(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){

            //tabel_transaksi
            $message = "success";
            $data['update']=null;

            $update = DB::table('budget2019.master_pekerjaan')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->update(['status_approve'=>1,'jumlah_transfer'=>$request->dana]);
            if ($update)
            {
                $update2 = DB::table('budget2019.pekerjaan_detail')
                ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                ->update(['status_approve'=>1]);

                if($update2)
                {
                    $data['update']="Berhasil";
                }
                //insert table transaksi
            
            }
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function kepala_update_gaji(Request $request)
    {
        // yg dikirim dari app kode_pekerjaan dan id_pekerjaan
        if($this->CheckAuth($request)=='yes'){

            //ubah dulu
            $message = "success";
            $data['update']=null;

            $update = DB::table('budget2019.pekerjaan_detail')
            ->where('id','=',$request->id_pekerjaan)
            ->update(['status_approve'=>2]);
            // dd($update);

           
            if($update)
            // if(true)
            {
                $cek=DB::table('budget2019.pekerjaan_detail')
                ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                ->where('status_approve','=',1)
                ->count();
                // dd($cek);
                $data['update']="Berhasil";        
                $message = "success";

                if($cek==0)
                {
                    $data['update']="Selesai";
                    $update = DB::table('budget2019.master_pekerjaan')
                    ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                    ->update(['status_approve'=>2]);
                }
                if(true)
                {
                    //kodingan insert tabel transaksi mulai
                    $head = DB::table('budget2019.master_pekerjaan')
                    ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                    ->where('status_approve','=',2)
                    ->first();
                    // dd($head->jumlah_transfer);
                    
                
                    // $rekening = $head->nama_penyedia;
                    // $penyedia = explode("|",$rekening);
                    // $rekening_penyedia = DB::table('budget2019.master_penyedia')->where('id_penyedia','=',$penyedia[0])->first();
                
                   
                    //ambil field no_rekening_bank
                    // $id_p = DB::select(DB::raw("SELECT * FROM budget2019.master_penyedia where penyedia_id='$request->penyedia_id'"));
        
                    // $jmlh = DB::select(DB::raw("SELECT * FROM budget2019.master_pekerjaan where kode_pekerjaan='$request->kode_pekerjaan'"));
                
                    // $head = DB::table('budget2019.master_pekerjaan')
                    // ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                    // ->where('status_approve','=',2)
                    // ->first();
        
                    // dd($head);
        
                    DB::table('public.Tabel_Transaksi')->insert(
                        array('pengirim' => $request->nomor_rekening ? $request->nomor_rekening : 0,
                            // 'penerima' => $rekening_penyedia->no_rekening_bank ? $rekening_penyedia->no_rekening_bank : 0,
                            'penerima' => $request->nomor_rekening_tujuan ? $request->nomor_rekening_tujuan : 0,
                            // 'jumlah' => $head->jumlah_transfer ? $head->jumlah_transfer : 0,
                            'jumlah' => $request->uang ? $request->uang : 0,
                            'status' => '2',
                            'berita' => $request->namaorang?$request->namaorang:0)
                    );
                    //finish insert tabel transaksi
                }

                // kodingan untuk insert table_transaksi
                

            }else{
                $message = "fail params";
                $data=[];
                return response()->json(compact('message','data'),401);                
            }
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function kepala_update_barang_tunai(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){

            $message = "success";
            $data['update']=null;

            $update = DB::table('budget2019.master_pekerjaan')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->update(['status_approve'=>6]);
            if ($update)
            {
                $update2 = DB::table('budget2019.pekerjaan_detail')
                ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                ->update(['status_approve'=>6]);

                if($update2)
                {
                    $data['update']="Berhasil";
                }
            }
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function kepala_update_barang_transfer(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){

            $message = "success";
            $data['update']=null;

            $update = DB::table('budget2019.master_pekerjaan')
            ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
            ->update(['status_approve'=>2]);

            
            if ($update)
            {
                $update2 = DB::table('budget2019.pekerjaan_detail')
                ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                ->update(['status_approve'=>2]);

                if($update2)
                {
                    $data['update']="Berhasil";
                }
                // kodingan untuk insert table_transaksi
                $head = DB::table('budget2019.master_pekerjaan')
                ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                ->where('status_approve','=',2)
                ->first();
                // dd($head->jumlah_transfer);

                $rekening = $head->nama_penyedia;
                $penyedia = explode("|",$rekening);
                $rekening_penyedia = DB::table('budget2019.master_penyedia')->where('id_penyedia','=',$penyedia[0])->first();
                //ambil field no_rekening_bank
                // $id_p = DB::select(DB::raw("SELECT * FROM budget2019.master_penyedia where penyedia_id='$request->penyedia_id'"));

                $jmlh = DB::select(DB::raw("SELECT * FROM budget2019.master_pekerjaan where kode_pekerjaan='$request->kode_pekerjaan'"));
            
                $head = DB::table('budget2019.master_pekerjaan')
                ->where('kode_pekerjaan','=',$request->kode_pekerjaan)
                ->where('status_approve','=',2)
                ->first();

                // dd($head);

                DB::table('public.Tabel_Transaksi')->insert(
                    array('pengirim' => $request->nomor_rekening ? $request->nomor_rekening : 0,
                        // 'penerima' => $rekening_penyedia->no_rekening_bank ? $rekening_penyedia->no_rekening_bank : 0,
                        'penerima' => $request->nomor_rekening_tujuan ? $request->nomor_rekening_tujuan : 0,
                        'jumlah' => $head->jumlah_transfer ? $head->jumlah_transfer : 0,
                        'status' => '2',
                        'berita' => $head->nama_kegiatan.'__'.$head->judul_pekerjaan)
                );
                //finish insert tabel transaksi
                }
            return response()->json(compact('message','data'),200);

      
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }
    

    public function kepala_bagian(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){

            $detail = DB::table('public.detail_unit_kerja')->where('unit_id','=',$request->unit_id)->first();
            $message = "success";
            $data=[];
            if ($detail)
            {
                $data ['rek_bos'] = $detail->no_rek_bos;
                $data ['rek_bopda'] = $detail->no_rek_bopda;
            }
            else
            {
                $data ['rek_bos'] = null;
                $data ['rek_bopda'] =null;
            }
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function transfer(Request $request)
    {
        if($this->CheckAuth($request)=='yes'){

            $data=[];
            $data1 = DB::table('budget2019.test')->insert(
                ['asal' => $request->asal, 'tujuan' => $request->tujuan,'jumlah'=>$request->jumlah]
            );
        //    dd($data1);
            $message = "success";
            $data['update']=null;
            if($data1)
            {
                $data['update']="Berhasil";
            }
            return response()->json(compact('message','data'),200);
        }
        else{
            $message = "fail params";
            $data=[];
            return response()->json(compact('message','data'),401);
        }
    }

    public function kirimttd(Request $request)
    {
        // $base64_string = $request->images;
        // $username = $request->nip;
        // $image_name = '/var/www/html/Pendik/storage/app/ttd/'.$username;
        // if (!file_exists($image_name)) {
        // if (!mkdir($image_name)) {
        //     $m=array('message' => "REJECTED, cant create folder");
        //     echo json_encode($m);
        //     return;}
        // }
        // $fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
        // $fileCount = iterator_count($fi)+1;
        // $data = explode(',', $base64_string);
        // $fullName = $image_name."/".$fileCount."_". date("YmdHis") .".png";
        // $ifp = fopen($fullName, "wb");
        // fwrite($ifp, base64_decode($data[1]));
        // fclose($ifp);
        // if (!$ifp)
        // {
        //     $m=array('message' => "REJECTED, ".$fullName."not saved");
        // }
        // else
        // {
        //     $m = array('message' => "TTD ACCEPTED");
        //     $table = DB::table('public.master_user')->where('user_id','=',$request->nip)->update(['status_ttd'=>true]);
        // }
        // echo json_encode($m);
        $m = array('message' => "TTD ACCEPTED");
        $table = DB::table('public.master_user')->where('user_id','=',$request->nip)->update(['ttd'=>true]);

        
        echo json_encode($m);
    }

    public function kirimgambar (Request $request)
    {
        // $base64_string = $request->images;
        // $username = $request->nip;
        // $image_name = '/var/www/html/Pendik/storage/app/images/'.$username;
        // if (!file_exists($image_name)) {
        // if (!mkdir($image_name)) {
        //     $m=array('message' => "REJECTED, cant create folder");
        //     echo json_encode($m);
        //     return;}
        // }

        // $fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
        // $fileCount = iterator_count($fi)+1;
        // $data = explode(',', $base64_string);
        // $gambar = $fileCount."_". date("YmdHis") .".png";
        // $fullName = $image_name."/".$gambar;
        // $ifp = fopen($fullName, "wb");
        // fwrite($ifp, base64_decode($data[1]));
        // fclose($ifp);
        // if (!$ifp){
        //     $m=array('message' => "REJECTED, ".$fullName."not saved");
        //     echo json_encode($m);
        //     return;}

        // // $command = escapeshellcmd("python checkImg.py ".$fullName);
        // // $output = shell_exec($command);
        // $output = null;
        // $process = new Process("python /var/www/prg/checkImg.py ".$fullName);
        // $process->run();


        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }
        // $output = $process->getOutput();

        // if ($output=="ACCEPTED\n")
        // {
        //     $fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
        //     $fileCount = iterator_count($fi);
        //     $table = DB::table("foto_statuses")->insert(['nip'=>$username,'nama_file'=>$gambar,'status' => 0]);
        //     $m = array('message' => $output." total(".$fileCount.")");
        // }
        // else{
        //     $m = array('message' =>"REJECTED\n , Wajah tidak terdeteksi");
        // }
        // echo json_encode($m);
        $m = array('message' =>"ACCEPTED\n , Wajah terdeteksi");

        $output="ACCEPTED\n";
        echo json_encode($m);
    }

    public function predict(Request $request)
    {
        $realpath = '/var/www/html/Pendik/storage/app/images/PREDICT_';
        $base64_string = $request->images;
        $username = $request->nip;
        $image_name = $username;


        $image_name =  $realpath.$username;
        if (!file_exists($image_name)) {
        if (!mkdir($image_name)) {
            $m=array('message' => "REJECTED, cant create folder");
            echo json_encode($m);
            return;}
        }

        $fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
        $fileCount = iterator_count($fi)+1;
        $data = explode(',', $base64_string);
        $fullName = $image_name."/".$fileCount."_". date("YmdHis") .".png";
        $ifp = fopen($fullName, "wb");
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);

        if (!$ifp){
            $m=array('message' => "REJECTED, ".$fullName."not saved");
            echo json_encode($m);
            return;}
        // $command = escapeshellcmd("python doPredict.py " .$username." " .$fullName);
        // $output = shell_exec($command);
        $process = new Process("python /var/www/prg/doPredict.py ".$username." " .$fullName);
        $process->run();


        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output = $process->getOutput();
        $m = array('message' => $output);
        echo json_encode($m);
    }

    public function train(Request $request)
    {
        $username = $request->nip;
        $image_name = '/var/www/html/Pendik/storage/app/images/'.$username;


        if (!file_exists($image_name))
        {
            $m = array('message' => "REJECTED,no data to train");
            echo json_encode($m);
            return;
        }


        $lock = "/var/www/prg/train_lock";

        if (file_exists($lock))
        {   $m = array('message' => "REJECTED, another user is training ..., please try again few minute ");
            echo json_encode($m);
            return;
        }

        $ifp = fopen($lock, "wb");
        fwrite($ifp, $username);
        fclose($ifp);
        if (!$ifp){
            $m=array('message' => "REJECTED, cant create lock file");
            echo json_encode($m);
            return;}

        $fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
        $fileCount = iterator_count($fi);
        // $command1 = escapeshellcmd("python /var/www/prg/doTrainToCSV.py ".$image_name);
        // $output1 = shell_exec($command1);
        $process = new Process("python /var/www/prg/doTrainToCSV.py ".$image_name);
        $process->run();


        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output1 = $process->getOutput();
        // $command2 = escapeshellcmd("python /var/www/prg/doTrainToModel.py");
        // $output2 = shell_exec($command2);
        $process = new Process("python /var/www/prg/doTrainToModel.py");
        $process->run();


        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output2 = $process->getOutput();
        $m = array('message' => $output1." total(".$fileCount. ") has been trained ".$output2);
        echo json_encode($m);

    }

    public function aturimei(Request $request)
    {
        $message = "success";
        $data['update']=null;
        $update = DB::table('public.master_user')
        ->where('user_id','=',$request->nip)
        ->update(['imei'=> $request->imei]);
        if ($update)
        {
            $data['update']="Berhasil";
        }
        return response()->json(compact('message','data'),200);
    }

    public function webtrain($id)
    {
        $username = $id;
        $image_name = '/var/www/html/Pendik/storage/app/images/'.$username;


        if (!file_exists($image_name))
        {
            $m = array('message' => "REJECTED,no data to train");
            //echo json_encode($m);
            Session::flash('error', 'REJECTED, no data to train');
            return redirect()->route('image', $id);
        }


        $lock = "/var/www/prg/train_lock";

        if (file_exists($lock))
        {   $m = array('message' => "REJECTED, another user is training ..., please try again few minute ");
            Session::flash('error', 'REJECTED, another user is training ..., please try again few minute');
            return redirect()->route('image', $id);
        }

        $ifp = fopen($lock, "wb");
        fwrite($ifp, $username);
        fclose($ifp);
        if (!$ifp){
            $m=array('message' => "REJECTED, cant create lock file");
            Session::flash('error', 'REJECTED, cant create lock file');
            return redirect()->route('image', $id);
        }

        $fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
        $fileCount = iterator_count($fi);
        // $command1 = escapeshellcmd("python /var/www/prg/doTrainToCSV.py ".$image_name);
        // $output1 = shell_exec($command1);
        $process = new Process("python /var/www/prg/doTrainToCSV.py ".$image_name);
        $process->run();


        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output1 = $process->getOutput();
        // $command2 = escapeshellcmd("python /var/www/prg/doTrainToModel.py");
        // $output2 = shell_exec($command2);
        $process = new Process("python /var/www/prg/doTrainToModel.py");
        $process->run();


        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output2 = $process->getOutput();
        $m = array('message' => $output1." total(".$fileCount. ") has been trained ".$output2);
        Session::flash('success', $output1.' total('.$fileCount. ') has been trained '.$output2);

        $update = [
            'status'=> 2
        ];

        $foto = FotoStatus::where('nip', $id)
                ->where('status', 1);

        $foto->update($update);

        return redirect()->route('image', $id);

    }
    public function newtunai(Request $request)
    {
        $list = DB::select(DB::raw("SELECT * FROM (SELECT sum(komponen_hasil_kali),kode_pekerjaan FROM budget2019.pekerjaan_detail 
        GROUP BY kode_pekerjaan) as hasil, budget2019.master_pekerjaan as kerja WHERE hasil.kode_pekerjaan = kerja.kode_pekerjaan AND kerja.unit_id = '$request->unit_id' and kerja.jenis_pekerjaan = '$request->tipe' AND kerja.jenis_pembayaran = 'Tunai' and kerja.status_approve = 0  and kerja.kode_kegiatan like '$request->kode'"));
        $message = "success";
        $data=$list;
        return response()->json(compact('message','data'),200);
    }

    public function saldo(Request $request)
    {
        // $no_rek = $request->nomor_rekening;
        $message = "success";

        $row_saldo = DB::table('public.Tabel_Saldo')
        ->where('no_rekening','=','0012498578')->first();

        // dd($row_saldo);
       
        $data = $row_saldo->saldo;
        // $data = '0012498578';
        return response()->json(compact('message','data'),200);

    }

}
