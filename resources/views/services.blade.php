@extends('layouts.basic')
@section('header')
    <x-header></x-header>
@endsection
@section('body')
    <section id='features' class="mt-32">
        <div class="section-title">
            <h2> Our Services</h2>
        </div>

        <div
            class="feature grid grid-cols-1 md:grid-cols-3 space-x-0 md:space-x-8 space-y-4 md:space-y-0 w-4/5 mx-auto mt-16">
            <div class="flex flex-col justify-center items-center p-8 shadow-lg hover:border hover:border-pink-300">
                <div class="flex justify-center items-center bg-pink-100 rounded-full w-16 h-16">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-8 h-8 text-pink-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </div>
                <h3>Academics</h3>
                <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non
                    provident</p>
            </div>
            <div
                class="flex flex-col justify-center items-center p-8 shadow-lg hover:border hover:border-cyan-200 box-border">
                <div class="flex justify-center items-center bg-cyan-100 rounded-full w-16 h-16">
                    <i class="bx  bx-search text-2xl"></i>
                </div>
                <h3>Research</h3>
                <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non
                    provident</p>
            </div>

            <div class="flex flex-col justify-center items-center p-8 shadow-lg hover:border hover:border-green-200">
                <div class="flex justify-center items-center bg-green-100 rounded-full w-16 h-16">
                    <i class="bi bi-search text-2xl rotate-90"></i>
                </div>
                <h3>Consultancy</h3>
                <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non
                    provident</p>
            </div>
        </div>
    </section>

    <!-- footer -->
    <x-footer></x-footer>
@endsection

@section('script')
