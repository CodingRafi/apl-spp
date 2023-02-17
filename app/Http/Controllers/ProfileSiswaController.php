<?php

namespace App\Http\Controllers;

use App\Models\profile_siswa;
use App\Http\Requests\Storeprofile_siswaRequest;
use App\Http\Requests\Updateprofile_siswaRequest;

class ProfileSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storeprofile_siswaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeprofile_siswaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\profile_siswa  $profile_siswa
     * @return \Illuminate\Http\Response
     */
    public function show(profile_siswa $profile_siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\profile_siswa  $profile_siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(profile_siswa $profile_siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateprofile_siswaRequest  $request
     * @param  \App\Models\profile_siswa  $profile_siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Updateprofile_siswaRequest $request, profile_siswa $profile_siswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\profile_siswa  $profile_siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(profile_siswa $profile_siswa)
    {
        //
    }
}
