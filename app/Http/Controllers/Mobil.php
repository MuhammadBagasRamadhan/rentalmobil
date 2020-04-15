<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MobilModel;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class Mobil extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $mobil=DB::table('mobil')
            ->where('mobil.id',$id)
            ->get();
            return response()->json($mobil);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_mobil'=>'required',
            'id_jenis_mobil'=>'required',
            'plat_nomer'=>'required',
            'kondisi'=>'required',
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=MobilModel::create([
            'nama_mobil'=>$req->nama_mobil,
            'id_jenis_mobil'=>$req->id_jenis_mobil,
            'plat_nomer'=>$req->plat_nomer,
            'kondisi'=>$req->kondisi
        ]);
        $status=1;
        $message="Mobil Berhasil Ditambahkan";
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
                'nama_mobil'=>'required',
                'id_jenis_mobil'=>'required',
                'plat_nomer'=>'required',
                'kondisi'=>'required',
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=MobilModel::where('id',$id)->update([
            'nama_mobil'=>$request->nama_mobil,
            'id_jenis_mobil'=>$request->id_jenis_mobil,
            'plat_nomer'=>$request->plat_nomer,
            'kondisi'=>$request->kondisi
        ]);
        $status=1;
        $message="Mobil Berhasil Diubah";
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
        $hapus=MobilModel::where('id',$id)->delete();
        $status=1;
        $message="Mobil Berhasil Dihapus";
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
            $datas = MobilModel::get();
            $count = $datas->count();
            $mobil = array();
            $status = 1;
            foreach ($datas as $dt_pl){
                $mobil[] = array(
                    'id' => $dt_pl->id,
                    'nama_mobil' => $dt_pl->nama_mobil,
                    'id_jenis_mobil' => $dt_pl->id_jenis_mobil,
                    'plat_nomer' => $dt_pl->plat_nomer,
                    'kondisi' => $dt_pl->kondisi
                );
            }
            return Response()->json(compact('count','mobil'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
