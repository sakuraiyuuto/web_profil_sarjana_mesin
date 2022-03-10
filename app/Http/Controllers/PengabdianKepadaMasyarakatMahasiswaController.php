<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\PengabdianKepadaMasyarakatMahasiswa;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class PengabdianKepadaMasyarakatMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $pengabdianKepadaMasyarakatMahasiswas = PengabdianKepadaMasyarakatMahasiswa::withTrashed()->get()
            ->sortDesc();
        return view('admin/pengabdian_kepada_masyarakat_mahasiswa.index', compact('pengabdianKepadaMasyarakatMahasiswas', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/pengabdian_kepada_masyarakat_mahasiswa.create', compact('session_user'));
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
            return redirect('/admin/pkm_mahasiswa')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/pengabdian_kepada_masyarakat_mahasiswa/';

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

            PengabdianKepadaMasyarakatMahasiswa::create([
                'thumbnail' => 'images/pengabdian_kepada_masyarakat_mahasiswa/' . $fileName,
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'slug' => 'pkm_mahasiswa/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/pkm_mahasiswa')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakatMahasiswa  $pengabdianKepadaMasyarakatMahasiswas
     * @return \Illuminate\Http\Response
     */
    public function show(PengabdianKepadaMasyarakatMahasiswa $pengabdianKepadaMasyarakatMahasiswas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakatMahasiswa  $pengabdianKepadaMasyarakatMahasiswas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session_user = Auth::user();
        $pengabdianKepadaMasyarakatMahasiswa = PengabdianKepadaMasyarakatMahasiswa::all()->firstWhere('id', $id);

        return view('admin.pengabdian_kepada_masyarakat_mahasiswa.edit', compact('pengabdianKepadaMasyarakatMahasiswa', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengabdianKepadaMasyarakatMahasiswa  $pengabdianKepadaMasyarakatMahasiswas
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
            return redirect('/admin/pkm_mahasiswa')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $pengabdianKepadaMasyarakatMahasiswas = PengabdianKepadaMasyarakatMahasiswa::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $pengabdianKepadaMasyarakatMahasiswas->thumbnail;

                PengabdianKepadaMasyarakatMahasiswa::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/pkm_mahasiswa')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Diubah');
            } else {
                $file = $pengabdianKepadaMasyarakatMahasiswas->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/pengabdian_kepada_masyarakat_mahasiswa/';

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

                PengabdianKepadaMasyarakatMahasiswa::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/pengabdian_kepada_masyarakat_mahasiswa/' . $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/pkm_mahasiswa')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakatMahasiswa  $pengabdianKepadaMasyarakatMahasiswas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PengabdianKepadaMasyarakatMahasiswa::destroy($id);
        return redirect('/admin/pkm_mahasiswa')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Dihapus');
    }

    public function restore($id)
    {
        $pengabdianKepadaMasyarakatMahasiswa = PengabdianKepadaMasyarakatMahasiswa::withTrashed()
            ->where('id', $id)
            ->first();

        $pengabdianKepadaMasyarakatMahasiswa->restore();
        return redirect('/admin/pkm_mahasiswa')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Direstore');
    }

    public function delete($id)
    {
        $pengabdianKepadaMasyarakatMahasiswa = PengabdianKepadaMasyarakatMahasiswa::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $pengabdianKepadaMasyarakatMahasiswa->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $pengabdianKepadaMasyarakatMahasiswa->forceDelete();
        return redirect('/admin/pkm_mahasiswa')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Dihapus Permanen');
    }

    public function menuPengabdianKepadaMasyarakatMahasiswa()
    {
        $pengabdianKepadaMasyarakatMahasiswas = PengabdianKepadaMasyarakatMahasiswa::where('release_date', '<=', date('Y-m-d'))
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

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.pengabdian_kepada_masyarakat_mahasiswa.index',  compact('pengabdianKepadaMasyarakatMahasiswas', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailPengabdianKepadaMasyarakatMahasiswa($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $pengabdianKepadaMasyarakatMahasiswa = PengabdianKepadaMasyarakatMahasiswa::where('slug', 'pkm_mahasiswa/' . $slug)
            ->firstOrFail();

        $pengabdianKepadaMasyarakatMahasiswas = PengabdianKepadaMasyarakatMahasiswa::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'pengabdian_kepada_masyarakat_mahasiswa/' . $slug)
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

        return view('portal.pengabdian_kepada_masyarakat_mahasiswa.detail',  compact('pengabdianKepadaMasyarakatMahasiswa', 'pengabdianKepadaMasyarakatMahasiswas', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
