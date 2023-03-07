<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use App\Http\Requests\StoreSekolahRequest;
use App\Http\Requests\UpdateSekolahRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:view_sekolah', ['only' => ['index','show']]);
         $this->middleware('permission:add_sekolah', ['only' => ['create','store']]);
         $this->middleware('permission:edit_sekolah', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_sekolah', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = Sekolah::all();

        return view('sekolah.index', [
            'schools' => $schools
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSekolahRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function show(Sekolah $sekolah)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit(Sekolah $sekolah)
    {
       abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSekolahRequest  $request
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSekolahRequest $request, Sekolah $sekolah)
    {
        $data =[
            'nama' => $request->nama,
            'npsn' => $request->npsn,
            'kepala_sekolah' => $request->kepala_sekolah,
            'alamat' => $request->alamat,
        ];

        if ($request->logo) {
            if ($sekolah->logo != '/img/tutwuri.png	') {
                Storage::delete($sekolah->logo);
            }
            $data += ['logo' => $request->file('logo')->store('logo')];
        }

        dd($data);

        $sekolah->update($data);

        return redirect('/dashboard')->with('msg_success', 'Berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sekolah $sekolah)
    {
        foreach ($sekolah->user as $key => $user) {
            User::deleteUser($user->getRoleNames()[0], $user->id);
        }

        foreach ($sekolah->kelas as $key => $kelas) {
            $kelas->delete();
        }

        foreach ($sekolah->kompetensi as $key => $kompetensi) {
            $kompetensi->delete();
        }

        $sekolah->tingkat()->sync([]);
        $sekolah->spp()->sync([]);

        $sekolah->delete();

        return redirect()->back()->with('msg_success', 'Sekolah berhasil dihapus');
    }
}
