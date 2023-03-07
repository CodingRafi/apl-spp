<?php

namespace App\Http\Controllers;

use App\Models\{
    m_spp,
    TahunAjaran,
    Sekolah
};
use Illuminate\Http\Request;
use Auth, DB;
use Illuminate\Database\Eloquent\Builder;

class SppController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:view_spp|add_spp|edit_spp|delete_spp', ['only' => ['index','show']]);
         $this->middleware('permission:add_spp', ['only' => ['create','store']]);
         $this->middleware('permission:edit_spp', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_spp', ['only' => ['destroy']]);
    }

    private function get_tahun_ajaran($data = null){
        return $tahun_ajarans = TahunAjaran::select('tahun_ajarans.*')
                ->leftJoin('m_spps', 'm_spps.tahun_ajaran_id', 'tahun_ajarans.id')
                ->whereDoesntHave('spp', function(Builder $query){
                    $query->where('m_spps.sekolah_id', Auth::user()->sekolah->id);
                })
                ->when($data, function($q) use($data){
                    $q->orWhere('m_spps.sekolah_id', Auth::user()->sekolah_id);
                })
                ->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('spp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahun_ajarans = $this->get_tahun_ajaran();  
        return view('spp.create', compact('tahun_ajarans'));
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
            'tahun_ajaran_id' => 'required',
            'nominal' => 'required'
        ]);

        m_spp::create([
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'nominal' => $request->nominal,
            'sekolah_id' => Auth::user()->sekolah->id,
        ]);
        return TahunAjaran::redirectWithTahunAjaran('spp.index', $request, 'Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\m_spp  $m_spp
     * @return \Illuminate\Http\Response
     */
    public function show(m_spp $m_spp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\m_spp  $m_spp
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = m_spp::where('id', $id)->where('sekolah_id', Auth::user()->sekolah_id)->first();
        if ($data) {
            $tahun_ajarans = $this->get_tahun_ajaran($data);
            return view('spp.update', compact('data', 'tahun_ajarans'));
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\m_spp  $m_spp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'tahun_ajaran_id' => 'required',
            'nominal' => 'required'
        ]);

        $data = m_spp::where('id', $id)->where('sekolah_id', Auth::user()->sekolah_id)->first();
        if ($data) {
            $data->update($request->all());
            return redirect()->route('spp.index')->with('msg_success', 'Berhasil diubah!');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\m_spp  $m_spp
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = m_spp::findOrFail($id);
        foreach ($data->user as $key => $user) {
            $user->update([
                'spp_id' => null
            ]);
        }
        $data->delete();
        return redirect()->back()->with('msg_success', 'Berhasil dihapus');
    }
}
