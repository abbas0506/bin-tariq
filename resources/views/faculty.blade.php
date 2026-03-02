@extends('layouts.basic')

@section('header')
    <x-header></x-header>
@endsection
@section('body')
    <div class="text-gray-800 font-sans px-5 md:px-24 mt-16">
        <!-- Hero Section -->
        <section class="relative">
            <div class="md:w-3/4 text-center mx-auto px-4 py-20">
                <h1 class="text-xl  md:text-4xl font-bold text-teal-700 mb-6">
                    Highly Skilled <span class="text-slate-600">Faculty</span>
                </h1>
                <p class="text-sm md:text-lg leading-relaxed text-gray-700">
                    We have highly skilled faculty who known the necessities and age dependant social and mental
                    requirements of your kids.
                    We follow activity based teaching method as it is an accepted concept of modern education.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-4/5 md:w-3/4 mx-auto">
                @forelse($users->sortByDesc('bps') as $user)
                    <div
                        class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition-shadow duration-300 hover:scale-105 transform p-4 group">
                        @if ($user->profile->photo)
                            <img src="{{ asset('storage/' . $user->profile->photo) }}" alt="{{ $user->profile->name }}"
                                class="w-24 h-24 mx-auto rounded-full mb-4 shadow-sm">
                        @else
                            <div
                                class="w-full h-36 bg-gray-200 flex items-center justify-center rounded-xl mb-4 text-gray-500">
                                No Image
                            </div>
                        @endif

                        <h3 class="text-lg font-semibold text-gray-800">{{ $user->profile->prefix }}
                            {{ $user->profile->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $user->profile->designation }}</p>
                        <div class="text-xs text-gray-500 mt-3">
                            <p><i class="bi-telephone"></i> {{ $user->phone }}</p>
                            <p><i class="bi-clock"></i> {{ $user->profile->joined_at?->diffInYears(Carbon\Carbon::now()) }}
                                years stay</p>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Teacher profiles will be available soon!</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
