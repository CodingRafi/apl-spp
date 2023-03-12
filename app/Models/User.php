<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function sekolah(){
        return $this->belongsTo(Sekolah::class);
    }

    public function kelas(){
        return $this->belongsToMany(Kelas::class, 'user_kelas');
    }

    public function ref_agama(){
        return $this->belongsTo(ref_agama::class);
    }

    public function profile_user(){
        return $this->hasOne(profile_user::class, 'user_id');
    }

    public function profile_siswa(){
        return $this->hasOne(profile_siswa::class, 'user_id');
    }

    private static function parseDataToArray($datas){
        $return = [];

        foreach ($datas as $key => $data) {
            array_push($return, $data->id);
        }

        return $return;
    }

    public function scopeFilterUser($query, array $filter){
        $query->when($filter['search'] ?? false, function($query, $filter){
            return $query->where('profile_users.name', 'like', '%' . $filter . '%')
                        ->orWhere('users.email', 'like', '%' . $filter . '%')
                        ->orWhere('users.nip', 'like', '%' . $filter . '%');
        });
    }

    public function scopeFilterSiswa($query, array $filter){
        $query->when($filter['search'] ?? false, function($query, $filter){
            return $query->where('profile_siswas.name', 'like', '%' . $filter . '%');
        });

        $query->when($filter['kelas'] ?? false, function($query, $filter){
            return $query->where('kelas.id', $filter);
        });

        $query->when($filter['jurusan'] ?? false, function($query, $filter){
            return $query->where('kompetensis.id', $filter);
        });
    }

    public static function getUser($request, $role, $detail = false, $paginate = false, $filter = ['search' => '', 'kelas' => '', 'kompetensi' => '']){
        $tahun_ajaran = TahunAjaran::getTahunAjaran($request);
        if ($tahun_ajaran) {
            $users = User::when($role == 'siswa', function($q) use($role, $request, $tahun_ajaran, $detail, $filter){
                        $q->join('profile_siswas', 'profile_siswas.user_id', 'users.id')
                            ->join('user_kelas', 'user_kelas.user_id', 'users.id')
                            ->leftJoin('kelas', 'user_kelas.kelas_id', 'kelas.id')
                            ->when($detail, function($query) use ($detail){
                                $query->select('users.email', 'users.profil', 'users.nipd', 'profile_siswas.nisn', 'profile_siswas.nik','profile_siswas.jk', 'profile_siswas.jalan', 'profile_siswas.name', 'profile_siswas.tempat_lahir', 'profile_siswas.tanggal_lahir', 'ref_provinsis.nama as provinsi', 'ref_kabupatens.nama as kabupaten', 'ref_kecamatans.nama as kecamatan', 'ref_kelurahans.nama as kelurahan', 'ref_agamas.nama as agama', 'kelas.nama as kelas', 'kompetensis.kompetensi', 'users.id', 'users.id','m_spps.nominal', 'ref_tingkats.romawi')
                                ->join('ref_agamas', 'profile_siswas.ref_agama_id', 'ref_agamas.id')
                                ->join('ref_tingkats', 'ref_tingkats.id', 'kelas.ref_tingkat_id')
                                ->join('ref_provinsis', 'profile_siswas.ref_provinsi_id', 'ref_provinsis.id')
                                ->join('ref_kabupatens', 'profile_siswas.ref_kabupaten_id', 'ref_kabupatens.id')
                                ->join('ref_kecamatans', 'profile_siswas.ref_kecamatan_id', 'ref_kecamatans.id')
                                ->join('ref_kelurahans', 'profile_siswas.ref_kelurahan_id', 'ref_kelurahans.id')
                                ->leftJoin('m_spps', 'm_spps.id', 'profile_siswas.spp_id');
                            })
                            ->when(!$detail, function($qu) use($detail){
                                $qu->select('users.*');
                            })
                            ->leftJoin('kompetensis', 'profile_siswas.kompetensi_id', 'kompetensis.id')
                            ->where('user_kelas.tahun_ajaran_id', $tahun_ajaran->id)
                            ->filterSiswa($filter);
                    })
                    ->when($role != 'siswa', function($q) use($role, $detail, $filter){
                        $q->join('profile_users', 'profile_users.user_id', 'users.id')
                            ->when($detail, function($query) use ($detail){
                                $query->select('users.email', 'users.profil', 'users.nip','profile_users.jk', 'profile_users.tempat_lahir', 'profile_users.tanggal_lahir', 'profile_users.jalan', 'profile_users.name', 'ref_provinsis.nama as provinsi', 'ref_kabupatens.nama as kabupaten', 'ref_kecamatans.nama as kecamatan', 'ref_kelurahans.nama as kelurahan', 'ref_agamas.nama as agama')
                                ->join('ref_agamas', 'profile_users.ref_agama_id', 'ref_agamas.id')
                                ->join('ref_provinsis', 'profile_users.ref_provinsi_id', 'ref_provinsis.id')
                                ->join('ref_kabupatens', 'profile_users.ref_kabupaten_id', 'ref_kabupatens.id')
                                ->join('ref_kecamatans', 'profile_users.ref_kecamatan_id', 'ref_kecamatans.id')
                                ->join('ref_kelurahans', 'profile_users.ref_kelurahan_id', 'ref_kelurahans.id');
                            })
                            ->when(!$detail, function($qu) use($detail){
                                $qu->select('users.*');
                            })
                            ->filterUser($filter);
                    })
                    ->role($role) 
                    ->where('users.sekolah_id', \Auth::user()->sekolah_id);
        }else{
            $users = User::query()->role('siswa');
        }

        if ($paginate) {
            $users = $users->paginate(25)->withQueryString();
        } else {
            $users = $users->get();
        }
                
        return $users;
    }

    public static function findUser($request, $role, $id){
        $tahun_ajaran = TahunAjaran::getTahunAjaran($request);
        $user = User::when($role == 'siswa', function ($q) use($role, $tahun_ajaran) {
                            return $q->select('users.id as user_id', 'users.email', 'users.profil', 'users.nipd', 'profile_siswas.nisn', 'profile_siswas.nik','profile_siswas.jk', 'profile_siswas.jalan', 'profile_siswas.name', 'profile_siswas.tempat_lahir', 'profile_siswas.tanggal_lahir', 'ref_provinsis.nama as provinsi', 'ref_provinsis.id as ref_provinsi_id', 'ref_kabupatens.nama as kabupaten', 'ref_kabupatens.id as ref_kabupaten_id', 'ref_kecamatans.nama as kecamatan', 'ref_kecamatans.id as ref_kecamatan_id', 'ref_kelurahans.nama as kelurahan', 'ref_kelurahans.id as ref_kelurahan_id', 'ref_agamas.nama as agama', 'ref_agamas.id as ref_agama_id', 'kelas.nama as kelas', 'kelas.id as kelas_id', 'kompetensis.kompetensi', 'kompetensis.id as kompetensi_id', 'ref_tingkats.romawi', 'm_spps.id as spp_id', 'm_spps.nominal')
                                    ->join('profile_siswas', 'profile_siswas.user_id', 'users.id')
                                    ->join('user_kelas', 'user_kelas.user_id', 'users.id')
                                    ->join('kelas', 'user_kelas.kelas_id', 'kelas.id')
                                    ->join('ref_tingkats', 'ref_tingkats.id', 'kelas.ref_tingkat_id')
                                    ->leftJoin('kompetensis', 'profile_siswas.kompetensi_id', 'kompetensis.id')
                                    ->leftJoin('ref_agamas', 'profile_siswas.ref_agama_id', 'ref_agamas.id')
                                    ->join('ref_provinsis', 'profile_siswas.ref_provinsi_id', 'ref_provinsis.id')
                                    ->join('ref_kabupatens', 'profile_siswas.ref_kabupaten_id', 'ref_kabupatens.id')
                                    ->join('ref_kecamatans', 'profile_siswas.ref_kecamatan_id', 'ref_kecamatans.id')
                                    ->join('ref_kelurahans', 'profile_siswas.ref_kelurahan_id', 'ref_kelurahans.id')
                                    ->leftJoin('m_spps', 'm_spps.id', 'profile_siswas.spp_id')
                                    ->where('user_kelas.tahun_ajaran_id', $tahun_ajaran->id);
                        })->when($role != 'siswa', function($q) use($role){
                            return $q->select('users.id as user_id', 'users.email', 'users.profil', 'users.nip', 'profile_users.*','profile_users.jk', 'profile_users.tempat_lahir', 'profile_users.tanggal_lahir', 'profile_users.jalan', 'profile_users.name', 'ref_provinsis.nama as provinsi', 'ref_provinsis.id as ref_provinsi_id', 'ref_kabupatens.nama as kabupaten', 'ref_kabupatens.id as ref_kabupaten_id', 'ref_kecamatans.nama as kecamatan', 'ref_kecamatans.id as ref_kecamatan_id', 'ref_kelurahans.nama as kelurahan', 'ref_kelurahans.id as ref_kelurahan_id', 'ref_agamas.nama as agama', 'ref_agamas.id as ref_agama_id')
                                    ->join('profile_users', 'profile_users.user_id', 'users.id')
                                    ->join('ref_agamas', 'profile_users.ref_agama_id', 'ref_agamas.id')
                                    ->join('ref_provinsis', 'profile_users.ref_provinsi_id', 'ref_provinsis.id')
                                    ->join('ref_kabupatens', 'profile_users.ref_kabupaten_id', 'ref_kabupatens.id')
                                    ->join('ref_kecamatans', 'profile_users.ref_kecamatan_id', 'ref_kecamatans.id')
                                    ->join('ref_kelurahans', 'profile_users.ref_kelurahan_id', 'ref_kelurahans.id');
                        })
                        ->where('users.id', $id)
                        ->role($role) 
                        ->where('users.sekolah_id', \Auth::user()->sekolah_id)
                        ->first();

        return $user;
    }

    public static function deleteUser($role, $id){
        $user = User::findOrFail($id);
        if ($role == 'siswa') {
            foreach ($user->pembayaran as $key => $pembayaran) {
                $pembayaran->delete();
            }

            foreach ($user->kelas as $key => $kelas) {
                $kelas->users()->detach($user->id);
            }

            if ($user->profile_siswa) {
                $user->profile_siswa->delete();
            }
        } else {
            foreach ($user->petugas as $key => $pembayaran) {
                $pembayaran->update([
                    'petugas_id' => null
                ]);
            }

            $user->profile_user->delete();
        }

        $user->delete();
    }

    public function pembayaran(){
        return $this->hasMany(t_pembayaran::class, 'siswa_id');
    }

    public function petugas(){
        return $this->hasMany(t_pembayaran::class, 'petugas_id');
    }

    public function spp(){
        return $this->belongsTo(m_spp::class, 'spp_id');
    }
}
