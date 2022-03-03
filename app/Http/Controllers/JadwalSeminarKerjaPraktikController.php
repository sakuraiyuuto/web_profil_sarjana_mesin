<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\JadwalSeminarKerjaPraktik;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class JadwalSeminarKerjaPraktikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $jadwalSeminarKerjaPraktiks = JadwalSeminarKerjaPraktik::withTrashed()->get()
            ->sortDesc();
        return view('admin/jadwal_seminar_kerja_praktik.index', compact('jadwalSeminarKerjaPraktiks', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/jadwal_seminar_kerja_praktik.create', compact('session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'nama_file' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jadwal_seminar_kerja_praktik')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'files/jadwal_seminar_kerja_praktik/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

            JadwalSeminarKerjaPraktik::create([
                'nama_file' => 'files/jadwal_seminar_kerja_praktik/' . $fileName,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'slug' => 'jadwal_seminar_kerja_praktik/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/jadwal_seminar_kerja_praktik')->with('status', 'Jadwal Seminar Kerja Praktik Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalSeminarKerjaPraktik  $jadwalSeminarKerjaPraktiks
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalSeminarKerjaPraktik $jadwalSeminarKerjaPraktiks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalSeminarKerjaPraktik  $jadwalSeminarKerjaPraktiks
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalSeminarKerjaPraktik $jadwalSeminarKerjaPraktik)
    {
        $session_user = Auth::user();
        $jadwalSeminarKerjaPraktik = JadwalSeminarKerjaPraktik::all()->firstWhere('slug', $jadwalSeminarKerjaPraktik->slug);

        return view('admin.jadwal_seminar_kerja_praktik.edit', compact('jadwalSeminarKerjaPraktik', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalSeminarKerjaPraktik  $jadwalSeminarKerjaPraktiks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jadwal_seminar_kerja_praktik')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $jadwalSeminarKerjaPraktiks = JadwalSeminarKerjaPraktik::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $jadwalSeminarKerjaPraktiks->nama_file;

                $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

                JadwalSeminarKerjaPraktik::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'slug' => 'jadwal_seminar_kerja_praktik/' . $slug,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/jadwal_seminar_kerja_praktik')->with('status', 'Jadwal Seminar Kerja Praktik Berhasil Diubah');
            } else {
                $file = $jadwalSeminarKerjaPraktiks->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/jadwal_seminar_kerja_praktik/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

                JadwalSeminarKerjaPraktik::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/jadwal_seminar_kerja_praktik/' . $fileName,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'slug' => 'jadwal_seminar_kerja_praktik/' . $slug,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/jadwal_seminar_kerja_praktik')->with('status', 'Jadwal Seminar Kerja Praktik Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalSeminarKerjaPraktik  $jadwalSeminarKerjaPraktiks
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JadwalSeminarKerjaPraktik::destroy($id);
        return redirect('/admin/jadwal_seminar_kerja_praktik')->with('status', 'Jadwal Seminar Kerja Praktik Berhasil Dihapus');
    }

    public function restore($id)
    {
        $jadwalSeminarKerjaPraktik = JadwalSeminarKerjaPraktik::withTrashed()
            ->where('id', $id)
            ->first();

        $jadwalSeminarKerjaPraktik->restore();
        return redirect('/admin/jadwal_seminar_kerja_praktik')->with('status', 'Jadwal Seminar Kerja Praktik Berhasil Direstore');
    }

    public function delete($id)
    {
        $jadwalSeminarKerjaPraktik = JadwalSeminarKerjaPraktik::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $jadwalSeminarKerjaPraktik->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $jadwalSeminarKerjaPraktik->forceDelete();
        return redirect('/admin/jadwal_seminar_kerja_praktik')->with('status', 'Jadwal Seminar Kerja Praktik Berhasil Dihapus Permanen');
    }

    public function menuJadwalSeminarKerjaPraktik()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalSeminarKerjaPraktiks = JadwalSeminarKerjaPraktik::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('tahun_ajaran', 'DESC')
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

        return view('portal.jadwal_seminar_kerja_praktik.index',  compact('jadwalSeminarKerjaPraktiks', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailJadwalSeminarKerjaPraktik($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalSeminarKerjaPraktik = JadwalSeminarKerjaPraktik::all()
            ->where('slug', 'jadwal_seminar_kerja_praktik/' . $slug)
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

        return view('portal.jadwal_seminar_kerja_praktik.detail',  compact('jadwalSeminarKerjaPraktik', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
