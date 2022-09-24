<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Mahasiswa; 

class CrudTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_open_page_mahasiswa()
    {
        $response = $this->get('/mahasiswa');

        $response->assertStatus(200);
        $response->assertSee('Nama');
    }
    public function test_create_mahasiswa_test()
    {
        //buka halaman /price/create
        $response = $this->get('/mahasiswa/create');
        //pastikan halamannya bisa dibuka
        $response->assertStatus(200);
        $response->assertSeeText("Nim");
        $response->assertSeeText("Nama");
        //ada input email
        $response->assertSeeText("Email");
        //ada input jenis kelamin
        $response->assertSeeText("Jenis Kelamin");
        //ada tombol tanggal lahir
        $response->assertSeeText("Tanggal Lahir");
        $response->assertSeeText("Alamat");
        $response->assertSeeText("Kelas");
        $response->assertSeeText("Jurusan");
        $response->assertSeeText("Foto");
    }

    public function test_pagination()
    {
        //setup
        $this->seed();

        //action
        $response = $this->get('/mahasiswa');

        //assert
        $response->assertStatus(200);

        $response = $this->get('mahasiswa?page=2');
        $response->assertStatus(200);

        $response = $this->get('mahasiswa?page=3');
        $response->assertStatus(200);
    }

    public function test_user_can_create_a_mahasiswa()
    {
        $this->assertTrue(true);
        //tambahkan post ke /create
        Mahasiswa::create([
                    'nim' => 2041728,
                    'nama' => 'Venny Meida',
                    'email' => 'venny@gmail.com',
                    'jeniskelamin' => 'perempuan',
                    'tanggallahir' => date('Y-m-d'),
                    'alamat' => 'Kabupaten Kediri',
                    'kelas_id' => 4 ,
                    'jurusan' => 'Teknologi Informasi',
                    'featured_image' => 'images/wdfEg46p4QE9NuWDY3E0EHHbMC83CraYGGwHNgAL.png',
        ]);
        $response = $this->get('/mahasiswa/create');
        $response->assertStatus(200);
    }
    public function test_all_input_is_required()
    {
        //buka halaman /mahasiswa/create
        $response = $this->post('/mahasiswa', [
            'nim' => '',
            'nama' => '',
            'email' => '',
            'jeniskelamin' => '',
            'tanggallahir' => '',
            'alamat' => '',
            'jurusan' => '',
            'kelas_id' => '',
            'featured_image' => '',
        ]);
        //pastikan halamannya bisa dibuka
        $response->assertStatus(302);
        $response->assertInvalid([
            'Nim' => 'The nim field is required.',
            'Nama' => 'The nama field is required.',
            'Email' => 'The email field is required.',
            'JenisKelamin' => 'The jenis kelamin field is required.',
            'TanggalLahir' => 'The tanggal lahir field is required.',
            'Alamat' => 'The alamat field is required.',
            'Jurusan' => 'The jurusan field is required.',
            'Kelas' => 'The kelas field is required.',
            'featured_image' => 'The featured image field is required.',
        ]);
    }
    /** @test */
    public function test_user_can_edit_existing_Mahasiswa()
    {
        $this->assertTrue(true);
        // generate 1 data post
        $Mahasiswa = Mahasiswa::create([
            'nim' => 2041728,
            'nama' => 'Venny Meida',
            'email' => 'venny@gmail.com',
            'jeniskelamin' => 'perempuan',
            'tanggallahir' => date('Y-m-d'),
            'alamat' => 'Kabupaten Kediri',
            'kelas_id' => 4 ,
            'jurusan' => 'Teknologi Informasi',
            'featured_image' => 'images/wdfEg46p4QE9NuWDY3E0EHHbMC83CraYGGwHNgAL.png',
        ]);

        $response = $this->get('/mahasiswa/2041728/edit');
        $response->assertStatus(200);
        Mahasiswa::where('nama', 'Venny Meida')->update(['nama' => 'vennol']);

        $response = $this->get('/mahasiswa');

        $response->assertSeeText('vennol');
    }

    /** @test */
    public function test_user_can_delete_existing_Mahasiswa()
    {
        $this->assertTrue(true);
        $response = $this->get('/mahasiswa');
        $response->assertStatus(200);
        Mahasiswa::where('nama', 'vennol')->delete();

        $response = $this->get('/mahasiswa');

        $response->assertDontSee('vennol');
    }
}
