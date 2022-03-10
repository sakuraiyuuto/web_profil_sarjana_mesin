<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\JadwalSeminarProposal;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class JadwalSeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $jadwalSeminarProposals = JadwalSeminarProposal::withTrashed()->get()
            ->sortDesc();
        return view('admin.jadwal_seminar_proposal.index', compact('jadwalSeminarProposals', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/jadwal_seminar_proposal.create', compact('session_user'));
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
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'nama_file' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jadwal_seminar_proposal')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'files/jadwal_seminar_proposal/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

            JadwalSeminarProposal::create([
                'nama_file' => 'files/jadwal_seminar_proposal/' . $fileName,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'slug' => 'jadwal_seminar_proposal/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/jadwal_seminar_proposal')->with('status', 'Dokumen Prodi Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalSeminarProposal  $jadwalSeminarProposals
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalSeminarProposal $jadwalSeminarProposals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalSeminarProposal  $jadwalSeminarProposals
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalSeminarProposal $jadwalSeminarProposal)
    {
        $session_user = Auth::user();
        $jadwalSeminarProposal = JadwalSeminarProposal::all()->firstWhere('slug', $jadwalSeminarProposal->slug);

        return view('admin.jadwal_seminar_proposal.edit', compact('jadwalSeminarProposal', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalSeminarProposal  $jadwalSeminarProposals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jadwal_seminar_proposal')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $jadwalSeminarProposals = JadwalSeminarProposal::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $jadwalSeminarProposals->nama_file;

                $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

                JadwalSeminarProposal::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'slug' => 'jadwal_seminar_proposal/' . $slug,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/jadwal_seminar_proposal')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $file = $jadwalSeminarProposals->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/jadwal_seminar_proposal/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                $slug = 'jadwal-kuliah-semester-' . Str::slug($request->semester) . '-' . Str::slug($request->tahun_ajaran) . time();

                JadwalSeminarProposal::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/jadwal_seminar_proposal/' . $fileName,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'slug' => 'jadwal_seminar_proposal/' . $slug,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/jadwal_seminar_proposal')->with('status', 'Dokumen Prodi Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalSeminarProposal  $jadwalSeminarProposals
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JadwalSeminarProposal::destroy($id);
        return redirect('/admin/jadwal_seminar_proposal')->with('status', 'Dokumen Prodi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $jadwalSeminarProposal = JadwalSeminarProposal::withTrashed()
            ->where('id', $id)
            ->first();

        $jadwalSeminarProposal->restore();
        return redirect('/admin/jadwal_seminar_proposal')->with('status', 'Dokumen Prodi Berhasil Direstore');
    }

    public function delete($id)
    {
        $jadwalSeminarProposal = JadwalSeminarProposal::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $jadwalSeminarProposal->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $jadwalSeminarProposal->forceDelete();
        return redirect('/admin/jadwal_seminar_proposal')->with('status', 'Dokumen Prodi Berhasil Dihapus Permanen');
    }

    public function menuJadwalSeminarProposal()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalSeminarProposals = JadwalSeminarProposal::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.jadwal_seminar_proposal.index',  compact('jadwalSeminarProposals', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailJadwalSeminarProposal($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jadwalSeminarProposal = JadwalSeminarProposal::all()
            ->where('slug', 'jadwal_seminar_proposal/' . $slug)
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

        return view('portal.jadwal_seminar_proposal.detail',  compact('jadwalSeminarProposal', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
