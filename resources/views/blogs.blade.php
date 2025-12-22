@extends('layouts.basic')
@section('header')
<x-header></x-header>
@endsection
@section('body')

<x-header></x-header>
<h2 class="text-center text-cyan-800 mt-32">Blogs</h2>
<div class="container mt-16">
    <div class="flex flex-col md:flex-row space-x-0 md:space-x-8">
        <div class="w-full md:w-2/3">
            <div class="blog">
                <img src="{{url('images/events/8.jpg')}}" alt="sat" class="w-full">
                <div class="p-8 shadow-md">
                    <h2><a href=''>Blog tile will be placed here with few lines</a></h2>
                    <ul class="meta">
                        <li>
                            <i class="bi bi-person"></i>
                            <a href=''>Zia Ul Haq</a>
                        </li>
                        <li class="ml-6">
                            <i class="bi bi-clock"></i>
                            <p>Jan 01, 2023</p>
                        </li>
                    </ul>
                    <p>
                        Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non providentVoluptatum delenitiexcepturi sint occaecati cupiditate non providentVoluptatum deleniti excepturi sint occaecati cupiditate non providentVoluptatum deleniti excepturi sint occaecati cupiditate non providentVoluptatum deleniti
                    </p>
                    <div class="flex justify-end mt-5">
                        <a href='' class="btn btn-cyan">Read more</a>
                    </div>


                </div>

            </div>
        </div>
        <div id='blog-search' class="w-full md:w-1/3">
            <div class="flex flex-col shadow-md p-8">
                <div class="relative w-full">
                    <input type="text" class="w-full focus:border-slate-100">
                    <i class="bi bi-search absolute right-3 top-2"></i>
                </div>
                <h3 class="mt-5">Categories</h3>
                <a href="">General <span class="text-slate-400">(5)</span></a>
                <a href="">Climatic Change <span class="text-slate-400">(3)</span></a>
                <a href="">Remote Sensing <span class="text-slate-400">(2)</span></a>
                <a href="">GIS <span class="text-slate-400">(4)</span></a>

            </div>

        </div>

    </div>
    <div></div>

</div>
<!-- footer -->
<x-footer></x-footer>
@endsection

@section('script')