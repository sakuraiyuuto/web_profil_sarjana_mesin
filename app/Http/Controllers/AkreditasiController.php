<?php

namespace App\Http\Controllers;

use App\Models\Akreditasi;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use App\Models\AkreditasiText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AkreditasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $akreditasis = Akreditasi::withTrashed()->get()->sortByDesc('id');
        $akreditasiText = AkreditasiText::all()->first();

        return view('admin.akreditasi.index', compact('akreditasis', 'session_user', 'akreditasiText'));
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
            'nama_file' => 'required',
        ]);

        $path_url = 'files/akreditasi/';

        $originName = $request->nama_file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $request->nama_file->getClientOriginalExtension();
        $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
        $request->nama_file->move(public_path($path_url), $fileName);

        Akreditasi::create(
            [
                'judul' => $request->judul,
                'nama_file' => $path_url . $fileName,
                'release_date' => $request->release_date,
            ]
        );

        return redirect('/admin/akreditasi')->with('status', 'Data Berhasil Ditambah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Akreditasi  $akreditasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Akreditasi $akreditasi)
    {

        $request->validate([
            'judul' => 'required',
            'release_date' => 'required'
        ]);

        if ($request->nama_file != "") {
            $path_url = 'files/akreditasi/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            if (File::exists(public_path($request->old_file))) {
                File::delete(public_path($request->old_file));
            }

            Akreditasi::where('id', $request->id)
                ->update([
                    'judul' => $request->judul,
                    'nama_file' => $path_url . $fileName,
                    'release_date' => $request->release_date,
                ]);
        } else {
            Akreditasi::where('id', $request->id)
                ->update([
                    'judul' => $request->judul,
                    'release_date' => $request->release_date,
                ]);
        }

        return redirect('/admin/akreditasi')->with('status', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Akreditasi  $akreditasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Akreditasi $akreditasi)
    {
        Akreditasi::destroy($akreditasi->id);

        return redirect('/admin/akreditasi')->with('status', 'Data Berhasil Dihapus');
    }

    public function restore($id)
    {
        Akreditasi::withTrashed()->where('id', $id)->restore();

        return redirect('/admin/akreditasi')->with('status', 'Data Akreditasi Berhasil Dikembalikan!');
    }

    public function deletePermanen(Request $request, $id)
    {
        if (File::exists(public_path($request->nama_file))) {
            File::delete(public_path($request->nama_file));
        }

        Akreditasi::withTrashed()->where('id', $id)->forceDelete();

        return redirect()->route('akreditasi.index')->with('status', 'Data Akreditasi Terhapus Permanen');
    }

    public function menuAkreditasi()
    {
        $akreditasis = Akreditasi::where('release_date', '<=', date('Y-m-d'))
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

        $akreditasiText = AkreditasiText::all()->first();

        return view('portal.akreditasi.index',  compact('akreditasis', 'akreditasiText','himpunanMahasiswaHeaders', 'kontak', 'informasiTerbarus', 'aplikasiIntegrasis', 'linkProdis', 'profilSingkat', 'laboratoriumHeaders'));
    }

    public function updateAkreditasiText(Request $request, AkreditasiText $akreditasiText)
    {
        $this->validate($request, [
            'teks'     => 'required'
        ]);

        AkreditasiText::where('id', $request->id)
            ->update([
                'teks' => $request->teks
            ]);

        return redirect('/admin/akreditasi')->with('status', 'Akreditasi Teks Berhasil Diubah!');
    }
}
