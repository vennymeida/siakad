<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('search')) {
            $paginate = Mahasiswa::where('nama', 'like', '%' . request('search') . '%')
                                    ->orwhere('nim', 'like', '%' . request('search') . '%')
                                    ->orwhere('email', 'like', '%' . request('search') . '%')
                                    ->orwhere('jeniskelamin', 'like', '%' . request('search') . '%')
                                    ->orwhere('tanggallahir', 'like', '%' . request('search') . '%')
                                    ->orwhere('alamat', 'like', '%' . request('search') . '%')
                                    ->orwhere('kelas', 'like', '%' . request('search') . '%')
                                    ->orwhere('jurusan', 'like', '%' . request('search') . '%')->paginate(5); // Mengambil semua isi tabel
            return view('mahasiswa.index', ['paginate'=>$paginate]);
        }else{
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswa = Mahasiswa::all();//mengambil semua isi tabel
        $paginate = Mahasiswa::orderBy('id_mahasiswa','asc')->paginate(5);
        return view('mahasiswa.index', ['mahasiswa'=>$mahasiswa,'paginate'=>$paginate]);
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim'=>'required',
            'Nama'=>'required',
            'Email'=>'required',
            'JenisKelamin'=>'required',
            'TanggalLahir'=>'required',
            'Alamat'=>'required',
            'Kelas'=>'required',
            'Jurusan'=>'required',
        ]);

        //fungsi eloquent untuk menambahkan data
        Mahasiswa::create($request->all());
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success','Mahasiswa Berhasil Ditambahakan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::where('nim', $nim)->first();
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
        return view('mahasiswa.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim'=>'required',
            'Nama'=>'required',
            'Email'=>'required',
            'JenisKelamin'=>'required',
            'TanggalLahir'=>'required',
            'Alamat'=>'required',
            'Kelas'=>'required',
            'Jurusan'=>'required',
        ]);

        //fungsi eloquent untuk mengupdate data inputan kita
        Mahasiswa::where('nim', $nim)
        ->update([
            'nim'=>$request->Nim,
            'nama'=>$request->Nama,
            'email'=>$request->Email,
            'jeniskelamin'=>$request->JenisKelamin,
            'tanggallahir'=>$request->TanggalLahir,
            'alamat'=>$request->Alamat,
            'kelas'=>$request->Kelas,
            'jurusan'=>$request->Jurusan,
        ]);

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success','Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::where('nim',$nim)->delete();
        return redirect()->route('mahasiswa.index')
        ->with('success','Mahasiswa Berhasil Dihapus');
    }
};