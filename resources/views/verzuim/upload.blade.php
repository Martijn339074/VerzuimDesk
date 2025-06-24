@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-black dark:text-white">
    <h2 class="text-xl font-bold mb-4">Upload verzuimbestand (Excel)</h2>
    <form action="{{ route('verzuim.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="file" name="verzuimbestand" accept=".xlsx,.xls" required class="block">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Uploaden</button>
    </form>
    @if ($errors->any())
        <div class="mt-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
