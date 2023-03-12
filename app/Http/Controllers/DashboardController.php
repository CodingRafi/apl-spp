<?php

namespace App\Http\Controllers;

use Auth, DB;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\ref_agama;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request){ 
        if (\Auth::user()->hasRole('super_admin')) {
            $countRole = Role::count() - 1;
            $countAgama = ref_agama::count();
            $countTahunAjaran = TahunAjaran::count();

            return view('dashboard', [
                'countRole' => $countRole,
                'countAgama' => $countAgama,
                'countTahunAjaran' => $countTahunAjaran
            ]);

        }else {
            $tahun_ajaran = TahunAjaran::getTahunAjaran($request);
            $return = [];

            if (Auth::user()->hasRole('siswa')) {
                $now = Carbon::now();
                $now_month = (int) Carbon::parse($now)->translatedFormat('m');
                $check = DB::table('t_pembayarans')->where('t_pembayarans.siswa_id', Auth::user()->id)
                                                    ->where('t_pembayarans.tahun_ajaran_id', $tahun_ajaran->id)
                                                    ->where('t_pembayarans.bulan', $now_month)
                                                    ->first();

                $return['status'] = ($check) ? false : ((int) Carbon::parse($now)->translatedFormat('d') > (int) config('services.tenggat') ? true : false);
            }

            return view('dashboard', $return);
        }
    }

    private function parseData($datas){
        $result = [
            'key' => [],
            'data' => []
        ];
        foreach ($datas as $key => $data) {
            array_push($result['key'], ucfirst($data->key));
            array_push($result['data'], $data->jml);
        }
        return $result;
    }
}
