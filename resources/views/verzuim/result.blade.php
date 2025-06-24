@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-black dark:text-white">
    <h2 class="text-xl font-bold mb-4">Gemiddelde verzuim voor klas: {{ $klas }}</h2>
    <div class="text-lg">
        Gemiddelde verzuim: <span class="font-semibold">{{ number_format($gemiddelde, 1, ',', '.') }}%</span>
    </div>
    <a href="{{ route('verzuim.upload.form') }}" class="inline-block mt-4 text-blue-600 underline">Opnieuw uploaden</a>
</div>
@endsection
