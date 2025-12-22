@extends('layouts.basic')
@section('header')
    <x-header></x-header>
@endsection
@section('body')
    <div class="min-h-screen w-screen flex flex-col justify-center items-center">

        <h2 class="text-2xl md:text-3xl mb-4 mt-32 text-center text-gray-800">Meet Our Alumni</h2>

        <div class="text-center mb-8">
            <a href="{{ route('alumni.create') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-full transition duration-300 shadow-lg">
                🎓 Join as Alumni
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-6 w-4/5 md:w-3/4 mx-auto">
            @forelse($alumni->sortBy('session') as $alum)
                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition-shadow duration-300 hover:scale-105 transform p-4 group">
                    @if ($alum->photo)
                        <img src="{{ asset('storage/' . $alum->photo) }}" alt="{{ $alum->name }}"
                            class="w-16 h-16 sm:w-24 sm:h-24 object-cover rounded-full mb-4 shadow-sm">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-xl mb-4 text-gray-500">
                            No Image
                        </div>
                    @endif

                    <h3 class="font-semibold text-gray-800">
                        {{ $alum->name }}
                        <span class="ml-2 font-normal">({{ $alum->session }})</span>
                    </h3>
                    <p class="text-gray-500 text-sm"> <i class="bi-telephone"></i> {{ $alum->phone }}</p>
                    <p class="text-sm text-gray-600 mt-2">
                        @if (strlen($alum->introduction) > 50)
                            {{ substr($alum->introduction, 0, 50) }}...
                        @else
                            {{ $alum->introduction }}
                        @endif
                    </p>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">No alumni profiles yet. Be the first to join!</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $alumni->links() }}
        </div>
    </div>
@endsection
