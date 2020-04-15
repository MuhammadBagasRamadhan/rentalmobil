<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaksiModel;
use App\PenyewaModel;
use App\JenismobilModel;
use App\detailModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use DB;
use Tymon\JWTAuth\Exceptions\JWTException;

class Transaksi extends Controller
{
    public function store(Request $req){
        if (Auth::user()->level=='petugas') {
            $validator=Validator::make($req->all(),[
                'id_mobil' => 'required',
                'id_petugas' => 'required',
                'id_penyewa' => 'required',
                'tgl_transaksi' => 'required',
                'tgl_selesai' => 'required',
              ]);
              if($validator->fails()){
                return Response()->json($validator->errors());
              }
        
              $simpan=transaksiModel::create([
                  'id_mobil' => $req->id_mobil,
                  'id_petugas' => $req->id_petugas,
                  'id_penyewa' => $req->id_penyewa,
                  'tgl_transaksi' => $req->tgl_transaksi,
                  'tgl_selesai' => $req->tgl_selesai
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
        $hapus=transaksiModel::where('id',$id)->delete();
        $status=1;
        $message="Transaksi Berhasil Dihapus";
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

    public function show(Request $req){
        if(Auth::user()->level == "petugas"){
            $transaksi = DB::table('transaksi')->join('penyewa','penyewa.id','=','transaksi.id_penyewa')
            ->where('transaksi.tgl_transaksi','>=',$req->tgl_transaksi)
            ->where('transaksi.tgl_transaksi','<=',$req->tgl_selesai)
            ->select('nama_penyewa','telp','alamat','no_ktp','transaksi.id','tgl_transaksi','tgl_selesai')
            ->get();
            
            if($transaksi->count() > 0){

            $data_transaksi = array();
            foreach ($transaksi as $t){
                
                $grand = DB::table('detail_transaksi')->where('id','=',$t->id)
                ->groupBy('id')
                ->select(DB::raw('sum(subtotal) as grandtotal'))
                ->first();
                
                $detail = DB::table('detail_transaksi')->join('jenis_mobil','detail_transaksi.id_jenis_mobil','=','jenis_mobil.id_jenis_mobil')
                ->where('id','=',$t->id)
                ->get();
                

                $data_transaksi[] = array(
                    'Tanggal Ambil' => $t->tgl_transaksi,
                    'nama pelanggan' => $t->nama_penyewa,
                    'alamat' => $t->alamat,
                    'telp' => $t->telp,
                    'no_ktp' => $t->no_ktp,
                    'Tanggal Kembali' => $t->tgl_selesai,
                    'Grand Total' => $grand, 
                    'Detail' => $detail,
                );
                
            }
            return response()->json(compact('data_transaksi'));
        
    }else{
            $status = 'tidak ada transaksi antara tanggal '.$req->tgl_transaksi.' sampai dengan tanggal '.$req->tgl_selesai;
            return response()->json(compact('status'));
    }
        }else{
            return Response()->json('Anda Bukan Petugas');
        }
}
public function update($id,Request $request){
    if(Auth::user()->level=="petugas"){
    $validator=Validator::make($request->all(),
        [
                'id_mobil' => 'required',
                'id_petugas' => 'required',
                'id_penyewa' => 'required',
                'tgl_transaksi' => 'required',
                'tgl_selesai' => 'required',
        ]
    );

    if($validator->fails()){
    return Response()->json($validator->errors());
    }

    $ubah=transaksiModel::where('id',$id)->update([
        'id_mobil' => $request->id_mobil,
        'id_petugas' => $request->id_petugas,
        'id_penyewa' => $request->id_penyewa,
        'tgl_transaksi' => $request->tgl_transaksi,
        'tgl_selesai' => $request->tgl_selesai
    ]);
    $status=1;
    $message="Transaksi Berhasil Diubah";
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
