{{-- <a href="{{ $route }}{{ (request('tahun_awal') || request('tahun_akhir') ? '?' : '') }}{{ (request('tahun_awal') ?? '') }}{{ request('tahun_awal') && request('tahun_akhir') ? '&' : '' }}{{ (request('tahun_akhir') ?? '') }}" {{ $attributes->merge([
    'class' => '',
]) }}>
    {{ $slot }}
</a> --}}


<form action="{{ $route }}" method="GET">
    @include('mypartials.tahunajaran')
    <button type="submit" {{ $attributes->merge(['class' => '']) }}>{{ $slot }}</button>
</form>