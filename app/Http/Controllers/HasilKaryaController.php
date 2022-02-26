<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\HasilKarya;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;

use App\Models\ProfilSingkat;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class HasilKaryaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $hasilKaryas = HasilKarya::withTrashed()->get()->sortByDesc('id');

        return view('admin.hasil_karya.index', compact('hasilKaryas', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.hasil_karya.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'thumbnail' => 'required',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        $path_url = 'images/hasil_karya/';

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

        HasilKarya::create(
            [
                'judul' => $request->judul,
                'thumbnail' => $path_url . $fileName,
                'teks' => $request->teks,
                'slug' => 'hasil_karya/' . Str::slug($request->judul) . '_' . time(),
                'release_date' => $request->release_date
            ]
        );

        return redirect('/admin/hasil_karya')->with('status', 'Data Berhasil Ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HasilKarya  $hasilKarya
     * @return \Illuminate\Http\Response
     */
    public function edit(HasilKarya $hasilKarya)
    {
        $hasilKarya = HasilKarya::all()->firstWhere('slug', $hasilKarya->slug);

        return view('admin.hasil_karya.edit', compact('hasilKarya'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HasilKarya  $hasilKarya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HasilKarya $hasilKarya)
    {
        $request->validate([
            'judul' => 'required',
            'teks' => 'required',
            'release_date' => 'required'
        ]);

        if ($request->thumbnail != "") {
            $path_url = 'images/hasil_karya/';

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

            if (File::exists(public_path($request->old_thumbnail))) {
                File::delete(public_path($request->old_thumbnail));
            }

            HasilKarya::where('id', $hasilKarya->id)
                ->update([
                    'judul' => $request->judul,
                    'thumbnail' => $path_url . $fileName,
                    'teks' => $request->teks,
                    'release_date' => $request->release_date
                ]);
        } else {
            HasilKarya::where('id', $hasilKarya->id)
                ->update([
                    'judul' => $request->judul,
                    'teks' => $request->teks,
                    'release_date' => $request->release_date
                ]);
        }

        return redirect(route('hasil_karya.index'))->with('status', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HasilKarya  $hasilKarya
     * @return \Illuminate\Http\Response
     */
    public function destroy(HasilKarya $hasilKarya)
    {
        HasilKarya::destroy($hasilKarya->id);

        return redirect()->route('hasil_karya.index')->with('status', 'Data Berhasil Dihapus');
    }

    public function restore($id)
    {
        HasilKarya::withTrashed()->where('id', $id)->restore();

        return redirect()->route('hasil_karya.index')->with('status', 'Data Berhasil Dikembalikan');
    }

    public function deletePermanen(Request $request, $id)
    {
        if (File::exists(public_path($request->thumbnail))) {
            File::delete(public_path($request->thumbnail));
        }

        HasilKarya::withTrashed()->where('id', $id)->forceDelete();

        return redirect()->route('hasil_karya.index')->with('status', 'Data Terhapus Permanen!');
    }

    public function menuHasilKarya()
    {
        $hasilKaryas = HasilKarya::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.hasil_karya.index',  compact('hasilKaryas', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuHasilKaryaDetail($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $hasilKarya = HasilKarya::where('slug', 'hasil_karya/' . $slug)
            ->firstOrFail();

        $hasilKaryas = HasilKarya::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'hasil_karya/' . $slug)
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
        
        return view('portal.hasil_karya.show', compact('hasilKarya', 'kontak', 'hasilKaryas', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'laboratoriumHeaders'));
    }
}
