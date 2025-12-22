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
            <div class="bg-slate-300 p-5 relative">
                <img src="{{ url(asset('images/logo/dark_green.png')) }}" alt=""
                    class="absolute top-2 md:top-2 left-2 md:left-2 w-12">
                <div class="flex flex-col flex-1 justify-center items-center text-center">
                    <h2 class="txt-lg font-bold tracking-wider"> Faculty Members Only</h2>
                </div>
            </div>

            <div class="px-5 shadow-lg">
                <form action="{{ route('faculty.store') }}" method="post" id='applicationForm' class="w-full py-5 md:px-16"
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
                    <div class="grid md:grid-cols-2 gap-3">
                        <div class="md:col-span-2">
                            <label for="">Name <i class="bi-person"></i></label>
                            <input type="text" name="name" class="custom-input fancy-focus"
                                placeholder="Your good name" required>
                        </div>
                        <div class="">
                            <label for="">Short Name <span class="text-red-600">(To be displayed on time
                                    table)</span></label>
                            <input type="text" name="short_name" class="custom-input fancy-focus"
                                placeholder="for example: M Abbas" required>
                        </div>
                        <div class="">
                            <label for="">Father Name</label>
                            <input type="text" name="father_name" class="custom-input fancy-focus"
                                placeholder="Father name" required>
                        </div>

                        <div>
                            <label for="">CNIC <i class="bi-person-vcard"></i></label>
                            <input type="text" name="cnic" id='cnic' class="custom-input fancy-focus cnic"
                                placeholder="Type your CNIC" required>
                        </div>
                        <div>
                            <label for="dob">Date of Birth (mm/dd/yyyy) <i class="bi-clock"></i></label>
                            <input type="date" name="dob" class="custom-input fancy-focus" required>
                        </div>
                        <div>
                            <label for="">Email <i class="bi-at"></i></label>
                            <input type="email" name="email" id='email' class="custom-input fancy-focus"
                                placeholder="Email">
                        </div>
                        <div>
                            <label for="">Phone No <i class="bi-whatsapp"></i></label>
                            <input type="text" name="phone" id='phone' class="custom-input fancy-focus phone"
                                placeholder="Personal Phone" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="">Home Address <i class="bi-house"></i></label>
                            <input type="text" name="address" id='address' class="custom-input fancy-focus"
                                placeholder="Address" required>
                        </div>

                        <div>
                            <label for="blood_group">Blood Group</label>
                            <select name="blood_group" class="custom-input fancy-focus">
                                <option value="">Select a blood group</option>
                                @foreach (config('enums.bloodgroups') as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div>
                            <label for="qualification">Qualification <i class="bi-layers"></i></label>
                            <input type="text" name="qualification" class="custom-input fancy-focus"
                                placeholder="e.g MA Urdu">
                        </div>

                        <div>
                            <label for="designation">Designation</label>
                            <input type="text" name="designation" class="custom-input fancy-focus"
                                placeholder="e.g SST(Arts)" required>
                        </div>
                        <div>
                            <label for="bps">BPS</label>
                            <select name="bps" class="custom-input fancy-focus" required>
                                <option value="">Select ...</option>
                                @foreach (range(1, 22) as $bps)
                                    <option value="{{ $bps }}">{{ $bps }}</option>
                                @endforeach


                            </select>
                        </div>
                        <div>
                            <label for="dob">Entry into Govt Service (mm/dd/yyyy) <i class="bi-clock"></i></label>
                            <input type="date" name="joined_at" class="custom-input fancy-focus" required>
                        </div>
                        <div>
                            <label for="personal_no">Personnel # (salary) <i class="bi-numeric"></i></label>
                            <input type="text" name="personal_no" class="custom-input fancy-focus"
                                placeholder="Personnel No." required>
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

            $('.cnic').on('input', function() {
                let value = $(this).val().replace(/\D/g, '').substring(0, 13);
                let formatted = value;
                if (value.length > 5) formatted = value.substring(0, 5) + '-' + value.substring(5);
                if (value.length > 12) formatted = formatted.substring(0, 13) + '-' + value.substring(12);
                $(this).val(formatted);
            });

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
