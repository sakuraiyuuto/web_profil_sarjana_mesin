<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\PengabdianKepadaMasyarakatDosen;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class PengabdianKepadaMasyarakatDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $pengabdianKepadaMasyarakatDosens = PengabdianKepadaMasyarakatDosen::withTrashed()->get()
            ->sortDesc();
        return view('admin/pengabdian_kepada_masyarakat_dosen.index', compact('pengabdianKepadaMasyarakatDosens', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/pengabdian_kepada_masyarakat_dosen.create', compact('session_user'));
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
            return redirect('/admin/pkm_dosen')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/pengabdian_kepada_masyarakat_dosen/';

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

            PengabdianKepadaMasyarakatDosen::create([
                'thumbnail' => 'images/pengabdian_kepada_masyarakat_dosen/' . $fileName,
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'slug' => 'pkm_dosen/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/pkm_dosen')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakatDosen  $pengabdianKepadaMasyarakatDosens
     * @return \Illuminate\Http\Response
     */
    public function show(PengabdianKepadaMasyarakatDosen $pengabdianKepadaMasyarakatDosens)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakatDosen  $pengabdianKepadaMasyarakatDosens
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session_user = Auth::user();
        $pengabdianKepadaMasyarakatDosen = PengabdianKepadaMasyarakatDosen::all()->firstWhere('id', $id);

        return view('admin.pengabdian_kepada_masyarakat_dosen.edit', compact('pengabdianKepadaMasyarakatDosen', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengabdianKepadaMasyarakatDosen  $pengabdianKepadaMasyarakatDosens
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
            return redirect('/admin/pkm_dosen')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $pengabdianKepadaMasyarakatDosens = PengabdianKepadaMasyarakatDosen::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $pengabdianKepadaMasyarakatDosens->thumbnail;

                PengabdianKepadaMasyarakatDosen::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/pkm_dosen')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Diubah');
            } else {
                $file = $pengabdianKepadaMasyarakatDosens->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/pengabdian_kepada_masyarakat_dosen/';

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

                PengabdianKepadaMasyarakatDosen::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/pengabdian_kepada_masyarakat_dosen/' . $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/pkm_dosen')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakatDosen  $pengabdianKepadaMasyarakatDosens
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PengabdianKepadaMasyarakatDosen::destroy($id);
        return redirect('/admin/pkm_dosen')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Dihapus');
    }

    public function restore($id)
    {
        $pengabdianKepadaMasyarakatDosen = PengabdianKepadaMasyarakatDosen::withTrashed()
            ->where('id', $id)
            ->first();

        $pengabdianKepadaMasyarakatDosen->restore();
        return redirect('/admin/pkm_dosen')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Direstore');
    }

    public function delete($id)
    {
        $pengabdianKepadaMasyarakatDosen = PengabdianKepadaMasyarakatDosen::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $pengabdianKepadaMasyarakatDosen->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $pengabdianKepadaMasyarakatDosen->forceDelete();
        return redirect('/admin/pkm_dosen')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Dihapus Permanen');
    }

    public function menuPengabdianKepadaMasyarakatDosen()
    {
        $pengabdianKepadaMasyarakatDosens = PengabdianKepadaMasyarakatDosen::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.pengabdian_kepada_masyarakat_dosen.index',  compact('pengabdianKepadaMasyarakatDosens', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailPengabdianKepadaMasyarakatDosen($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $pengabdianKepadaMasyarakatDosen = PengabdianKepadaMasyarakatDosen::where('slug', 'pkm_dosen/' . $slug)
            ->firstOrFail();

        $pengabdianKepadaMasyarakatDosens = PengabdianKepadaMasyarakatDosen::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'pengabdian_kepada_masyarakat_dosen/' . $slug)
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

        return view('portal.pengabdian_kepada_masyarakat_dosen.detail',  compact('pengabdianKepadaMasyarakatDosen', 'pengabdianKepadaMasyarakatDosens', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
