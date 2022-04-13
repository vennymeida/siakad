@extends('mahasiswa.layout')

@section('content')
 <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
        <div class="float-right my-2">
        <!-- <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a> -->
        </div>
        <div class="float-left my-3">
                <form action="{{ route('mahasiswa.index') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="" name="search" value="{{ request('search')}}" style="width: 1000px">
                        <button class="btn btn-primary" type="submit">Search</button>&emsp;
                        <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
                    </div>
            </div>
        </div>
 
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-error">
        <p>{{ $message }}</p>
    </div>
@endif
 
 <table class="table table-bordered">
 <tr>
        <th>Nim</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th width="280px">Action</th>
 </tr>
 @foreach ($paginate as $mhs)
 <tr>
        <td>{{ $mhs ->nim }}</td>
        <td>{{ $mhs ->nama }}</td>
        <td>{{ $mhs ->email }}</td>
        <td>{{ $mhs ->jeniskelamin }}</td>
        <td>{{ $mhs ->tanggallahir }}</td>
        <td>{{ $mhs ->alamat }}</td>
        <td>{{ $mhs ->kelas->nama_kelas }}</td>
        <td>{{ $mhs ->jurusan }}</td>
        <td>
    <form action="{{ route('mahasiswa.destroy',['mahasiswa'=>$mhs->nim]) }}" method="POST">
 
        <a class="btn btn-info" href="{{ route('mahasiswa.show',$mhs->nim) }}">Show</a>
        <a class="btn btn-primary" href="{{ route('mahasiswa.edit',$mhs->nim) }}">Edit</a>
        @csrf
        @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
    <a class="btn btn-warning" href="{{ route('mahasiswa.nilai',$mhs->id_mahasiswa) }}">Nilai</a>
    </form>
    </td>
 </tr>
 @endforeach
 </table>
 {{ $paginate->links()}}
@endsection