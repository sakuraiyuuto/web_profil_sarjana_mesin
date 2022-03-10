<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\JadwalKuliah;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class JadwalKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $jadwalKuliahs = JadwalKuliah::withTrashed()->get()
            ->sortDesc();
        return view('admin/jadwal_kuliah.index', compact('jadwalKuliahs', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/jadwal_kuliah.create', compact('session_user'));
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
            return redirect('/admin/jadwal_kuliah')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'files/jadwal_kuliah/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

            JadwalKuliah::create([
                'nama_file' => 'files/jadwal_kuliah/' . $fileName,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'slug' => 'jadwal_kuliah/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/jadwal_kuliah')->with('status', 'Jadwal Kuliah Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalKuliah  $jadwalKuliahs
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalKuliah $jadwalKuliahs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalKuliah  $jadwalKuliahs
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalKuliah $jadwalKuliah)
    {
        $session_user = Auth::user();
        $jadwalKuliah = JadwalKuliah::all()->firstWhere('slug', $jadwalKuliah->slug);

        return view('admin.jadwal_kuliah.edit', compact('jadwalKuliah', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalKuliah  $jadwalKuliahs
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
            return redirect('/admin/jadwal_kuliah')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $jadwalKuliahs = JadwalKuliah::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $jadwalKuliahs->nama_file;

                $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

                JadwalKuliah::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'slug' => 'jadwal_kuliah/' . $slug,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/jadwal_kuliah')->with('status', 'Jadwal Kuliah Berhasil Diubah');
            } else {
                $file = $jadwalKuliahs->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/jadwal_kuliah/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

                JadwalKuliah::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/jadwal_kuliah/' . $fileName,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'slug' => 'jadwal_kuliah/' . $slug,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/jadwal_kuliah')->with('status', 'Jadwal Kuliah Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalKuliah  $jadwalKuliahs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JadwalKuliah::destroy($id);
        return redirect('/admin/jadwal_kuliah')->with('status', 'Jadwal Kuliah Berhasil Dihapus');
    }

    public function restore($id)
    {
        $jadwalKuliah = JadwalKuliah::withTrashed()
            ->where('id', $id)
            ->first();

        $jadwalKuliah->restore();
        return redirect('/admin/jadwal_kuliah')->with('status', 'Jadwal Kuliah Berhasil Direstore');
    }

    public function delete($id)
    {
        $jadwalKuliah = JadwalKuliah::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $jadwalKuliah->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $jadwalKuliah->forceDelete();
        return redirect('/admin/jadwal_kuliah')->with('status', 'Jadwal Kuliah Berhasil Dihapus Permanen');
    }

    public function menuJadwalKuliah()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalKuliahs = JadwalKuliah::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.jadwal_kuliah.index',  compact('jadwalKuliahs', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailJadwalKuliah($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalKuliah = JadwalKuliah::all()
            ->where('slug', 'jadwal_kuliah/' . $slug)
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

        return view('portal.jadwal_kuliah.detail',  compact('jadwalKuliah', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
