@extends('layouts.basic')

@section('header')
    <x-header></x-header>
@endsection

@section('body')
    <style>
        body {
            background-color: #6d6d6d;
        }

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
            <div class="bg-teal-600 p-5 relative">
                <img src="{{ url(asset('images/logo/dark_green.png')) }}" alt=""
                    class="absolute top-2 md:top-8 left-2 md:left-8 w-16">
                <div class="flex flex-col flex-1 justify-center items-center text-center">
                    <h2 class="txt-lg font-bold tracking-wider"> ADMISSION FORM</h2>
                    <h2 class="text-sm font-semibold">Part I - Session {{ date('Y') }}</h2>
                    <p class="text-sm"> Govt. Higher Seconary School Chakbedi Pakpattan</p>
                    <!-- <p>Part I Session 2025-27 </p> -->
                </div>
            </div>

            <div class="px-5">
                <form action="{{ url('apply') }}" method="post" id='applicationForm' class="w-full py-5 md:px-16"
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

                    <input name="grade" value="11" hidden>
                    <h2 class="mt-8">Choose your desired group</h2>
                    <div class="grid gap-y-2 mt-3">
                        @foreach ($groups as $group)
                            <div>
                                <input type="checkbox" id='group_id_{{ $group->id }}' name="group_id"
                                    value="{{ $group->id }}" class="chk-group rounded mr-2">
                                <label for="group_id_{{ $group->id }}"><strong>{{ $group->name }}
                                    </strong>({{ $group->subjects_list }})</label>
                            </div>
                        @endforeach
                    </div>
                    <hr class="mt-3">
                    <div class="grid md:grid-cols-2 gap-4 mt-4">
                        <div class="">
                            <label for="">Passing Year (میٹرک کب پاس کیا؟)</label>
                            <select name="pass_year" id="" class="custom-input fancy-focus">
                                <option value="{{ date('Y') - 2 }}">{{ date('Y') - 2 }}</option>
                                <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                                <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="">Student Name ( رزلٹ کارڈ کے مطابق)</label>
                            <input type="text" name="name" class="custom-input fancy-focus" placeholder="Student name"
                                required>
                        </div>

                        <div>
                            <label for="">Form-B (ب فارم)</label>
                            <input type="text" name="bform" id='bform' class="custom-input fancy-focus cnic"
                                placeholder="00000 - 0000000- 0" required>
                        </div>
                        <div>
                            <label for="">Phone No</label>
                            <input type="text" name="phone" id='phone' class="custom-input fancy-focus"
                                placeholder="0000 - 0000000" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="">Address (گاوؑں کانام) </label>
                            <input type="text" name="address" id='address' class="custom-input fancy-focus"
                                placeholder="Address" required>
                        </div>
                        <div>
                            <label for="dob">Date of Birth (mm/dd/yyyy)</label>
                            <input type="date" name="dob" class="custom-input fancy-focus" required>
                        </div>

                        <div>
                            <label for="id_mark">Identification Mark (شناختی علامت)</label>
                            <input type="text" name="id_mark" class="custom-input fancy-focus"
                                placeholder="Identification mark" required>
                        </div>

                        <div>
                            <label for="caste">Caste (ذات)</label>
                            <select name="caste" class="custom-input fancy-focus" placeholder="Caste" required>
                                @foreach (config('enums.castes') as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="is_orphan"> Are you orphan (یتیم)? </label>
                            <select name="is_orphan" class="custom-input fancy-focus" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="">
                            <label for="">Father Name</label>
                            <input type="text" name="father_name" class="custom-input fancy-focus"
                                placeholder="Father name" required>
                        </div>
                        <div class="">
                            <label for="">Mother Name</label>
                            <input type="text" name="mother_name" class="custom-input fancy-focus"
                                placeholder="Mother name" required>
                        </div>

                        <div class="md:col-span-2 text-teal-600 text-right">گارڈین یا سرپرست سے مراد وہ شخص ہے جو آپکے
                            تعلیمی اخراجات برداشت کرے گا </div>
                        <div>
                            <label for="father_cnic">Father/Guardian's CNIC</label>
                            <input type="text" name="father_cnic" class="custom-input fancy-focus cnic"
                                placeholder="00000 - 0000000- 0" required>
                        </div>

                        <div>
                            <label for="mother_cnic">Mother's CNIC</label>
                            <input type="text" name="mother_cnic" class="custom-input fancy-focus cnic"
                                placeholder="00000 - 0000000- 0" required>
                        </div>
                        <div>
                            <label for="profession">Father/Guardian's Profession (پیشہ)</label>
                            <select name="profession" class="custom-input fancy-focus" required>
                                @foreach (config('enums.professions') as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="income">Father/Guardian's Income (ماہانہ آمدنی) </label>
                            <select name="income" class="custom-input fancy-focus" required>
                                @foreach (config('enums.incomes') as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="previous_school">Previous School (سابقہ سکول)</label>
                            <input type="text" name="previous_school" class="custom-input fancy-focus"
                                placeholder="Previous school" required>
                        </div>
                        <div>
                            <label for="medium">Medium (میٹرک میں زریعہ تعلیم)</label>
                            <select name="medium" class="custom-input fancy-focus" required>
                                <option value="ur">Urdu</option>
                                <option value="en">English</option>
                            </select>
                        </div>

                        <div>
                            <label for="bise">Board</label>
                            <select name="bise" class="custom-input fancy-focus" placeholder="Board" required>
                                @foreach (config('enums.bises') as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="rollno">Matric Roll No</label>
                            <input type="text" name="rollno" class="custom-input fancy-focus" placeholder="Roll no."
                                required>
                        </div>
                        <div>
                            <label for="max_marks">Total Marks</label>
                            <select name="max_marks" id="max_marks" class="custom-input fancy-focus">
                                <option value="1000">1000</option>
                                <option value="1050">1050</option>
                                <option value="1100">1100</option>
                                <option value="1150">1150</option>
                                <option value="1200" selected>1200</option>
                            </select>
                        </div>
                        <div>
                            <label for="obtained_marks">Obtained Marks (حاصل کردہ نمبر) </label>
                            <input type="number" name="obtained_marks" class="custom-input fancy-focus"
                                placeholder="Obtained marks" min='0' max='1200' required>
                        </div>

                    </div>
                    <div dir="rtl" class="p-5 mt-5 bg-teal-100 text-sm">
                        میں یہ حلفیہ اقرار کرتا ہوں کہ اس درخواست فارم میں فراہم کردہ تمام معلومات میرے بہترین علم کے مطابق
                        درست ہیں۔ میں سمجھتا ہوں کہ کوئی بھی غلط یا گمراہ کن معلومات میری درخواست یا داخلے کی منسوخی کا سبب
                        بن سکتی ہے۔"
                    </div>
                    <div class="flex justify-center space-x-3 text-center mt-8">
                        <a href="{{ url('/') }}" class="btn-gray rounded py-3 px-5">Cancel</a>
                        <button class="btn-blue rounded py-3 px-5">Submit</button>

                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script type="module">
        $(document).ready(function() {
            $('.chk-group').on('change', function() {
                $('.chk-group').not(this).prop('checked', false); // Uncheck all except clicked one
            });

            $('.cnic').on('input', function() {
                let value = $(this).val().replace(/\D/g, '').substring(0, 13);
                let formatted = value;
                if (value.length > 5) formatted = value.substring(0, 5) + '-' + value.substring(5);
                if (value.length > 12) formatted = formatted.substring(0, 13) + '-' + value.substring(12);
                $(this).val(formatted);
            });

            // Auto-insert dash for Phone
            $('#phone').on('input', function() {
                let value = $(this).val().replace(/\D/g, '').substring(0, 12);
                let formatted = value;
                if (value.length > 4) formatted = value.substring(0, 4) + '-' + value.substring(4);
                $(this).val(formatted);
            });

            $('form').on('submit', function(e) {
                if (!$('.chk-group:checked').length) {
                    Swal.fire({
                        title: "Warning",
                        text: "Please, select a group",
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 1500

                    });
                    e.preventDefault();
                }
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
