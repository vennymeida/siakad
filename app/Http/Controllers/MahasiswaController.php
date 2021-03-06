<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Mahasiswa_MataKuliah;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use PDF;

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
        $paginate = Mahasiswa::orderBy('id_mahasiswa','asc')->paginate(3);
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
        // if ($request->file('image')){
        //     $image_name = $request->file('image')->store('images','public');
        // }
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
            'featured_image' => 'required',
        ]);

        $image_name = '';
        if ($request->file('featured_image')) {
            $image_name = $request->file('featured_image')->store('images', 'public');
        }

        $Mahasiswa = new Mahasiswa;
        $Mahasiswa->nim = $request->get('Nim');
        $Mahasiswa->nama = $request->get('Nama');
        $Mahasiswa->email = $request->get('Email');
        $Mahasiswa->jeniskelamin = $request->get('JenisKelamin');
        $Mahasiswa->tanggallahir = $request->get('TanggalLahir');
        $Mahasiswa->alamat = $request->get('Alamat');
        $Mahasiswa->jurusan = $request->get('Jurusan');
        $Mahasiswa->featured_image = $image_name;
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
            'featured_image' => 'required',
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
        $Mahasiswa->email = $request->get('Email');
        $Mahasiswa->jeniskelamin = $request->get('JenisKelamin');
        $Mahasiswa->tanggallahir = $request->get('TanggalLahir');
        $Mahasiswa->alamat = $request->get('Alamat');
        $Mahasiswa->jurusan = $request->get('Jurusan');
        
        if ($Mahasiswa->featured_image && file_exists(storage_path('app/public/'. $Mahasiswa->featured_image))) {
            Storage::delete('public/'. $Mahasiswa->featured_image);
        }

        $image_name = '';
        if ($request->file('featured_image')) {
        $image_name = $request->file('featured_image')->store('images', 'public');
        }

        $Mahasiswa->featured_image = $image_name;
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

    public function Mahasiswa_MataKuliah($Nim)
    {
        $mahasiswa = Mahasiswa_MataKuliah::with('matakuliah')->where('mahasiswa_id', $Nim)->get();
        $mahasiswa->mahasiswa = Mahasiswa::with('kelas')->where('id_mahasiswa', $Nim)->first();
        return view('mahasiswa.nilai', ['mahasiswa' => $mahasiswa]);
    }

    public function nilai_pdf($nim){
        // dd('tetsing');
        $Mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $nilai = Mahasiswa_MataKuliah::where('mahasiswa_id', $Mahasiswa->id_mahasiswa)
                                       ->with('matakuliah')
                                       ->with('mahasiswa')
                                       ->get();
        $nilai->mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $pdf = PDF::loadview('mahasiswa.nilai_pdf', compact('nilai'));
        return $pdf->stream();
    }
};