<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Support\Facades\Auth;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $mataKuliahs = MataKuliah::withTrashed()
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.kurikulum.index', compact('mataKuliahs', 'session_user'));
    }

    public function tambahMataKuliah(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'sks' => 'required',
            'semester' => 'required',
            'kelompok'  => 'required',
        ]);

        MataKuliah::create($request->all());

        return redirect('/admin/kurikulum')->with('status', 'Data MataKuliah Berhasil Ditambah!');
    }

    public function updateMataKuliah(Request $request, MataKuliah $mataKuliah)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required',
            'sks' => 'required',
            'semester' => 'required',
            'kelompok'  => 'required',
        ]);

        MataKuliah::where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'kode' => $request->kode,
                'sks' => $request->sks,
                'semester' => $request->semester,
                'kelompok' => $request->kelompok,
            ]);

        return redirect('/admin/kurikulum')->with('status', 'Data Mata Kuliah Berhasil Diubah!');
    }

    public function deleteMataKuliah(MataKuliah $mataKuliah)
    {
        MataKuliah::destroy($mataKuliah->id);

        return redirect('/admin/kurikulum')->with('status', 'Data Mata Kuliah Berhasil Dihapus!');
    }

    public function restoreMataKuliah($id)
    {
        MataKuliah::withTrashed()->where('id', $id)->restore();

        return redirect('/admin/kurikulum')->with('status', 'Data Mata Kuliah Berhasil Dikembalikan!');
    }

    public function deletePermanenMataKuliah(Request $request, $id)
    {
        MataKuliah::withTrashed()->where('id', $id)->forceDelete();

        return redirect()->route('kurikulum.index')->with('status', 'Data Mata Kuliah Terhapus Permanen');
    }

    public function menuKurikulum()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();

        $mataKuliahs = MataKuliah::withTrashed()
            ->orderBy('semester', 'asc')
            ->get();

        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();
        
        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.kurikulum.index',  compact('himpunanMahasiswaHeaders', 'kontak', 'mataKuliahs', 'informasiTerbarus', 'aplikasiIntegrasis', 'profilSingkat', 'laboratoriumHeaders'));
    }
}
