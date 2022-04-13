<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

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
        $Mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa','asc')->paginate(5);
        return view('mahasiswa.index', ['mahasiswa'=>$Mahasiswa,'paginate'=>$paginate]);
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); //Mendapatkan data dari tabel kelas
        return view('mahasiswa.create',['kelas' => $kelas]);
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

        $Mahasiswa = new Mahasiswa;
        $Mahasiswa->nim = $request->get('Nim');
        $Mahasiswa->nama = $request->get('Nama');
        $Mahasiswa->email = $request->get('Email');
        $Mahasiswa->jeniskelamin = $request->get('JenisKelamin');
        $Mahasiswa->tanggallahir = $request->get('TanggalLahir');
        $Mahasiswa->alamat = $request->get('Alamat');
        $Mahasiswa->jurusan = $request->get('Jurusan');
        // $Mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $Mahasiswa->kelas()->associate($kelas);
        $Mahasiswa->save();

        // //fungsi eloquent untuk menambahkan data
        // Mahasiswa::create($request->all());
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
        // $Mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        // return view('mahasiswa.detail', compact('Mahasiswa'));
        return view('mahasiswa.detail', ['Mahasiswa' => $Mahasiswa]);
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
        // $Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
        // return view('mahasiswa.edit', compact('Mahasiswa'));

        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.edit', compact('Mahasiswa','kelas'));
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

        // //fungsi eloquent untuk mengupdate data inputan kita
        // Mahasiswa::where('nim', $nim)
        // ->update([
        //     'nim'=>$request->Nim,
        //     'nama'=>$request->Nama,
        //     'email'=>$request->Email,
        //     'jeniskelamin'=>$request->JenisKelamin,
        //     'tanggallahir'=>$request->TanggalLahir,
        //     'alamat'=>$request->Alamat,
        //     'kelas'=>$request->Kelas,
        //     'jurusan'=>$request->Jurusan,
        // ]);

        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $Mahasiswa->nim = $request->get('Nim');
        $Mahasiswa->nama = $request->get('Nama');
        $Mahasiswa->jurusan = $request->get('Jurusan');
        $Mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        $Mahasiswa->kelas()->associate($kelas);
        $Mahasiswa->save();


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