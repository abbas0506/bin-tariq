@extends('layouts.basic')

@section('header')
    <x-header></x-header>
@endsection
@section('style')
    <style>
        /* Container holds both button and floating pointer */
        .button-container {
            position: relative;
            display: inline-block;
        }

        /* Button styling */
        .click-demo-button {
            padding: 0.25rem 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #0d9488;
            background-color: transparent;
            border: 2px solid #0d9488;
            border-radius: 9999px;
            cursor: pointer;
            overflow: hidden;
            transition: background-color 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .click-demo-button:hover {
            background-color: rgba(13, 148, 136, 0.1);
        }

        /* Pointer icon absolutely positioned OVER the button */
        .pointer-icon {
            position: absolute;
            font-size: 24px;
            color: #0d9488;
            opacity: 0;
            z-index: 10;
            animation: flyClick 3s ease-in-out infinite;

            left: 100%;
            top: 100%;
            transform: rotate(-90deg);
        }

        @keyframes flyClick {
            0% {
                opacity: 0;
                transform: translate(40px, 40px) rotate(-90deg);
            }

            20% {
                opacity: 1;
                transform: translate(-300%, -100%) rotate(-90deg);
            }

            40% {
                transform: translate(-300%, -100%) scale(0.9) rotate(-90deg);
            }

            45% {
                transform: translate(-300%, -100%) scale(1) rotate(-90deg);
            }

            50% {
                transform: translate(-300%, -100%) scale(0.9) rotate(-90deg);
            }

            55% {
                transform: translate(-300%, -100%) scale(1) rotate(-90deg);
            }

            80% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translate(40px, 40px) rotate(-90deg);
            }
        }
    </style>
@endsection

@section('body')
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <section class="w-screen h-screen">
        <div class="flex flex-col md:flex-row-reverse justify-between items-center px-5 md:px-24 h-full pt-16">
            <div class="flex flex-1 justify-end items-center">
                <img src="{{ url(asset('images/small/education.png')) }}" alt="student" class="w-32 h-32 md:w-96 md:h-96">

            </div>

            <div class="flex flex-col flex-1 gap-y-2 justify-center">
                <p>Discover</p>
                <h2 class="text-2xl md:text-4xl font-bold">Quality Education</h2>
                <p class="text-slate-600 text-sm md:text-lg leading-relaxed mt-4"> We have highly skilled teaching staff who
                    focus on activity based teaching.
                    Our institution provides a state of the art environment where your kids' dreams become reality.
                    Join us as we can lead your kid to destination </p>
                <a href="">
                    <button class="btn-teal mt-5 rounded py-2">Join Us <i class="bi-arrow-right"></i></button>
                </a>
            </div>

        </div>
    </section>

    <!-- features section -->
    <section id='features' class="md:mt-24 px-4 md:px-24 mt-12">
        <h2 class="text-2xl md:text-4xl text-center">WELCOME TO</h2>
        <p class="text-center text-sm md:text-lg mt-3">Government High School 32/2L, District
            Okara</p>
        <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <div class="feature-box hover:border-pink-300 hover:bg-pink-50">
                <div class="flex items-center justify-center bg-pink-100 rounded-full w-16 h-16">
                    <i class="bi-book text-2xl text-pink-400"></i>
                </div>
                <h3 class="mt-3 text-lg">Quality Education</h3>
                <p class="text-sm text-center">We provide quality education from nursery to 10<sup>th</sup>
                    class.</p>
            </div>

            <div class="feature-box hover:border-teal-300 hover:bg-teal-50">
                <div class="flex items-center justify-center bg-teal-100 rounded-full w-16 h-16">
                    <i class="bx bx-run text-2xl text-teal-400"></i>
                </div>
                <h3 class="mt-3 text-lg">Activity Based</h3>
                <p class="text-sm text-center">We focus on activity based teaching and interactive teaching </p>
            </div>
            <div class="feature-box hover:border-blue-200 hover:bg-blue-50">
                <div class="flex items-center justify-center bg-blue-100 rounded-full w-16 h-16">
                    <i class="bx bx-run text-2xl text-blue-400"></i>
                </div>
                <h3 class="mt-3 text-lg">Social Development</h3>
                <p class="text-sm text-center">We build healthy social habits to make your kid a socially responsible
                    citizen </p>
            </div>
        </div>
    </section>

    <!-- distinction -->
    <section>
        <div class="mt-24 bg-slate-100">
            <div class="grid gap-4 md:w-3/4 mx-auto p-4 md:p-8 md:text-base text-sm text-center">
                <h2 class="text-2xl md:text-3xl">Extra-Curricular Achievements</h2>
                <p>We engage our learners in extra-curricular activites on regular basis.
                    We undertand that extra-curricular activites bring healthy changes in students life </p>

            </div>
        </div>
        </div>
    </section>

    <section class="pt-0" data-aos="fade-up">
        <div class="mt-24 px-4 md:px-16 md:w-3/4 mx-auto">
            <h2 class="text-2xl md:text-4xl text-center">Message</h2>
            <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>
        </div>
        <div class="w-full md:w-3/4 mx-auto mt-12">
            <div class="flex justify-center items-center flex-col">
                <img src="{{ asset('images/default.png') }}" class="w-48 h-48 rounded-full" alt="">
                <h2 class="mt-3 font-bold text-lg">Muhammad Abbas</h2>
                <h2>Senior Headmaster</h2>
                <p class="mt-3 text-sm md:text-lg text-center p-5">
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    We are committed to achieve academic excellence, character education, and inclusive community
                    engagement. we empower our students to become lifelong learners, compassionate leaders, and contributors
                    to a globally connected society.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
            </div>


        </div>


    </section><!-- End Ttstimonials Section -->

    <section class="mt-12 md:px-24 p-5">
        <div class="overflow-x-hidden">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3148.1450523610893!2d73.52741423705822!3d30.73508993913517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39180624c19cb001%3A0x4eb6e3a38a104dbe!2sGovt%20Boys%20High%20School!5e0!3m2!1sen!2s!4v1768930968653!5m2!1sen!2s"
                class="w-full" height="320" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </section>

    <!-- footer -->
    <x-footer></x-footer>
@endsection

@section('script')
    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll('.slides img');
        const totalSlides = slides.length;

        function changeSlide(n) {
            slideIndex += n;
            if (slideIndex >= totalSlides) {
                slideIndex = 0;
            } else if (slideIndex < 0) {
                slideIndex = totalSlides - 1;
            }
            updateSlides();
        }

        function updateSlides() {
            slides.forEach((slide, index) => {
                if (index === slideIndex) {
                    slide.classList.remove('hidden');
                } else {
                    slide.classList.add('hidden');
                }
            });
        }

        updateSlides();
    </script>
@endsection
