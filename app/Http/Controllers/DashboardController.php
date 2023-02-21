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

            if (auth()->user()->can('view_users')) {
                //! Data User 
                $users = [
                    'key' => [],
                    'data' => []
                ];
    
                $roles = Role::select('roles.name')
                                ->where('roles.name', '!=', 'super_admin')
                                ->where('roles.name', '!=', 'admin')
                                ->get();
    
                foreach ($roles as $key => $role) {
                    $count = User::role($role->name)
                    ->where('sekolah_id', Auth::user()->sekolah_id)
                    ->when($role == 'siswa', function($q) use($tahun_ajaran, $role) {
                        $q->join('profile_siswas', 'profile_siswas.user_id', 'users.id')
                            ->where('profile_siswas.tahun_ajaran_id', $tahun_ajaran->id);
                    })
                    ->count();
    
                    array_push($users['key'], ucfirst($role->name));
                    array_push($users['data'], $count);
                }

                $return += [
                    'users' => $users,
                ];
            }

            if (auth()->user()->can('view_kompetensi')) {
                //! Kompetensi
                $kompetensis = $this->parseData(DB::table('kompetensis')
                                ->select(DB::raw('count(profile_siswas.id) as jml'), 'kompetensis.kompetensi as key')
                                ->join('profile_siswas', 'profile_siswas.kompetensi_id', 'kompetensis.id')
                                ->join('users', 'users.id', 'profile_siswas.user_id')
                                ->where('users.sekolah_id', Auth::user()->sekolah_id)
                                ->groupBy('kompetensis.id')
                                ->get()->toArray());

                $return += ['kompetensis' => $kompetensis];
            }

            if (auth()->user()->can('view_kelas')) {
                //! Kelas
                // $kelas = $this->parseData(DB::table('kelas')
                //         ->select(DB::raw('count(profile_siswas.id) as jml'), 'kelas.nama as key')
                //         ->join('profile_siswas', 'profile_siswas.kelas_id', 'kelas.id')
                //         ->join('users', 'users.id', 'profile_siswas.user_id')
                //         ->where('users.sekolah_id', Auth::user()->sekolah_id)
                //         ->groupBy('kelas.id')
                //         ->get()->toArray());
                $kelas = [
                    'key' => [],
                    'data' => []
                ];

                $return += ['kelas' => $kelas];
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
