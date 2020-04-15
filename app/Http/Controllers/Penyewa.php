<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PenyewaModel;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class Penyewa extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $penyewa=DB::table('penyewa')
            ->where('penyewa.id',$id)
            ->get();
            return response()->json($penyewa);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_penyewa'=>'required',
            'telp'=>'required',
            'no_ktp'=>'required',
            'alamat'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=PenyewaModel::create([
            'nama_penyewa'=>$req->nama_penyewa,
            'telp'=>$req->telp,
            'no_ktp'=>$req->no_ktp,
            'alamat'=>$req->alamat
        ]);
        $status=1;
        $message="Penyewa Berhasil Ditambahkan";
        if($simpan){
          return Response()->json(compact('status','message'));
        }else {
          return Response()->json(['status'=>0]);
        }
      }
      else {
          return response()->json(['status'=>'anda bukan admin']);
      }
  }
    public function update($id,Request $request){
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($request->all(),
            [
                'nama_penyewa'=>'required',
                'telp'=>'required',
                'no_ktp'=>'required',
                'alamat'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=PenyewaModel::where('id',$id)->update([
            'nama_penyewa'=>$request->nama_penyewa,
            'telp'=>$request->telp,
            'no_ktp'=>$request->no_ktp,
            'alamat'=>$request->alamat
        ]);
        $status=1;
        $message="Penyewa Berhasil Diubah";
        if($ubah){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
        }
    else {
    return response()->json(['status'=>'anda bukan admin']);
    }
}
    public function destroy($id){
        if(Auth::user()->level=="admin"){
        $hapus=PenyewaModel::where('id',$id)->delete();
        $status=1;
        $message="Penyewa Berhasil Dihapus";
        if($hapus){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan admin']);
        }
    }
  
    public function tampil(){
        if(Auth::user()->level=="admin"){
            $datas = PenyewaModel::get();
            $count = $datas->count();
            $penyewa = array();
            $status = 1;
            foreach ($datas as $dt_pl){
                $penyewa[] = array(
                    'id' => $dt_pl->id,
                    'nama_penyewa' => $dt_pl->nama_penyewa,
                    'alamat' => $dt_pl->alamat,
                    'telp' => $dt_pl->telp,
                    'no_ktp' => $dt_pl->no_ktp
                );
            }
            return Response()->json(compact('count','penyewa'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
