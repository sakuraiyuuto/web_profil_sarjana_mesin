<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\KerjasamaMitraKolaborasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;

use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class KerjasamaMitraKolaborasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $kerjasamaMitraKolaborasis = KerjasamaMitraKolaborasi::withTrashed()->get()->sortByDesc('id');

        return view('admin.kerjasama_mitra_kolaborasi.index', compact('kerjasamaMitraKolaborasis', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kerjasama_mitra_kolaborasi.create');
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
            'thumbnail' => 'required',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        $path_url = 'images/kerjasama_mitra_kolaborasi/';

        $originName = $request->thumbnail->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $request->thumbnail->getClientOriginalExtension();
        $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
        $request->thumbnail->move(public_path($path_url), $fileName);

        //Resize image here
        $thumbnailpath = public_path($path_url) . $fileName;
        $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save($thumbnailpath);

        KerjasamaMitraKolaborasi::create(
            [
                'judul' => $request->judul,
                'thumbnail' => $path_url . $fileName,
                'teks' => $request->teks,
                'slug' => 'kerjasama_mitra_kolaborasi/' . Str::slug($request->judul) . '_' . time(),
                'release_date' => $request->release_date
            ]
        );

        return redirect('/admin/kerjasama_mitra_kolaborasi')->with('status', 'Data Berhasil Ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KerjasamaMitraKolaborasi  $kerjasamaMitraKolaborasi
     * @return \Illuminate\Http\Response
     */
    public function edit(KerjasamaMitraKolaborasi $kerjasamaMitraKolaborasi)
    {
        $kerjasamaMitraKolaborasi = KerjasamaMitraKolaborasi::all()->firstWhere('slug', $kerjasamaMitraKolaborasi->slug);

        return view('admin.kerjasama_mitra_kolaborasi.edit', compact('kerjasamaMitraKolaborasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KerjasamaMitraKolaborasi  $kerjasamaMitraKolaborasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KerjasamaMitraKolaborasi $kerjasamaMitraKolaborasi)
    {
        $request->validate([
            'judul' => 'required',
            'teks' => 'required',
            'release_date' => 'required'
        ]);

        if ($request->thumbnail != "") {
            $path_url = 'images/kerjasama_mitra_kolaborasi/';

            $originName = $request->thumbnail->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->thumbnail->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->thumbnail->move(public_path($path_url), $fileName);

            //Resize image here
            $thumbnailpath = public_path($path_url) . $fileName;
            $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbnailpath);

            if (File::exists(public_path($request->old_thumbnail))) {
                File::delete(public_path($request->old_thumbnail));
            }

            KerjasamaMitraKolaborasi::where('id', $kerjasamaMitraKolaborasi->id)
                ->update([
                    'judul' => $request->judul,
                    'thumbnail' => $path_url . $fileName,
                    'teks' => $request->teks,
                    'release_date' => $request->release_date
                ]);
        } else {
            KerjasamaMitraKolaborasi::where('id', $kerjasamaMitraKolaborasi->id)
                ->update([
                    'judul' => $request->judul,
                    'teks' => $request->teks,
                    'release_date' => $request->release_date
                ]);
        }

        return redirect(route('kerjasama_mitra_kolaborasi.index'))->with('status', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KerjasamaMitraKolaborasi  $kerjasamaMitraKolaborasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(KerjasamaMitraKolaborasi $kerjasamaMitraKolaborasi)
    {
        KerjasamaMitraKolaborasi::destroy($kerjasamaMitraKolaborasi->id);

        return redirect()->route('kerjasama_mitra_kolaborasi.index')->with('status', 'Data Berhasil Dihapus');
    }

    public function restore($id)
    {
        KerjasamaMitraKolaborasi::withTrashed()->where('id', $id)->restore();

        return redirect()->route('kerjasama_mitra_kolaborasi.index')->with('status', 'Data Berhasil Dikembalikan');
    }

    public function deletePermanen(Request $request, $id)
    {
        if (File::exists(public_path($request->thumbnail))) {
            File::delete(public_path($request->thumbnail));
        }

        KerjasamaMitraKolaborasi::withTrashed()->where('id', $id)->forceDelete();

        return redirect()->route('kerjasama_mitra_kolaborasi.index')->with('status', 'Data Berhasil Dihapus');
    }

    public function menuKerjasamaMitraKolaborasi()
    {
        $kerjasamaMitraKolaborasis = KerjasamaMitraKolaborasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->paginate(6);

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

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.kerjasama_mitra_kolaborasi.index',  compact('kerjasamaMitraKolaborasis', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuKerjasamaMitraKolaborasiDetail($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();

        $kerjasamaMitraKolaborasi = KerjasamaMitraKolaborasi::where('slug', 'kerjasama_mitra_kolaborasi/' . $slug)
            ->firstOrFail();

        $kerjasamaMitraKolaborasis = KerjasamaMitraKolaborasi::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'kerjasama_mitra_kolaborasi/' . $slug)
            ->take(2)
            ->orderBy('release_date', 'DESC');
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
            
        return view('portal.kerjasama_mitra_kolaborasi.show', compact('kontak', 'kerjasamaMitraKolaborasi', 'kerjasamaMitraKolaborasis', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'laboratoriumHeaders'));
    }
}
