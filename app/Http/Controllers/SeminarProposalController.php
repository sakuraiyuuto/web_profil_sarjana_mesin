<?php

namespace App\Http\Controllers;

use App\Models\SeminarProposal;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $seminarProposal = SeminarProposal::all()->first();

        return view('admin.seminar_proposal.index', compact('seminarProposal', 'session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, SeminarProposal $seminarProposal)
    {
        $this->validate($request, [
            'id'     => 'required',
            'teks'     => 'required'
        ]);

        $seminarProposal = SeminarProposal::all()
            ->where('id', $request->id)
            ->first();

        if ($request->nama_file == "") {
            $fileName = $seminarProposal->nama_file;

            SeminarProposal::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                    'nama_file' => $fileName,
                ]);
            return redirect('/admin/seminar_proposal')->with('status', 'Seminar Proposal Berhasil Diubah');
        } else {
            $file = $seminarProposal->nama_file;
            if (file_exists($file)) {
                @unlink($file);
            }

            $path_url = 'files/seminar_proposal/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            SeminarProposal::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                    'nama_file' => 'files/seminar_proposal/' . $fileName,
                ]);
            return redirect('/admin/seminar_proposal')->with('status', 'Seminar Proposal Berhasil Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeminarProposal  $seminarProposal
     * @return \Illuminate\Http\Response
     */

    public function menuSeminarProposal()
    {
        $seminarProposal = SeminarProposal::all()
            ->first();

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

        return view('portal.seminar_proposal.index',  compact('seminarProposal', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
