@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-black dark:text-white">
    <h2 class="text-xl font-bold mb-4">Selecteer een klas</h2>
    <form action="{{ route('verzuim.gemiddelde') }}" method="POST" class="space-y-4">
        @csrf
        <select name="klas" required class="block border rounded p-2">
            <option value="">-- Kies een klas --</option>
            @foreach ($klassen as $klas)
                <option value="{{ $klas }}">{{ $klas }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Toon gemiddelde verzuim</button>
    </form>
</div>
@endsection
