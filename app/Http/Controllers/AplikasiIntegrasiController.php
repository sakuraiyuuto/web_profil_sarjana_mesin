<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\HimpunanMahasiswa;

use App\Models\ProfilSingkat;
use App\Models\InformasiTerbaru;
use App\Models\AplikasiIntegrasi;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class AplikasiIntegrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $aplikasiIntegrasis = AplikasiIntegrasi::withTrashed()->get()
            ->sortDesc();
        return view('admin/aplikasi_integrasi.index', compact('aplikasiIntegrasis', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/aplikasi_integrasi.create', compact('session_user'));
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
            'nama' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'url' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/aplikasi_integrasi')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/aplikasi_integrasi/';

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

            AplikasiIntegrasi::create([
                'thumbnail' => 'images/aplikasi_integrasi/' . $fileName,
                'nama' => $request->nama,
                'teks' => $request->teks,
                'url' => $request->url,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/aplikasi_integrasi')->with('status', 'Aplikasi Integrasi Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AplikasiIntegrasi  $aplikasiIntegrasis
     * @return \Illuminate\Http\Response
     */
    public function show(AplikasiIntegrasi $aplikasiIntegrasis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AplikasiIntegrasi  $aplikasiIntegrasis
     * @return \Illuminate\Http\Response
     */
    public function edit(AplikasiIntegrasi $aplikasiIntegrasi)
    {
        $session_user = Auth::user();
        $aplikasiIntegrasi = AplikasiIntegrasi::all()->firstWhere('slug', $aplikasiIntegrasi->slug);

        return view('admin.aplikasiIntegrasi.edit', compact('aplikasiIntegrasi', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AplikasiIntegrasi  $aplikasiIntegrasis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/aplikasi_integrasi')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $aplikasiIntegrasis = AplikasiIntegrasi::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $aplikasiIntegrasis->thumbnail;

                AplikasiIntegrasi::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'nama' => $request->nama,
                        'teks' => $request->teks,
                        'url' => $request->url,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/aplikasi_integrasi')->with('status', 'Aplikasi Integrasi Berhasil Diubah');
            } else {
                $file = $aplikasiIntegrasis->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/aplikasi_integrasi/';

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

                $slug = Str::slug($request->nama) . '_' . time();

                AplikasiIntegrasi::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/aplikasi_integrasi/' . $fileName,
                        'nama' => $request->nama,
                        'teks' => $request->teks,
                        'url' => $request->url,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/aplikasi_integrasi')->with('status', 'Aplikasi Integrasi Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AplikasiIntegrasi  $aplikasiIntegrasis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AplikasiIntegrasi::destroy($id);
        return redirect('/admin/aplikasi_integrasi')->with('status', 'Aplikasi Integrasi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $aplikasiIntegrasi = AplikasiIntegrasi::withTrashed()
            ->where('id', $id)
            ->first();

        $aplikasiIntegrasi->restore();
        return redirect('/admin/aplikasi_integrasi')->with('status', 'Aplikasi Integrasi Berhasil Direstore');
    }

    public function delete($id)
    {
        $aplikasiIntegrasi = AplikasiIntegrasi::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $aplikasiIntegrasi->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $aplikasiIntegrasi->forceDelete();
        return redirect('/admin/aplikasi_integrasi')->with('status', 'Aplikasi Integrasi Berhasil Dihapus Permanen');
    }

    public function menuAplikasiIntegrasi()
    {
        $aplikasiIntegrasiPaginates = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
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

        return view('portal.aplikasi_integrasi.index',  compact('aplikasiIntegrasiPaginates', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
