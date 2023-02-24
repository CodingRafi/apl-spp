<form action="{{ (isset($data)) ? route('spp.update', [$data->id]) : route('spp.store') }}" method="POST">
    @csrf
    @if(isset($data))
    @method('patch')
    @endif
    @include('mypartials.tahunajaran')
    <div class="mb-3">
        <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
        <select class="form-select @error('tahun_ajaran_id') is-invalid @enderror" name="tahun_ajaran_id" id="tahun_ajaran_id">
            <option selected>Pilih Tahun Ajaran</option>
            @foreach ($tahun_ajarans as $tahun_ajaran)
            <option value="{{ $tahun_ajaran->id }}" {{ isset($data) ? ($data->tahun_ajaran_id == $tahun_ajaran->id ? 'selected' : '') : '' }}>{{ $tahun_ajaran->tahun_awal }}-{{ $tahun_ajaran->tahun_akhir }}</option>
            @endforeach
          </select>
        @error('tahun_ajaran_id')
            <div class="invalid-feedback">
                {{ $message }}  
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="nominal" class="form-label">Nominal</label>
        <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ isset($data) ? $data->nominal : old('nominal') }}" style=" font-size: 15px; height: 6.5vh;">
        @error('nominal')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>