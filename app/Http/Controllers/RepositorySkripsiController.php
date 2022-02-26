<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\ProfilSingkat;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\RepositorySkripsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class RepositorySkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $repositorySkripsis = RepositorySkripsi::withTrashed()->get()
            ->sortDesc();
        return view('admin.repository_skripsi.index', compact('repositorySkripsis', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/repository_skripsi.create', compact('session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'teks' => 'required',
            'release_date' => 'required'
        ]);

        $slug = Str::slug($request->judul) . '_' . time();

        RepositorySkripsi::create([
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'slug' => $slug,
                'release_date' => $request->release_date,
            ]);

        return redirect('/admin/repository_skripsi')->with('status', 'Repository Skripsi Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RepositorySkripsi  $repositorySkripsis
     * @return \Illuminate\Http\Response
     */
    public function show(RepositorySkripsi $repositorySkripsis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RepositorySkripsi  $repositorySkripsis
     * @return \Illuminate\Http\Response
     */
    public function edit(RepositorySkripsi $repositorySkripsi)
    {
        $session_user = Auth::user();
        $repositorySkripsi = RepositorySkripsi::all()->firstWhere('slug', $repositorySkripsi->slug);

        return view('admin.repository_skripsi.edit', compact('repositorySkripsi', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RepositorySkripsi  $repositorySkripsi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RepositorySkripsi $repositorySkripsi)
    {
        $request->validate([
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'teks' => 'required',
            'release_date' => 'required'
        ]);

        RepositorySkripsi::where('id', $request->id)
            ->update([
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'release_date' => $request->release_date,
            ]);

        return redirect('/admin/repository_skripsi')->with('status', 'Repository Skripsi Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RepositorySkripsi  $repositorySkripsi
     * @return \Illuminate\Http\Response
     */
    public function destroy(RepositorySkripsi $repositorySkripsi)
    {
        RepositorySkripsi::destroy($repositorySkripsi->id);

        return redirect('/admin/repository_skripsi')->with('status', 'Repository Skripsi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $repositorySkripsi = RepositorySkripsi::withTrashed()
            ->where('id', $id)
            ->first();

        $repositorySkripsi->restore();
        return redirect('/admin/repository_skripsi')->with('status', 'Repository Skripsi Berhasil Direstore');
    }

    public function delete($id)
    {
        $repositorySkripsi = RepositorySkripsi::withTrashed()
            ->where('id', $id)
            ->first();

        $repositorySkripsi->forceDelete();
        return redirect('/admin/repository_skripsi')->with('status', 'Repository Skripsi Berhasil Dihapus Permanen');
    }

    public function menuRepositorySkripsi()
    {
        $repositorySkripsis = RepositorySkripsi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('tahun', 'DESC')
            ->get();

        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();
        $profilSingkat = ProfilSingkat::all()
            ->first();
        $kontak = Kontak::all()
            ->first();

        return view('portal.repository_skripsi.index',  compact('repositorySkripsis', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak'));
    }

    public function menuRepositorySkripsiDetail($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $repositorySkripsi = RepositorySkripsi::where('slug', 'repository_skripsi/' . $slug)
            ->firstOrFail();

        $repositorySkripsis = RepositorySkripsi::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'repository_skripsi/' . $slug)
            ->take(2)
            ->orderBy('release_date', 'DESC');
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        return view('portal.repository_skripsi.detail',  compact('repositorySkripsi', 'repositorySkripsis', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak'));
    }
}
