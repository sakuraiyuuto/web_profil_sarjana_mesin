<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\LowonganPekerjaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class LowonganPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $lowonganPekerjaans = LowonganPekerjaan::withTrashed()->get()
            ->sortDesc();
        return view('admin.lowongan_pekerjaan.index', compact('lowonganPekerjaans', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/lowongan_pekerjaan.create', compact('session_user'));
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
            'thumbnail' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/lowongan_pekerjaan')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/lowongan_pekerjaan/';

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

            LowonganPekerjaan::create([
                'thumbnail' => 'images/lowongan_pekerjaan/' . $fileName,
                'judul' => $request->judul,
                'teks' => $request->teks,
                'slug' => 'lowongan_pekerjaan/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/lowongan_pekerjaan')->with('status', 'Layanan Mahasiswa Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LowonganPekerjaan  $lowonganPekerjaans
     * @return \Illuminate\Http\Response
     */
    public function show(LowonganPekerjaan $lowonganPekerjaans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LowonganPekerjaan  $lowonganPekerjaans
     * @return \Illuminate\Http\Response
     */
    public function edit(LowonganPekerjaan $lowonganPekerjaan)
    {
        $session_user = Auth::user();
        $lowonganPekerjaan = LowonganPekerjaan::all()->firstWhere('slug', $lowonganPekerjaan->slug);

        return view('admin.lowongan_pekerjaan.edit', compact('lowonganPekerjaan', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LowonganPekerjaan  $lowonganPekerjaans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'judul' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/lowongan_pekerjaan')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $lowonganPekerjaans = LowonganPekerjaan::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $lowonganPekerjaans->thumbnail;

                LowonganPekerjaan::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/lowongan_pekerjaan')->with('status', 'Layanan Mahasiswa Berhasil Diubah');
            } else {
                $file = $lowonganPekerjaans->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/lowongan_pekerjaan/';

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

                LowonganPekerjaan::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/lowongan_pekerjaan/' . $fileName,
                        'judul' => $request->judul,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/lowongan_pekerjaan')->with('status', 'Layanan Mahasiswa Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LowonganPekerjaan  $lowonganPekerjaans
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LowonganPekerjaan::destroy($id);
        return redirect('/admin/lowongan_pekerjaan')->with('status', 'Layanan Mahasiswa Berhasil Dihapus');
    }

    public function restore($id)
    {
        $lowonganPekerjaan = LowonganPekerjaan::withTrashed()
            ->where('id', $id)
            ->first();

        $lowonganPekerjaan->restore();
        return redirect('/admin/lowongan_pekerjaan')->with('status', 'Layanan Mahasiswa Berhasil Direstore');
    }

    public function delete($id)
    {
        $lowonganPekerjaan = LowonganPekerjaan::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $lowonganPekerjaan->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $lowonganPekerjaan->forceDelete();
        return redirect('/admin/lowongan_pekerjaan')->with('status', 'Layanan Mahasiswa Berhasil Dihapus Permanen');
    }

    public function menuLowonganPekerjaan()
    {
        $lowonganPekerjaans = LowonganPekerjaan::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.lowongan_pekerjaan.index',  compact('lowonganPekerjaans', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailLowonganPekerjaan($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $lowonganPekerjaan = LowonganPekerjaan::where('slug', 'lowongan_pekerjaan/' . $slug)
            ->firstOrFail();

        $lowonganPekerjaans = LowonganPekerjaan::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'lowongan_pekerjaan/' . $slug)
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

        return view('portal.lowongan_pekerjaan.detail',  compact('lowonganPekerjaan', 'lowonganPekerjaans', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
