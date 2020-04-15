<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenismobilModel;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class Jenismobil extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $jeniscuci=DB::table('jenis_cuci')
            ->where('jenis_mobil.id',$id)
            ->get();
            return response()->json($jeniscuci);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'jenis_mobil'=>'required',
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=JenismobilModel::create([
            'jenis_mobil'=>$req->jenis_mobil
        ]);
        $status=1;
        $message="Jenis Mobil Berhasil Ditambahkan";
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
                'jenis_mobil'=>'required',
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=JenismobilModel::where('id',$id)->update([
            'jenis_mobil'=>$request->jenis_mobil,
        ]);
        $status=1;
        $message="Jenis Mobil Berhasil Diubah";
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
        $hapus=JenismobilModel::where('id',$id)->delete();
        $status=1;
        $message="Jenis Mobil Berhasil Dihapus";
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
            $datas = JenismobilModel::get();
            $count = $datas->count();
            $jenismobil = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $jenismobil[] = array(
                    'id' => $dt_jc->id,
                    'jenis_mobil' => $dt_jc->jenis_mobil,
                );
            }
            return Response()->json(compact('count','jenismobil'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
