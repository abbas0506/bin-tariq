@extends('layouts.basic')
@section('header')
<x-header></x-header>
@endsection
@section('body')
<style>
    .clipped {
        /* position: absolute; */
        background-color: green;
        height: 100%;
        width: 100%;
        scale: 120%;
        /* clip-path: ellipse(60% 40% at 50% 40%); */
        background-image: linear-gradient(to right, rgba(209, 213, 219) 0 70%, rgba(252, 211, 77) 70% 100%);

        /* clip-path: polygon(0 0, 100% 0, 100% 80%, 50% 80%, 0 80%); */
    }

    .clipped::before {
        content: "";

        position: absolute;
        background-color: teal;
        height: 100%;
        width: 100%;
        scale: 120%;
        rotate: 5deg;
        clip-path: ellipse(60% 40% at 50% 40%);
        z-index: 0;
        /* clip-path: polygon(0 0, 100% 0, 100% 80%, 50% 80%, 0 80%); */
    }
</style>
<section class="h-screen w-screen relative opacity-80">
    <div class="clipped">
        <h2 class="text-center text-cyan-800 mt-32">Team</h2>
    </div>
</section>

<!-- <div class="container mt-16">
    <div class="grid grid-cols-1 md:grid-cols-3 space-x-0 md:space-x-8 space-y-8 md:space-y-0">

        <div class="member">
            <div class="relative">
                <img src="{{url('images/events/8.jpg')}}" alt="sat" class="w-full">
                <div class="absolute bottom-0 py-1 w-full bg-cyan-900 opacity-50">
                    <ul class="absolute h-12 bottom-0 social-links flex justify-center items-center space-x-3 w-full">
                        <li><a href=""><i class="bi bi-facebook text-lg text-white"></i></a></li>
                        <li><a href=""><i class="bi bi-twitter text-lg text-white"></i></a></li>
                        <li><a href=""><i class="bi bi-instagram text-lg text-white"></i></a></li>
                        <li><a href=""><i class="bi bi-linkedin text-lg text-white"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="w-full md:w-2/3">
            <div class="blog">

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


    <div id="carouselExampleCaptions" class="relative" data-te-carousel-init data-te-carousel-slide>
        
        <div class="absolute bottom-0 left-0 right-0 z-[2] mx-[15%] mb-4 flex list-none justify-center p-0" data-te-carousel-indicators>
            <button type="button" data-te-target="#carouselExampleCaptions" data-te-slide-to="0" data-te-carousel-active class="mx-[3px] box-content h-[3px] w-[30px] flex-initial cursor-pointer border-0 border-y-[10px] border-solid border-transparent bg-white bg-clip-padding p-0 -indent-[999px] opacity-50 transition-opacity duration-[600ms] ease-[cubic-bezier(0.25,0.1,0.25,1.0)] motion-reduce:transition-none" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-te-target="#carouselExampleCaptions" data-te-slide-to="1" class="mx-[3px] box-content h-[3px] w-[30px] flex-initial cursor-pointer border-0 border-y-[10px] border-solid border-transparent bg-white bg-clip-padding p-0 -indent-[999px] opacity-50 transition-opacity duration-[600ms] ease-[cubic-bezier(0.25,0.1,0.25,1.0)] motion-reduce:transition-none" aria-label="Slide 2"></button>
            <button type="button" data-te-target="#carouselExampleCaptions" data-te-slide-to="2" class="mx-[3px] box-content h-[3px] w-[30px] flex-initial cursor-pointer border-0 border-y-[10px] border-solid border-transparent bg-white bg-clip-padding p-0 -indent-[999px] opacity-50 transition-opacity duration-[600ms] ease-[cubic-bezier(0.25,0.1,0.25,1.0)] motion-reduce:transition-none" aria-label="Slide 3"></button>
        </div>

       
        <div class="relative w-full overflow-hidden after:clear-both after:block after:content-['']">
            
            <div class="relative float-left -mr-[100%] w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none" data-te-carousel-active data-te-carousel-item style="backface-visibility: hidden">
                <img src="https://tecdn.b-cdn.net/img/Photos/Slides/img%20(15).jpg" class="block w-full" alt="..." />
                <div class="absolute inset-x-[15%] bottom-5 hidden py-5 text-center text-white md:block">
                    <h5 class="text-xl">First slide label</h5>
                    <p>
                        Some representative placeholder content for the first slide.
                    </p>
                </div>
            </div>
            
            <div class="relative float-left -mr-[100%] hidden w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none" data-te-carousel-item style="backface-visibility: hidden">
                <img src="https://tecdn.b-cdn.net/img/Photos/Slides/img%20(22).jpg" class="block w-full" alt="..." />
                <div class="absolute inset-x-[15%] bottom-5 hidden py-5 text-center text-white md:block">
                    <h5 class="text-xl">Second slide label</h5>
                    <p>
                        Some representative placeholder content for the second slide.
                    </p>
                </div>
            </div>
            
            <div class="relative float-left -mr-[100%] hidden w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none" data-te-carousel-item style="backface-visibility: hidden">
                <img src="https://tecdn.b-cdn.net/img/Photos/Slides/img%20(23).jpg" class="block w-full" alt="..." />
                <div class="absolute inset-x-[15%] bottom-5 hidden py-5 text-center text-white md:block">
                    <h5 class="text-xl">Third slide label</h5>
                    <p>
                        Some representative placeholder content for the third slide.
                    </p>
                </div>
            </div>
        </div>

        <button class="absolute bottom-0 left-0 top-0 z-[1] flex w-[15%] items-center justify-center border-0 bg-none p-0 text-center text-white opacity-50 transition-opacity duration-150 ease-[cubic-bezier(0.25,0.1,0.25,1.0)] hover:text-white hover:no-underline hover:opacity-90 hover:outline-none focus:text-white focus:no-underline focus:opacity-90 focus:outline-none motion-reduce:transition-none" type="button" data-te-target="#carouselExampleCaptions" data-te-slide="prev">
            <span class="inline-block h-8 w-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </span>
            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Previous</span>
        </button>
        
        <button class="absolute bottom-0 right-0 top-0 z-[1] flex w-[15%] items-center justify-center border-0 bg-none p-0 text-center text-white opacity-50 transition-opacity duration-150 ease-[cubic-bezier(0.25,0.1,0.25,1.0)] hover:text-white hover:no-underline hover:opacity-90 hover:outline-none focus:text-white focus:no-underline focus:opacity-90 focus:outline-none motion-reduce:transition-none" type="button" data-te-target="#carouselExampleCaptions" data-te-slide="next">
            <span class="inline-block h-8 w-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </span>
            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Next</span>
        </button>
    </div>

</div> -->
<!-- footer -->
<!-- <x-footer></x-footer> -->
@endsection
<script>
    import {
        Carousel,
        initTE,
    } from "tw-elements";

    initTE({
        Carousel
    });
</script>

@section('script')