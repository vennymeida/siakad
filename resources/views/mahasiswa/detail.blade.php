@extends('mahasiswa.layout')
 
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
            Detail Mahasiswa
            </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>Nim: </b>{{$Mahasiswa->nim}}</li>
            <li class="list-group-item"><b>Nama: </b>{{$Mahasiswa->nama}}</li>
            <li class="list-group-item"><b>Email: </b>{{$Mahasiswa->email}}</li>
            <li class="list-group-item"><b>Jenis Kelamin: </b>{{$Mahasiswa->jeniskelamin}}</li>
            <li class="list-group-item"><b>Tanggal Lahir: </b>{{$Mahasiswa->tanggallahir}}</li>
            <li class="list-group-item"><b>Alamat: </b>{{$Mahasiswa->alamat}}</li>
            <li class="list-group-item"><b>Kelas: </b>{{$Mahasiswa->kelas->nama_kelas}}</li>
            <li class="list-group-item"><b>Jurusan: </b>{{$Mahasiswa->jurusan}}</li>
            <li class="list-group-item"><b>Foto: </b><img style="width: 100%" src="{{ asset('./storage/'. $Mahasiswa->featured_image) }}" alt=""></li>
            </ul>
        </div>
            <a class="btn btn-success mt-3" href="{{ route('mahasiswa.index') }}">Kembali</a>
        </div>
    </div>
</div>
@endsection