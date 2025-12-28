@extends('layouts.basic')

@section('header')
    <x-header></x-header>
@endsection
@section('body')
    <section class="text-gray-800 font-sans px-5 md:px-24 mt-16">
        <!-- Hero Section -->
        <section class="relative">
            <div class="max-w-7xl mx-auto px-4 py-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-teal-700 mb-6">
                        Highly Skilled <span class="text-slate-600">Faculty</span>
                    </h1>
                    <p class="text-lg leading-relaxed text-gray-700">
                        We have highly skilled faculty who known the necessities and age dependant social and mental
                        requirements of your kids.
                        We follow activity based teaching method as it is an accepted concept of modern education.
                    </p>
                </div>
                <div class="relative">
                    <img src="{{ url('images/events/event_1.png') }}" alt="School Image"
                        class="rounded-xl shadow-2xl transform hover:scale-105 transition duration-500" />
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-16">
            <div class="max-w-6xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-semibold text-teal-800 mb-12">At a Glance</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-10">
                    <div class="bg-white rounded-lg p-6 shadow-[0_0_30px_rgba(0,0,0,0.2)]">
                        <h3 class="text-2xl md:text-4xl font-bold text-teal-600">300+</h3>
                        <p class="mt-2 text-gray-600">Students</p>
                    </div>
                    <div class="bg-white p-6 shadow-[0_0_30px_rgba(0,0,0,0.2)]">
                        <h3 class="text-2xl md:text-4xl font-bold text-teal-600">10+</h3>
                        <p class="mt-2 text-gray-600">Teachers</p>
                    </div>
                    <div class="bg-white p-6 shadow-[0_0_30px_rgba(0,0,0,0.2)]">
                        <h3 class="text-2xl md:text-4xl font-bold text-teal-600">1:30</h3>
                        <p class="mt-2 text-gray-600">Student-Teacher Ratio</p>
                    </div>
                </div>
            </div>
        </section>

    </section>
@endsection
@section('footer')
    <x-footer></x-footer>
@endsection
