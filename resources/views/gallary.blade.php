@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection
@section('style')
<style>
    /* Custom styles for smoother transitions or specific overrides */
    .gallery-item img {
        transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
        filter: brightness(0.9);
    }

    .filter-btn.active {
        background-color: #3b82f6;
        /* Blue-500 */
        color: #ffffff;
        font-weight: 600;
    }

    /* Modal specific styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        /* Ensure image fits without cropping */
    }

    .modal-caption {
        margin-top: 20px;
        color: #fff;
        text-align: center;
        font-size: 1.25rem;
        /* text-xl */
    }

    .close-modal {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
</style>
@endsection
@section('body')
<section class="py-12 md:py-24">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-3 mb-10 md:mb-12">

            <button class="filter-btn active bg-blue-500 text-white py-2 px-6 rounded-full text-base font-semibold shadow-md hover:bg-blue-700 transition duration-300" data-category="all">All Events</button>
            @foreach($categories as $category)
            <button class="filter-btn bg-gray-200 text-gray-700 py-2 px-6 rounded-full text-base font-medium shadow-md hover:bg-gray-300 transition duration-300" data-category="{{ $category }}">{{ ucwords($category) }}</button>
            @endforeach
        </div>

        <div id="gallery-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($events as $event)
            <div class="gallery-item bg-white rounded-lg shadow-md overflow-hidden group cursor-pointer" data-category="{{$event->category}}">
                <img src="{{ asset('storage/'. $event->photo) }}" alt="Annual Sports Day" class="w-full h-48 object-cover object-center">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $event->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $event->detail }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div id="imageModal" class="modal">
    <span class="close-modal">&times;</span>
    @if($events->count())
    <img class="modal-content" id="img01" src="{{ asset('storage/' . $events->first()->photo) }}">
    @else
    <img class="modal-content" id="img01" src="">
    @endif
    <div id="caption" class="modal-caption"></div>
</div>
</section>
<!-- footer -->
<x-footer></x-footer>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');
        const imageModal = document.getElementById('imageModal');
        const modalImg = document.getElementById('img01');
        const modalCaption = document.getElementById('caption');
        const closeModal = document.querySelector('.close-modal');

        // Image Filtering Logic
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const category = button.dataset.category;

                // Remove 'active' from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active', 'bg-blue-500', 'text-white', 'font-semibold'));
                filterButtons.forEach(btn => btn.classList.add('bg-gray-200', 'text-gray-700', 'font-medium'));

                // Add 'active' to clicked button
                button.classList.add('active', 'bg-blue-500', 'text-white', 'font-semibold');
                button.classList.remove('bg-gray-200', 'text-gray-700', 'font-medium');

                galleryItems.forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block'; // Or 'grid'/'flex' depending on inner display
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Image Modal Logic
        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                imageModal.style.display = 'flex'; // Use flex for centering
                modalImg.src = item.querySelector('img').src;
                modalCaption.innerHTML = item.querySelector('h3').textContent + '<br>' + item.querySelector('p').textContent;
            });
        });

        closeModal.addEventListener('click', () => {
            imageModal.style.display = 'none';
        });

        // Close modal when clicking outside the image
        imageModal.addEventListener('click', (e) => {
            if (e.target === imageModal) {
                imageModal.style.display = 'none';
            }
        });
    });
</script>
@endsection