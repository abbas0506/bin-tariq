@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<style>
    body {
        background-color: #6d6d6d;
    }
</style>
<section>

    <div class="w-full md:w-2/3 mx-auto min-h-screen flex items-center justify-center p-6">

        <div class="bg-white shadow-xl rounded-2xl max-w-lg w-full text-center p-8">
            <div class="text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-20 w-20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-2xl font-semibold text-gray-800 mb-3">Congratulations!</h1>
            <p class="text-gray-600 text-lg mb-6">Your application has been submitted successfully.</p>

            <div class="bg-gray-100 rounded-lg p-4 mb-6">
                <p class="text-gray-500 text-sm">Your Application Number:</p>
                <p class="text-xl font-bold text-gray-700">{{ $application->rollno }}</p>
            </div>

            <a href="{{ url('/') }}" class="btn-blue rounded-full py-2 px-5 mb-4">Ok</a>
        </div>

    </div>


</section>

@endsection