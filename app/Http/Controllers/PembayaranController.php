<?php

namespace App\Http\Controllers;

use DB, Hash, Auth, PDF;
use App\Models\{
    User,
    TahunAjaran,
    t_pembayaran,
    Kelas
};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PembayaranExportAll;
use App\Exports\PembayaranExport;
use Illuminate\Validation\ValidationException;

class PembayaranController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:view_pembayaran', ['only' => ['index','show']]);
         $this->middleware('permission:add_pembayaran', ['only' => ['create','store']]);
         $this->middleware('permission:delete_pembayaran', ['only' => ['destroy']]);
         $this->middleware('permission:export_pembayaran', ['only' => ['export']]);
    }
    
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('siswa')) {
            $users = User::findUser($request, 'siswa', Auth::user()->id);
            // dd($users);
        }else{
            $users = User::getUser($request, 'siswa', false, true);
        }
        $data = ['users' => $users];
        $tahun_ajaran = TahunAjaran::getTahunAjaran($request);
        if (check_jenjang()) {
            $data += ['kompetensis' => DB::table('kompetensis')->where('sekolah_id', Auth::user()->sekolah_id)->get()];
        }
        $data += ['kelas' => Kelas::getKelas($request)];

        return view('pembayaran.index', $data);
    }

    public function create(Request $request, $id)
    {
        $user = User::findUser($request, 'siswa', $id);
        if ($user) {
            $bulans = [];
            $tahun_ajaran = TahunAjaran::getTahunAjaran($request);
            $check_bulan = t_pembayaran::select('t_pembayarans.bulan')
                                    ->where('tahun_ajaran_id', $tahun_ajaran->id)
                                    ->where('siswa_id', $id)
                                    ->get()->toArray();

            foreach (config('services.bulan') as $key => $bulan) {
                if (!in_array($key+1, array_column($check_bulan, 'bulan'))) {
                    $bulans[$key+1] = $bulan;
                }
            }

            return view('pembayaran.create', compact('bulans', 'user'));
        }else{
            abort(403);
        }
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'bulan' => 'required'
        ]);

        if (!$request->nominal) {
            return redirect()->back()->with('msg_error', 'Tidak ada nominal');
        }

        $tahun_ajaran = TahunAjaran::getTahunAjaran($request);

        foreach ($request->bulan as $key => $bulan) {
            t_pembayaran::create([
                'tahun_ajaran_id' => $tahun_ajaran->id,
                'siswa_id' => $id,
                'bulan' => $bulan,
                'petugas_id' => Auth::user()->id
            ]);
        }

        return TahunAjaran::redirectWithTahunAjaranManual(route('pembayaran.show', $id), $request, 'Berhasil disimpan');
    }

    public function show(Request $request, $id)
    {
        $user = User::findUser($request, 'siswa', $id);
        if ($user) {
            $pembayarans = t_pembayaran::get_pembayaran($request, $id);
            return view('pembayaran.show', compact('user', 'pembayarans'));
        }else{
            abort(403);
        }
    }

    public function destroy(Request $request, $pembayaran_id, $user_id)
    {
        $data = t_pembayaran::where('id', $pembayaran_id)->where('siswa_id', $user_id)->first();
        if ($data) {
            $data->delete();
            return TahunAjaran::redirectWithTahunAjaranManual(route('pembayaran.show', $user_id), $request, 'Berhasil dihapus');
        } else {
            abort(403);
        }   
    }

    public function export(Request $request, $user_id){
        $user = User::findUser($request, 'siswa', $user_id);
        if ($user) {
            $pembayarans = t_pembayaran::get_pembayaran($request, $user_id);
            return Pdf::loadView('pembayaran.export', compact('user', 'pembayarans'))->stream();
        }else{
            abort(403);
        }
    }

    public function export_all(Request $request){
        return Excel::download(new PembayaranExportAll($request), 'pembayaran.xlsx');
    }
}
