<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\ProfilSingkat;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\RepositoryKerjaPraktik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class RepositoryKerjaPraktikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $repositoryKerjaPraktiks = RepositoryKerjaPraktik::withTrashed()->get()
            ->sortDesc();
        return view('admin.repository_kerja_praktik.index', compact('repositoryKerjaPraktiks', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/repository_kerja_praktik.create', compact('session_user'));
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

        RepositoryKerjaPraktik::create([
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'slug' => $slug,
                'release_date' => $request->release_date,
            ]);

        return redirect('/admin/repository_kerja_praktik')->with('status', 'Repository Kerja Praktik Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RepositoryKerjaPraktik  $repositoryKerjaPraktiks
     * @return \Illuminate\Http\Response
     */
    public function show(RepositoryKerjaPraktik $repositoryKerjaPraktiks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RepositoryKerjaPraktik  $repositoryKerjaPraktiks
     * @return \Illuminate\Http\Response
     */
    public function edit(RepositoryKerjaPraktik $repositoryKerjaPraktik)
    {
        $session_user = Auth::user();
        $repositoryKerjaPraktik = RepositoryKerjaPraktik::all()->firstWhere('slug', $repositoryKerjaPraktik->slug);

        return view('admin.repository_kerja_praktik.edit', compact('repositoryKerjaPraktik', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RepositoryKerjaPraktik  $repositoryKerjaPraktik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RepositoryKerjaPraktik $repositoryKerjaPraktik)
    {
        $request->validate([
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'teks' => 'required',
            'release_date' => 'required'
        ]);

        RepositoryKerjaPraktik::where('id', $request->id)
            ->update([
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'release_date' => $request->release_date,
            ]);

        return redirect('/admin/repository_kerja_praktik')->with('status', 'Repository Kerja Praktik Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RepositoryKerjaPraktik  $repositoryKerjaPraktik
     * @return \Illuminate\Http\Response
     */
    public function destroy(RepositoryKerjaPraktik $repositoryKerjaPraktik)
    {
        RepositoryKerjaPraktik::destroy($repositoryKerjaPraktik->id);

        return redirect('/admin/repository_kerja_praktik')->with('status', 'Repository Kerja Praktik Berhasil Dihapus');
    }

    public function restore($id)
    {
        $repositoryKerjaPraktik = RepositoryKerjaPraktik::withTrashed()
            ->where('id', $id)
            ->first();

        $repositoryKerjaPraktik->restore();
        return redirect('/admin/repository_kerja_praktik')->with('status', 'Repository Kerja Praktik Berhasil Direstore');
    }

    public function delete($id)
    {
        $repositoryKerjaPraktik = RepositoryKerjaPraktik::withTrashed()
            ->where('id', $id)
            ->first();

        $repositoryKerjaPraktik->forceDelete();
        return redirect('/admin/repository_kerja_praktik')->with('status', 'Repository Kerja Praktik Berhasil Dihapus Permanen');
    }

    public function menuRepositoryKerjaPraktik()
    {
        $repositoryKerjaPraktiks = RepositoryKerjaPraktik::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.repository_kerja_praktik.index',  compact('repositoryKerjaPraktiks', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak'));
    }

    public function menuRepositoryKerjaPraktikDetail($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $repositoryRepositoryKerjaPraktik = RepositoryKerjaPraktik::where('slug', 'repository_kerja_praktik/' . $slug)
            ->firstOrFail();

        $repositoryKerjaPraktiks = RepositoryKerjaPraktik::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'repository_kerja_praktik/' . $slug)
            ->take(2)
            ->orderBy('release_date', 'DESC');
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        return view('portal.repository_kerja_praktik.detail',  compact('repositoryRepositoryKerjaPraktik', 'repositoryKerjaPraktiks', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak'));
    }
}
