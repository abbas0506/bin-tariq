@extends('layouts.basic')

@section('header')
    <x-header></x-header>
@endsection
@section('body')

    <!-- <div class="text-center bg-sky-100 text-sm py-1">(+92 42) 99233106-7</div> -->
    <header id='page_title' class="p-5 md:px-24 pt-32 text-center ">
        <div class="text-4xl font-bold text-center text-cyan-800 ">Contact Us</div>
        <p class="mt-4 bg-teal-600 h-1 rounded w-24 mx-auto"></p>
    </header>
    <section class="">
        <div class="grid md:grid-cols-2 mt-8 p-5 md:px-24 w-full md:w-2/3 mx-auto gap-8">
            <div
                class="flex flex-col md:col-span-2 justify-center items-center text-center shadow-lg p-8 hover:shadow-2xl hover:bg-cyan-100 transition-all delay-75 ease-in-out">
                <i class="bi-geo-alt-fill text-cyan-700 text-2xl"></i>
                <h2 class="text-xl">Our Address</h2>
                <p class="">Chorasta Mian Khan, Dipalpur-Basirpur Road, Okara, Pakistan</p>
            </div>
            <div
                class="flex flex-col justify-center items-center shadow-lg p-8 hover:shadow-2xl hover:bg-orange-50 transition-all delay-75 ease-in-out">
                <i class="bi-envelope-at-fill text-amber-600 text-2xl"></i>
                <h2 class="text-xl">Email Us</h2>
                <p class="">bin-tariq@gmail.com</p>
            </div>
            <div
                class="flex flex-col justify-center items-center shadow-lg p-8 hover:shadow-2xl hover:bg-orange-50 transition-all delay-75 ease-in-out">
                <i class="bi-telephone-fill text-amber-600 text-2xl"></i>
                <h2 class="text-xl">Call Us</h2>
                <p class="">+92 300 0000000</p>
            </div>
        </div>
    </section>
    <!-- map -->
    <section class="mt-16">
        <div class="overflow-x-hidden">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7675.500046900273!2d73.76636784597382!3d30.61402571808166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39181e1197ea978f%3A0xbd36214b35709acc!2sChorasta%20Mian%20Khan%2C%20Pakistan!5e0!3m2!1sen!2s!4v1767631104007!5m2!1sen!2s"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full" height="320"
                style="border:0;"></iframe>
        </div>
    </section>

    <!-- footer -->
    <x-footer></x-footer>
@endsection

@section('script')
