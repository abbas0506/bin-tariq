@extends('layouts.basic')

@section('header')
    <x-header></x-header>
@endsection

@section('body')
    <style>
        /* body {
                                                                                                background-color: #6d6d6d;
                                                                                            } */

        /* .sticky-header {
                                                                                                background-color: #0d9488;
                                                                                            } */

        @keyframes waveGlow {
            0% {
                box-shadow: 0 0 0px rgba(13, 148, 136, 0.6);
            }

            50% {
                box-shadow: 0 0 10px 4px rgba(13, 148, 136, 0.4);
            }

            100% {
                box-shadow: 0 0 0px rgba(13, 148, 136, 0.6);
            }
        }

        .fancy-focus:focus {
            border-color: #0d9488;
            /* teal-600 */
            background-color: transparent;
            animation: waveGlow 1s ease-in-out infinite;
            outline: none;
        }

        .photo-box {
            width: 150px;
            height: 150px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 18px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .photo-upload-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .custom-file-upload {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .custom-file-upload:hover {
            background-color: #0056b3;
        }

        input[type="file"] {
            display: none;
        }
    </style>

    <section>
        <div class="max-w-full m-5 md:mx-auto lg:w-2/3  mt-24 bg-white">
            <div class="bg-green-100 p-5 relative">
                {{-- <img src="{{ url(asset('images/logo/dark_green.png')) }}" alt=""
                    class="absolute top-2 md:top-2 left-2 md:left-2 w-12"> --}}
                <div class="flex flex-col flex-1 justify-center items-center text-center ">
                    <h2 class="text-lg md:text-xl font-bold tracking-wider text-green-600 "> We are happy that you are here!
                        <i class="bi-emoji-smile text-green-600 "></i></h2>
                </div>
            </div>

            <div class="px-5 shadow-lg">
                <form action="{{ route('alumni.store') }}" method="post" id='applicationForm' class="w-full py-5 md:px-16"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="photo-upload-wrapper">
                        <!-- Placeholder Photo Box -->
                        <div class="photo-box" id="photoPreview">Photo</div>

                        <!-- Custom Upload Button -->
                        <label for="photo" class="custom-file-upload">Upload Your Photo</label>
                        <input type="file" id="photo" name="photo" accept="image/*"
                            onchange="previewSelectedPhoto(event)">
                        <label id="photo-error" class="text-red-500 mt-1 hidden">File size exceeds 1MB.</label>
                    </div>

                    <!-- page error message -->
                    @if ($errors->any())
                        <x-message :errors='$errors'></x-message>
                    @else
                        <x-message></x-message>
                    @endif

                    <!-- <hr class="mt-3"> -->
                    <div class="grid md:grid-cols-2 gap-3 mt-6">
                        <div class="">
                            <label for="">Name <i class="bi-person"></i></label>
                            <input type="text" name="name" class="custom-input fancy-focus" placeholder="Name"
                                required>
                        </div>
                        <div>
                            <label for="">Phone <i class="bi-whatsapp"></i></label>
                            <input type="text" name="phone" id='phone' class="custom-input fancy-focus phone"
                                placeholder="Phone" required>
                        </div>

                        <div class="">
                            <label for="">Residence <i class="bi-house"></i></label>
                            <input type="text" name="address" id='address' class="custom-input fancy-focus"
                                placeholder="for example: 32/2L" required>
                        </div>


                        <div>
                            <label for="session">Session <i class="bi-clock"></i> (میٹرک کب پاس کیا؟) </label>
                            <select name="session" class="custom-input fancy-focus" required>
                                <option value="">Select ...</option>
                                @foreach (range(1955, now()->format('Y')) as $session)
                                    <option value="{{ $session }}">{{ $session }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="introduction">Brief Introduction (maximum 100 characters)<i
                                    class="bi-numeric"></i></label>
                            <input type="text" name="introduction" class="custom-input fancy-focus"
                                placeholder="Currently I am working as ..." required>
                        </div>
                        <div class="flex justify-center space-x-3 text-center mt-8 md:col-span-2">
                            <a href="{{ url('/') }}" class="btn-gray rounded py-3 px-5">Cancel <i
                                    class="bi-x text-white"></i></a>
                            <button class="btn-blue rounded py-3 px-5">Submit <i class="bi-check"></i></button>
                        </div>
                </form>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script type="module">
        $(document).ready(function() {

            // Auto-insert dash for Phone
            $('.phone').on('input', function() {
                let value = $(this).val().replace(/\D/g, '').substring(0, 12);
                let formatted = value;
                if (value.length > 4) formatted = value.substring(0, 4) + '-' + value.substring(4);
                $(this).val(formatted);
            });

        });
    </script>
    <script>
        function previewSelectedPhoto(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const photoBox = document.getElementById('photoPreview');
                photoBox.style.backgroundImage = `url('${reader.result}')`;
                photoBox.style.backgroundSize = 'cover';
                photoBox.style.backgroundPosition = 'center';
                photoBox.textContent = ''; // Remove "Photo" placeholder
            }
            reader.readAsDataURL(event.target.files[0]);
        }
        // show error if file size exceeds 1MB
        const form = document.getElementById('applicationForm');
        const photoInput = document.getElementById('photo');
        const errorText = document.getElementById('photo-error');

        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.size > 1024 * 1024) {
                errorText.classList.remove('hidden');
            } else {
                errorText.classList.add('hidden');
            }
        });

        form.addEventListener('submit', function(e) {
            const file = photoInput.files[0];
            if (!photoInput.files.length) {
                e.preventDefault(); // Stop form submission
                Swal.fire({
                    title: "Warning",
                    text: "Please select a photo",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500

                });
                photoInput.focus();
            }
            if (file && file.size > 1024 * 1024) { // 1MB = 1024 * 1024 bytes
                e.preventDefault(); // stop form submission
                errorText.classList.remove('hidden'); // show error
                Swal.fire({
                    title: "Warning",
                    text: "Photo size exceeds 1MB",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500

                });
            } else {
                errorText.classList.add('hidden'); // hide error if valid
            }
        });
    </script>
@endsection
