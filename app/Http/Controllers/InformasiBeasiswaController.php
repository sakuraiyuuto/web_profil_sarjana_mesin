<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiBeasiswa;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class InformasiBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $informasiBeasiswas = InformasiBeasiswa::withTrashed()->get()
            ->sortDesc();
        return view('admin/informasi_beasiswa.index', compact('informasiBeasiswas', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/informasi_beasiswa.create', compact('session_user'));
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
            return redirect('/admin/informasi_beasiswa')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/informasi_beasiswa/';

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

            InformasiBeasiswa::create([
                'thumbnail' => 'images/informasi_beasiswa/' . $fileName,
                'judul' => $request->judul,
                'teks' => $request->teks,
                'slug' => 'informasi_beasiswa/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/informasi_beasiswa')->with('status', 'Informasi Beasiswa Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InformasiBeasiswa  $informasiBeasiswas
     * @return \Illuminate\Http\Response
     */
    public function show(InformasiBeasiswa $informasiBeasiswas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InformasiBeasiswa  $informasiBeasiswas
     * @return \Illuminate\Http\Response
     */
    public function edit(InformasiBeasiswa $informasiBeasiswa)
    {
        $session_user = Auth::user();
        $informasiBeasiswa = InformasiBeasiswa::all()->firstWhere('slug', $informasiBeasiswa->slug);

        return view('admin.informasi_beasiswa.edit', compact('informasiBeasiswa', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InformasiBeasiswa  $informasiBeasiswas
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
            return redirect('/admin/informasi_beasiswa')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $informasiBeasiswas = InformasiBeasiswa::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $informasiBeasiswas->thumbnail;

                InformasiBeasiswa::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/informasi_beasiswa')->with('status', 'Informasi Beasiswa Berhasil Diubah');
            } else {
                $file = $informasiBeasiswas->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/informasi_beasiswa/';

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

                InformasiBeasiswa::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/informasi_beasiswa/' . $fileName,
                        'judul' => $request->judul,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/informasi_beasiswa')->with('status', 'Informasi Beasiswa Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InformasiBeasiswa  $informasiBeasiswas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InformasiBeasiswa::destroy($id);
        return redirect('/admin/informasi_beasiswa')->with('status', 'Informasi Beasiswa Berhasil Dihapus');
    }

    public function restore($id)
    {
        $informasiBeasiswa = InformasiBeasiswa::withTrashed()
            ->where('id', $id)
            ->first();

        $informasiBeasiswa->restore();
        return redirect('/admin/informasi_beasiswa')->with('status', 'Informasi Beasiswa Berhasil Direstore');
    }

    public function delete($id)
    {
        $informasiBeasiswa = InformasiBeasiswa::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $informasiBeasiswa->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $informasiBeasiswa->forceDelete();
        return redirect('/admin/informasi_beasiswa')->with('status', 'Informasi Beasiswa Berhasil Dihapus Permanen');
    }

    public function menuInformasiBeasiswa()
    {
        $informasiBeasiswas = InformasiBeasiswa::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.informasi_beasiswa.index',  compact('informasiBeasiswas', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailInformasiBeasiswa($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $informasiBeasiswa = InformasiBeasiswa::where('slug', 'informasi_beasiswa/' . $slug)
            ->firstOrFail();
        $informasiBeasiswas = InformasiBeasiswa::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'informasi_beasiswa/' . $slug)
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

        return view('portal.informasi_beasiswa.detail',  compact('informasiBeasiswa', 'informasiBeasiswas', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
