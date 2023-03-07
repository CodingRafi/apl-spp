<?php

namespace App\Http\Controllers;

use Auth, DB;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(Request $request){ 
        if (\Auth::user()->hasRole('super_admin')) {
            $roles = Role::all();
            $sekolah = Sekolah::all();
            $tahun_ajarans = TahunAjaran::all();
            $countRole = Role::all()->count() - 1;
            $countSekolah = Sekolah::all()->count();
            $countTahunAjaran = TahunAjaran::all()->count();

            return view('dashboard', [
                'roles' => $roles,
                'sekolah' => $sekolah,
                'tahun_ajarans' => $tahun_ajarans,
                'countRole' => $countRole,
                'countSekolah' => $countSekolah,
                'countTahunAjaran' => $countTahunAjaran
            ]);

        }else {
            $tahun_ajaran = TahunAjaran::getTahunAjaran($request);
            $return = [];


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
