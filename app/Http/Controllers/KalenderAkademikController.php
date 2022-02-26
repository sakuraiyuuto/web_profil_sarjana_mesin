<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\KalenderAkademik;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;

use App\Models\ProfilSingkat;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class KalenderAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $kalenderAkademiks = KalenderAkademik::withTrashed()->get()->sortByDesc('id');

        return view('admin.kalender_akademik.index', compact('kalenderAkademiks', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kalender_akademik.create');
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
            'nama_file' => 'required',
            'release_date' => 'required',
        ]);

        $path_url = 'files/kalender_akademik/';

        $originName = $request->nama_file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $request->nama_file->getClientOriginalExtension();
        $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
        $request->nama_file->move(public_path($path_url), $fileName);

        KalenderAkademik::create(
            [
                'judul' => $request->judul,
                'nama_file' => $path_url . $fileName,
                'slug' => 'kalender_akademik/' . Str::slug($request->judul) . '_' . time(),
                'release_date' => $request->release_date
            ]
        );

        return redirect('/admin/kalender_akademik')->with('status', 'Data Berhasil Ditambah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KalenderAkademik  $kalenderAkademik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KalenderAkademik $kalenderAkademik)
    {
        $request->validate([
            'judul' => 'required',
            'release_date' => 'required'
        ]);

        if ($request->nama_file != "") {
            $path_url = 'files/kalender_akademik/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            if (File::exists(public_path($request->old_file))) {
                File::delete(public_path($request->old_file));
            }

            KalenderAkademik::where('id', $request->id)
                ->update([
                    'judul' => $request->judul,
                    'nama_file' => $path_url . $fileName,
                    'release_date' => $request->release_date
                ]);
        } else {
            KalenderAkademik::where('id', $request->id)
                ->update([
                    'judul' => $request->judul,
                    'release_date' => $request->release_date
                ]);
        }

        return redirect(route('kalender_akademik.index'))->with('status', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KalenderAkademik  $kalenderAkademik
     * @return \Illuminate\Http\Response
     */
    public function destroy(KalenderAkademik $kalenderAkademik)
    {
        KalenderAkademik::destroy($kalenderAkademik->id);

        return redirect()->route('kalender_akademik.index')->with('status', 'Data Berhasil Dihapus');
    }

    public function restore($id)
    {
        KalenderAkademik::withTrashed()->where('id', $id)->restore();

        return redirect()->route('kalender_akademik.index')->with('status', 'Data Berhasil Dikembalikan');
    }

    public function deletePermanen(Request $request, $id)
    {
        if (File::exists(public_path($request->nama_file))) {
            File::delete(public_path($request->nama_file));
        }

        KalenderAkademik::withTrashed()->where('id', $id)->forceDelete();

        return redirect()->route('kalender_akademik.index')->with('status', 'Data Terhapus Permanen!');
    }

    public function menuKalenderAkademik()
    {
        $kalenderAkademiks = KalenderAkademik::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')->paginate(6);

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

        return view('portal.kalender_akademik.index',  compact('kalenderAkademiks', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuKalenderAkademikDetail($slug)
    {
        $kontak = Kontak::all()->first();


        $profilSingkat = ProfilSingkat::all()->first();
        $kalenderAkademik = KalenderAkademik::where('slug', 'kalender_akademik/' . $slug)
            ->firstOrFail();

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

        return view('portal.kalender_akademik.show', compact('kalenderAkademik', 'kontak', 'informasiTerbarus', 'aplikasiIntegrasis',  'profilSingkat', 'laboratoriumHeaders'));
    }
}
