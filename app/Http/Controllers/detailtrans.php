<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\detailModel;
use App\JenismobilModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class detailtrans extends Controller
{
    public function store(Request $req){
        if (Auth::user()->level=='petugas') {
            $validator=Validator::make($req->all(),[
                'id_transaksi' => 'required',
                'id_jenis_mobil' => 'required',
                'qty' => 'required',
              ]);
              if($validator->fails()){
                return Response()->json($validator->errors());
              }
              $harga = JenismobilModel::where('id_jenis_mobil',$req->id_jenis_mobil)->first();
              $subtotal = $harga->harga_perhari * $req->qty;

              $simpan=detailModel::create([
                  'id_transaksi' => $req->id_transaksi,
                  'id_jenis_mobil' => $req->id_jenis_mobil,
                  'qty' => $req->qty,
                  'subtotal' => $subtotal,
              ]);
              if($simpan){
                  $data['status']="Berhasil";
                  $data['message']="Data berhasil disimpan!";
                  return Response()->json($data);
              }else{
                  $data['status']="Gagal";
                  $data['message']="Data gagal disimpan!";
                  return Response()->json($data);
              }
        } else {
            $data['status']="Gagal";
            $data['Message']="Anda bukan Petugas!";
            return Response()->json($data);
        }
    }
    public function destroy($id){
        if(Auth::user()->level=="petugas"){
        $hapus=detailModel::where('id',$id)->delete();
        $status=1;
        $message="Detail Transaksi Berhasil Dihapus";
        if($hapus){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan petugas']);
        }
    }
    public function tampil(){
        if(Auth::user()->level=="petugas"){
            $datas = detailModel::get();
            $count = $datas->count();
            $detail = array();
            $status = 1;
            foreach ($datas as $dt_pl){
                $detail[] = array(
                    'id_transaksi' => $dt_pl->id_transaksi,
                    'id_jenismobil' => $dt_pl->id_jenis_mobil,
                    'qty' => $dt_pl->qty,
                    'subtotal' => $dt_pl->subtotal
                );
            }
            return Response()->json(compact('count','detail'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan petugas']);
        }
    }
    public function update($id,Request $request){
        if(Auth::user()->level=="petugas"){
        $validator=Validator::make($request->all(),
            [
                    'id_transaksi' => 'required',
                    'id_jenis_mobil' => 'required',
                    'qty' => 'required',
                  
            ]
        );
    
        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $harga = JenismobilModel::where('id_jenis_mobil',$request->id_jenis_mobil)->first();
        $subtotal = $harga->harga_perhari * $request->qty;

        $ubah=detailModel::where('id',$id)->update([
                      'id_transaksi' => $request->id_transaksi,
                      'id_jenis_mobil' => $request->id_jenis_mobil,
                      'qty' => $request->qty,
                      'subtotal' => $subtotal
        ]);
        $status=1;
        $message="Detail Berhasil Diubah";
        if($ubah){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
        }
    else {
    return response()->json(['status'=>'anda bukan petugas']);
    }
    }
}
