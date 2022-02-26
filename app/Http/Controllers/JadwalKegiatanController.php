<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\JadwalKegiatan;
use App\Models\HimpunanMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class JadwalKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $jadwalKegiatans = JadwalKegiatan::withTrashed()->get()
            ->sortDesc();
        return view('admin/jadwal_kegiatan.index', compact('jadwalKegiatans', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/jadwal_kegiatan.create', compact('session_user'));
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
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jadwal_kegiatan')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/jadwal_kegiatan/';

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

            $slug = Str::slug($request->judul) . '_' . time();

            JadwalKegiatan::create([
                'thumbnail' => 'images/jadwal_kegiatan/' . $fileName,
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'slug' => 'jadwal_kegiatan/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/jadwal_kegiatan')->with('status', 'Jadwal Kegiatan Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalKegiatan  $jadwalKegiatans
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalKegiatan $jadwalKegiatans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalKegiatan  $jadwalKegiatans
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalKegiatan $jadwalKegiatan)
    {
        $session_user = Auth::user();
        $jadwalKegiatan = JadwalKegiatan::all()->firstWhere('slug', $jadwalKegiatan->slug);

        return view('admin.jadwal_kegiatan.edit', compact('jadwalKegiatan', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalKegiatan  $jadwalKegiatans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jadwal_kegiatan')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $jadwalKegiatans = JadwalKegiatan::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $jadwalKegiatans->thumbnail;

                JadwalKegiatan::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/jadwal_kegiatan')->with('status', 'Jadwal Kegiatan Berhasil Diubah');
            } else {
                $file = $jadwalKegiatans->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/jadwal_kegiatan/';

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

                JadwalKegiatan::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/jadwal_kegiatan/' . $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/jadwal_kegiatan')->with('status', 'Jadwal Kegiatan Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalKegiatan  $jadwalKegiatans
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JadwalKegiatan::destroy($id);
        return redirect('/admin/jadwal_kegiatan')->with('status', 'Jadwal Kegiatan Berhasil Dihapus');
    }

    public function restore($id)
    {
        $jadwalKegiatan = JadwalKegiatan::withTrashed()
            ->where('id', $id)
            ->first();

        $jadwalKegiatan->restore();
        return redirect('/admin/jadwal_kegiatan')->with('status', 'Jadwal Kegiatan Berhasil Direstore');
    }

    public function delete($id)
    {
        $jadwalKegiatan = JadwalKegiatan::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $jadwalKegiatan->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $jadwalKegiatan->forceDelete();
        return redirect('/admin/jadwal_kegiatan')->with('status', 'Jadwal Kegiatan Berhasil Dihapus Permanen');
    }

    public function menuJadwalKegiatan()
    {
        $jadwalKegiatans = JadwalKegiatan::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.jadwal_kegiatan.index',  compact('jadwalKegiatans', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak'));
    }

    public function menuDetailJadwalKegiatan($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalKegiatan = JadwalKegiatan::where('slug', 'jadwal_kegiatan/' . $slug)
            ->firstOrFail();

        $jadwalKegiatans = JadwalKegiatan::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'jadwal_kegiatan/' . $slug)
            ->take(2)
            ->orderBy('release_date', 'DESC');
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        return view('portal.jadwal_kegiatan.detail',  compact('jadwalKegiatan', 'jadwalKegiatans', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak'));
    }
}
