<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Intervention\Image\Facades\Image as Image;
use App\FotoStatus;
use DB;
use Session;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($path_file='')
    {
        $nips = DB::select('select distinct m.nip, (select count(s.id) as jumlah0 
            from foto_statuses s 
            where s.status = 0
            and s.nip = m.nip) 
            ,(select count(s.id) as jumlah1 
            from foto_statuses s 
            where s.status = 1
            and s.nip = m.nip)
            ,(select count(s.id) as jumlah2
            from foto_statuses s 
            where s.status = 2
            and s.nip = m.nip)
            from foto_statuses m');

        return view('directory.home',compact("nips"));

        //dd($nips);

        // $temp_path = storage_path().'/app/images/';

        // if(empty($path_file)||$path_file==""){
        //     $path=$temp_path;
        // }
        // else{
        //     $path = $temp_path.$path_file."/";
        // }
        // if(!is_dir($path)){
        //     $path=$temp_path;
        // }
        // $porto=opendir($path);
        // $dbporto=readdir($porto);
        // $array_file = array();
        // $i = $jmlGambar = $jmlFolder=$jmlLain=0;
        // while($dbporto=readdir($porto))
        // {
        //     $info = pathinfo($path.$dbporto);
        //     if($info['filename']!='.'&&$info['filename']!='..')
        //     {
        //         if(!empty($info['extension'])){
        //             if(($info['extension']=='jpeg'||$info['extension']=='jpg'||$info['extension']=='png')){
        //             $jmlGambar++;
        //             }
        //         }else{
        //             $jmlFolder++;
        //         }
        //         $array_file[$i] = $info;
        //         $i++;
        //     }
        // }

        // $jmlLain = count($array_file)-$jmlFolder-$jmlGambar;

        // if (!empty($path_file)){
        //     $image_path = "app/images/".$path_file."/";
        // }else{
        //     $image_path = "app/images/";
        // }

        // return view('directory.home',compact("array_file","jmlGambar","jmlFolder","jmlLain","path","image_path","path_file"));
    }

    public function foto($path_file='')
    {
        //print_r($path_file);
        $s0 = $s1 = $s2 = 0;
        $file_foto = DB::table('foto_statuses')->where('nip', $path_file)->distinct()->orderBy('status', 'asc')->get();
        foreach ($file_foto as $f) {
            if ($f->status == 0) {
                $s0++;
            }
            else if($f->status == 1){
                $s1++;
            }
            else{
                $s2++;
            }
        }

        $jmlGambar = $s0+$s1+$s2;
         //dd($cekVerif);
        //dd('s0='.$s0.' s1='.$s1.' s2='.$s2);

        $image_path = '/app/images/'.$path_file;

        return view('directory.foto',compact("file_foto","jmlGambar","image_path","path_file","s0","s1","s2"));
    }

    public function foto_trained($path_file='')
    {
        $nips = DB::select('select distinct m.nip, (select count(s.id) as jumlah0 
            from foto_statuses s 
            where s.status = 0
            and s.nip = m.nip) 
            ,(select count(s.id) as jumlah1 
            from foto_statuses s 
            where s.status = 1
            and s.nip = m.nip)
            ,(select count(s.id) as jumlah2
            from foto_statuses s 
            where s.status = 2
            and s.nip = m.nip)
            from foto_statuses m
            where m.status = '.$path_file);

        return view('directory.home',compact("nips"));


        // print_r($path_file);


        // if(empty($file_foto)){

        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nip = explode("/", $request->nip);
        $nip = end($nip);
        // dd($request->nama_file);
        if (empty($request->nama_file)) {
            Session::flash('error', 'Checkbox Harus Diisi');
            return redirect()->route('image', $nip);
        }
        // print_r($request->nama_file);
        $filesname = [];
        $filesname = explode(",", $request->nama_file);
        $count = count($filesname)-1;
        //dd($filesname);
        $update = [
            'status'=> 1
        ];

        for($i=0;$i<$count+1;$i++){
            $foto = FotoStatus::where('nip', $nip)
                    ->where('nama_file', $filesname[$i]);
            $foto->update($update);
        }
        Session::flash('success', 'Verivikasi Berhasil Dilakukan');
        return redirect()->route('image', $nip);      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($user_id, $slug)
    {
        $storagePath = storage_path('/app/images/' . $user_id . '/' . $slug);
        return Image::make($storagePath)->response();
    }

    public function show2($slug)
    {
        $storagePath = storage_path('/app/images/'. $slug);
        return Image::make($storagePath)->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $nama_file = $request->nama_file;
        $nip = $request->nip;
        $hh = DB::table('foto_statuses')->where([
                ['nip', '=', $nip],
                ['nama_file', '=', $nama_file],
            ])->delete();

        Session::flash('error', 'File '.$nama_file.' Telah dihapus');

        $arr = [];
        $arr = explode("/", $request->dir_gambar);
        print_r($arr);
        $string_path = "";
        for ($i=1; $i < count($arr) ; $i++) { 
            $string_path = $string_path.'/'.$arr[$i];
        }
        $filename = storage_path().$string_path.'/'.$request->nama_gambar;
        //$filename = storage_path().'/app/images/'.$arr[$count].'/'.$request->nama_gambar;
        // print_r($filename);
        // dd($string_path);
        File::delete($filename);
        return redirect()->route('image', $nip);
    }

    public function training(Request $request)
    {

    }
}
