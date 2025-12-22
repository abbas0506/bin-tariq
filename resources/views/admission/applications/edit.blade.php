@extends('layouts.admission')

@section('page-content')
<style>
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
<div class="custom-container">
    <!-- Title     -->
    <h1>Applications</h1>
    <div class="flex items-center">
        <div class="flex-1">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Dashboard</a>
                <div>/</div>
                <a href="{{ route('admission.applications.index') }}">Applications</a>
                <div>/</div>
                <div>{{ $application->rollno }}</div>
                <div>/</div>
                <div>Edit</div>
            </div>
        </div>
    </div>
    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="w-full md:w-4/5 bg-slate-100 mx-auto p-8 mt-8 shadow-lg">
        <form action="{{route('admission.applications.update', $application)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <!-- student info -->
            <div class="grid md:grid-cols-3 gap-4">
                <h1 class="md:col-span-2"># {{ $application->rollno }} <label for=""><i class="bi-clock ml-2"></i> {{ $application->created_at->diffForHumans() }}</label></h1>
                <div class="photo-upload-wrapper">
                    <div class="photo-box" id="photoPreview">
                        @if($application->photo) <!-- adjust $user or $application as needed -->
                        <img src="{{ asset('storage/' . $application->photo) }}"
                            alt="Current Photo"
                            id="photoImage"
                            class="rounded" width="100" height="100">
                        @else
                        Photo
                        @endif
                    </div>
                    <!-- Custom Upload Button -->
                    <label for="photo" class="custom-file-upload">Upload Your Photo</label>
                    <input type="file" id="photo" name="photo" accept="image/*" onchange="previewSelectedPhoto(event)">
                    <label id="photo-error" class="text-red-500 mt-1 hidden">File size exceeds 1MB.</label>
                </div>
                <div>
                    <label for="">Group</label>
                    <select name="group_id" class="custom-input">
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}" @selected($group->id == $application->group_id)>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="">Application Status</label>
                    <select name="status" id="" class="custom-input">
                        <option value="pending" @selected($application->status=='pending')>Pending</option>
                        <option value="accepted" @selected($application->status=='accepted')>Accepted</option>
                        <option value="rejected" @selected($application->status=='rejected')>Rejected</option>
                        <option value="admitted" @selected($application->status=='admitted')>Admitted</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <label for="">Student Name</label>
                    <input type="text" name="name" class="custom-input" placeholder="Student name" value="{{ $application->name }}">
                </div>
                <div>
                    <label for="">Date of Birth</label>
                    <input type="date" name="dob" class="custom-input" placeholder="Date of birth" value="{{ optional($application->dob)->format('Y-m-d') }}">
                </div>
                <div>
                    <label for="">BForm</label>
                    <input type="text" name="bform" class="custom-input" placeholder="B Form" value="{{ $application->bform }}">
                </div>
                <div>
                    <label for="">Phone No</label>
                    <input type="text" name="phone" class="custom-input" placeholder="Phone No." value="{{ $application->phone }}">
                </div>
                <div class="md:col-span-2">
                    <label for="">Address</label>
                    <input type="text" name="address" class="custom-input" placeholder="Address" value="{{ $application->address }}">
                </div>

                <div>
                    <label for="id_mark">Identification Mark (شناختی علامت)</label>
                    <input type="text" name="id_mark" class="custom-input fancy-focus" placeholder="Identification mark" value="{{ $application->id_mark }}" required>
                </div>

                <div>
                    <label for="caste">Caste (ذات)</label>
                    <select name="caste" class="custom-input fancy-focus" required>
                        @foreach (config('enums.castes') as $value => $label)
                        <option value="{{ $value }}" @selected($application->caste == $value)>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="is_orphan"> Are you orphan (یتیم)? </label>
                    <select name="is_orphan" class="custom-input fancy-focus" required>
                        <option value="0" @selected($application->is_orphan == 0)>No</option>
                        <option value="1" @selected($application->is_orphan == 1)>Yes</option>
                    </select>
                </div>
                <div class="">
                    <label for="">Father Name</label>
                    <input type="text" name="father_name" class="custom-input" placeholder="Father name" value="{{ $application->father_name }}">
                </div>
                <div class="">
                    <label for="">Father Name</label>
                    <input type="text" name="mother_name" class="custom-input" placeholder="Mother name" value="{{ $application->mother_name }}">
                </div>
                <div>
                    <label for="father_cnic">Father/Guardian's CNIC</label>
                    <input type="text" name="father_cnic" class="custom-input fancy-focus" placeholder="Guardian cnic" value="{{ $application->father_cnic }}" required>
                </div>

                <div>
                    <label for="mother_cnic">Mother's CNIC</label>
                    <input type="text" name="mother_cnic" class="custom-input fancy-focus" placeholder="Mother cnic" value="{{ $application->mother_cnic }}" required>
                </div>
                <div>
                    <label for="profession">Profession</label>
                    <select name="profession" class="custom-input fancy-focus" required>
                        @foreach (config('enums.professions') as $value => $label)
                        <option value="{{ $value }}" @selected($application->profession == $value)>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="income">Income</label>
                    <select name="income" class="custom-input fancy-focus" required>
                        @foreach (config('enums.incomes') as $value => $label)
                        <option value="{{ $value }}" @selected($application->income == $value)>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="previous_school">Previous School (سابقہ سکول)</label>
                    <input type="text" name="previous_school" class="custom-input fancy-focus" placeholder="Previous school" value="{{ $application->previous_school }}" required>
                </div>
                <div>
                    <label for="medium">Medium (میٹرک میں زریعہ تعلیم)</label>
                    <select name="medium" class="custom-input fancy-focus" required>
                        <option value="ur" @selected($application->medium=='ur')>Urdu</option>
                        <option value="en" @selected($application->medium=='en')>English</option>
                    </select>
                </div>


                <div>
                    <label for="">Board Name</label>
                    <select name="bise" id="" class="custom-input">
                        @foreach (config('enums.bises') as $value => $label)
                        <option value="{{ $value }}" @selected($application->bise == $value)>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <label for="">Passing Year</label>
                    <select name="pass_year" id="" class="custom-input">
                        <option value="2023" @selected($application->pass_year==2023)>2023</option>
                        <option value="2024" @selected($application->pass_year==2024)>2024</option>
                        <option value="2025" @selected($application->pass_year==2025)>2025</option>
                    </select>
                </div>
                <div>
                    <label for="">Matric Roll No.</label>
                    <input type="number" name="rollno" class="custom-input" placeholder="Roll number" min='0' value="{{ $application->rollno }}">
                </div>
                <div>
                    <label for="">Total Marks</label>
                    <select name="max_marks" id="" class="custom-input">
                        <option value="1000" @selected($application->total==1000)>1000</option>
                        <option value="1050" @selected($application->total==1050)>1050</option>
                        <option value="1100" @selected($application->total==1100)>1100</option>
                        <option value="1150" @selected($application->total==1150)>1150</option>
                        <option value="1200" @selected($application->total==1200)>1200</option>
                    </select>
                </div>
                <div>
                    <label for="">Obtanied Marks</label>
                    <input type="number" name="obtained_marks" class="custom-input" placeholder="Obtained marks" min='0' value="{{ $application->obtained_marks }}">
                </div>
                <div>
                    <label for="">Fee</label>
                    <input type="number" name="amount_paid" value="{{ $application->amount_paid }}" class="custom-input">
                </div>
                <div class="md:col-span-3">
                    <label for="">Rejection Note</label>
                    <input type="text" name="rejection_note" class="custom-input" placeholder="Rejection note" value="{{ $application->rejection_note }}">
                </div>
            </div>
            <div class="text-center mt-8">
                <button class="btn-teal rounded py-3">Update Application</button>
            </div>
        </form>
    </div>

</div>
@endsection
@section('script')
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