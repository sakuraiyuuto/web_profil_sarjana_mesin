<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\HimpunanMahasiswa;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Berita;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $beritas = Berita::withTrashed()->get()
            ->sortDesc();
        return view('admin/berita.index', compact('beritas', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/berita.create', compact('session_user'));
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
            return redirect('/admin/berita')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/berita/';

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

            Berita::create([
                'thumbnail' => 'images/berita/' . $fileName,
                'judul' => $request->judul,
                'teks' => $request->teks,
                'slug' => 'berita/' . $slug,
                'release_date' => $request->release_date,
            ]);

            $response = Http::attach(
                'thumbnail',
                file_get_contents($thumbnailpath),
                $fileName
            )->post('http://teknik.untan.ac.id/api/tambahBerita', [
                'password' => 's1teXUnT4n2022',
                'judul' => $request->judul,
                'teks' => $request->teks,
                'release_date' => $request->release_date,
                'slug' => 'berita/' . $slug,
            ]);

            return redirect('/admin/berita')->with('status', 'Berita Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Berita  $beritas
     * @return \Illuminate\Http\Response
     */
    public function show(Berita $beritas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Berita  $beritas
     * @return \Illuminate\Http\Response
     */
    public function edit(Berita $berita)
    {
        $session_user = Auth::user();
        $berita = Berita::all()->firstWhere('slug', $berita->slug);

        return view('admin.berita.edit', compact('berita', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Berita  $beritas
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
            return redirect('/admin/berita')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $beritas = Berita::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $beritas->thumbnail;

                Berita::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);

                $berita = Berita::where('id', $request->id)->first();;

                $response = Http::post('http://teknik.untan.ac.id/api/updateBerita', [
                    'judul' => $request->judul,
                    'password' => 's1teXUnT4n2022',
                    'thumbnail' => 'kosong',
                    'teks' => $request->teks,
                    'release_date' => $request->release_date,
                    'slug' => $berita->slug,
                ]);

                return redirect('/admin/berita')->with('status', 'Berita Berhasil Diubah');
            } else {
                $file = $beritas->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/berita/';

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

                Berita::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/berita/' . $fileName,
                        'judul' => $request->judul,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);

                $berita = Berita::where('id', $request->id)->first();;

                $response = Http::attach(
                    'thumbnail',
                    file_get_contents($thumbnailpath),
                    $fileName
                )->post('http://teknik.untan.ac.id/api/updateBerita', [
                    'password' => 's1teXUnT4n2022',
                    'judul' => $request->judul,
                    'teks' => $request->teks,
                    'slug' => $berita->slug,
                    'release_date' => $request->release_date,
                ]);

                return redirect('/admin/berita')->with('status', 'Berita Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Berita  $beritas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $berita = Berita::where('id', $id)->first();

        $response = Http::post('http://teknik.untan.ac.id/api/deleteBerita', [
            'slug' => $berita->slug,
            'password' => 's1teXUnT4n2022',
        ]);

        Berita::destroy($id);
        return redirect('/admin/berita')->with('status', 'Berita Berhasil Dihapus');
    }

    public function restore($id)
    {
        $berita = Berita::withTrashed()
            ->where('id', $id)
            ->first();

        $berita->restore();

        $response = Http::post('http://teknik.untan.ac.id/api/beritaRestore', [
            'slug' => $berita->slug,
            'password' => 's1teXUnT4n2022',
        ]);

        return redirect('/admin/berita')->with('status', 'Berita Berhasil Direstore');
    }

    public function delete($id)
    {
        $berita = Berita::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $berita->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $response = Http::post('http://teknik.untan.ac.id/api/beritaDeletePermanen', [
            'slug' => $berita->slug,
            'password' => 's1teXUnT4n2022',
        ]);

        $berita->forceDelete();
        return redirect('/admin/berita')->with('status', 'Berita Berhasil Dihapus Permanen');
    }

    public function menuBerita()
    {
        $beritas = Berita::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.berita.index',  compact('beritas', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
    public function menuDetailBerita($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $berita = Berita::where('slug', 'berita/' . $slug)
            ->firstOrFail();

        $beritas = Berita::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'berita/' . $slug)
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

        return view('portal.berita.detail',  compact('berita', 'beritas', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
