<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\JadwalUjian;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class JadwalUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $jadwalUjians = JadwalUjian::withTrashed()->get()
            ->sortDesc();
        return view('admin/jadwal_ujian.index', compact('jadwalUjians', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/jadwal_ujian.create', compact('session_user'));
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
            'tipe_ujian' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'nama_file' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jadwal_ujian')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'files/jadwal_ujian/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            $slug = 'jadwal-' . Str::slug($request->tipe_ujian) . '-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

            JadwalUjian::create([
                'nama_file' => 'files/jadwal_ujian/' . $fileName,
                'tipe_ujian' => $request->tipe_ujian,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'slug' => 'jadwal_ujian/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/jadwal_ujian')->with('status', 'Dokumen Prodi Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalUjian  $jadwalUjians
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalUjian $jadwalUjians)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalUjian  $jadwalUjians
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalUjian $jadwalUjian)
    {
        $session_user = Auth::user();
        $jadwalUjian = JadwalUjian::all()->firstWhere('slug', $jadwalUjian->slug);

        return view('admin.jadwal_ujian.edit', compact('jadwalUjian', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalUjian  $jadwalUjians
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'tipe_ujian' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jadwal_ujian')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $jadwalUjians = JadwalUjian::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $jadwalUjians->nama_file;

                $slug = 'jadwal-' . Str::slug($request->tipe_ujian) . '-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

                JadwalUjian::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'tipe_ujian' => $request->tipe_ujian,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'slug' => 'jadwal_ujian/' . $slug,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/jadwal_ujian')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $file = $jadwalUjians->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/jadwal_ujian/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                $slug = 'jadwal-' . Str::slug($request->tipe_ujian) . '-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

                JadwalUjian::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/jadwal_ujian/' . $fileName,
                        'tipe_ujian' => $request->tipe_ujian,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'slug' => 'jadwal_ujian/' . $slug,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/jadwal_ujian')->with('status', 'Dokumen Prodi Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalUjian  $jadwalUjians
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JadwalUjian::destroy($id);
        return redirect('/admin/jadwal_ujian')->with('status', 'Dokumen Prodi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $jadwalUjian = JadwalUjian::withTrashed()
            ->where('id', $id)
            ->first();

        $jadwalUjian->restore();
        return redirect('/admin/jadwal_ujian')->with('status', 'Dokumen Prodi Berhasil Direstore');
    }

    public function delete($id)
    {
        $jadwalUjian = JadwalUjian::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $jadwalUjian->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $jadwalUjian->forceDelete();
        return redirect('/admin/jadwal_ujian')->with('status', 'Dokumen Prodi Berhasil Dihapus Permanen');
    }

    public function menuJadwalUjian()
    {
        $kontak = Kontak::all()->first();


        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalUjians = JadwalUjian::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.jadwal_ujian.index',  compact('jadwalUjians', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailJadwalUjian($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalUjian = JadwalUjian::all()
            ->where('slug', 'jadwal_ujian/' . $slug)
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

        return view('portal.jadwal_ujian.detail',  compact('jadwalUjian', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
