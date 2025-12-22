@extends('layouts.admin')

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
        <h1>Edit Student</h1>
        <div class="flex items-center">
            <div class="flex-1">
                <div class="bread-crumb">
                    <a href="{{ url('/') }}">Dashboard</a>
                    <div>/</div>
                    <a href="{{ route('admin.teachers.index') }}">Teachers</a>
                    <div>/</div>
                    <div>{{ $teacher->id }}</div>
                    <div>/</div>
                    <div>Edit</div>
                </div>
            </div>
        </div>
        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif


        <form action="{{ route('admin.teachers.update', $teacher) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @csrf
            <div class="photo-upload-wrapper">
                <!-- Placeholder Photo Box -->
                <div class="photo-box" id="photoPreview">
                    @if ($teacher->photo)
                        <!-- adjust $user or $student as needed -->
                        <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Current Photo" id="photoImage"
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
            <div class="w-full md:w-4/5 mx-auto p-8 mt-8 border rounded">
                <!-- page error message -->
                @if ($errors->any())
                    <x-message :errors='$errors'></x-message>
                @else
                    <x-message></x-message>
                @endif

                <!-- <hr class="mt-3"> -->
                <div class="grid md:grid-cols-2 gap-3">
                    <h2 class="col-span-full mb-3 text-decoration underline">Basic Info</h2>
                    <div class="md:col-span-2">
                        <label for="">Name <i class="bi-person"></i></label>
                        <input type="text" name="name" class="custom-input fancy-focus" placeholder="Your good name"
                            value="{{ $teacher->name }}" required>
                    </div>
                    <div class="">
                        <label for="">Short Name</label>
                        <input type="text" name="short_name" class="custom-input fancy-focus" placeholder="Short name"
                            value="{{ $teacher->short_name }}" required>
                    </div>
                    <div class="">
                        <label for="">Father Name</label>
                        <input type="text" name="father_name" class="custom-input fancy-focus" placeholder="Father name"
                            value="{{ $teacher->father_name }}" required>
                    </div>
                    <div>
                        <label for="">CNIC <i class="bi-person-vcard"></i></label>
                        <input type="text" name="cnic" id='cnic' class="custom-input fancy-focus cnic"
                            placeholder="Type your CNIC" value="{{ $teacher->cnic }}" required>
                    </div>
                    <div>
                        <label for="dob">Date of Birth (mm/dd/yyyy) <i class="bi-clock"></i></label>
                        <input type="date" name="dob" class="custom-input fancy-focus"
                            value="{{ optional($teacher->dob)->format('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label for="">Email <i class="bi-at"></i></label>
                        <input type="email" name="email" id='email' class="custom-input fancy-focus"
                            placeholder="Email" value="{{ $teacher->user?->email }}">
                    </div>
                    <div>
                        <label for="">Personal Phone No <i class="bi-whatsapp"></i></label>
                        <input type="text" name="phone" id='phone' class="custom-input fancy-focus phone"
                            placeholder="Personal Phone" value="{{ $teacher->phone }}" required>
                    </div>
                    {{-- <div>
                    <label for="">Official Phone No <i class="bi-telephone"></i></label>
                    <input type="text" name="official_phone" id='phone' class="custom-input fancy-focus phone" placeholder="Official Phone" value="{{ $teacher->official_phone }}">
                </div> --}}
                    <div class="md:col-span-2">
                        <label for="">Home Address <i class="bi-house"></i></label>
                        <input type="text" name="address" id='address' class="custom-input fancy-focus"
                            placeholder="Address" value="{{ $teacher->address }}" required>
                    </div>

                    <div>
                        <label for="blood_group">Blood Group <i class="bi-droplet"></i></label>
                        <input type="text" name="blood_group" class="custom-input fancy-focus" placeholder="e.g A+"
                            value="{{ $teacher->blood_group }}">
                    </div>

                    <div>
                        <label for="qualification">Qualification <i class="bi-layers"></i></label>
                        <input type="text" name="qualification" class="custom-input fancy-focus"
                            placeholder="e.g MA Urdu" value="{{ $teacher->qualification }}">
                    </div>

                    <div>
                        <label for="designation">Designation</label>
                        <input type="text" name="designation" class="custom-input fancy-focus"
                            placeholder="e.g SST(Arts)" value="{{ $teacher->designation }}" required>
                    </div>
                    <div>
                        <label for="bps">BPS</label>
                        <select name="bps" class="custom-input fancy-focus" required>
                            <option value="">Select ...</option>
                            <option value="04" @selected($teacher->bps == 04)>04</option>
                            <option value="14" @selected($teacher->bps == 14)>14</option>
                            <option value="15" @selected($teacher->bps == 15)>15</option>
                            <option value="16" @selected($teacher->bps == 16)>16</option>
                            <option value="17" @selected($teacher->bps == 17)>17</option>
                            <option value="18" @selected($teacher->bps == 18)>18</option>
                            <option value="19" @selected($teacher->bps == 19)>19</option>
                            <option value="20" @selected($teacher->bps == 20)>20</option>

                        </select>
                    </div>
                    <div>
                        <label for="dob">Working Since (mm/dd/yyyy) <i class="bi-clock"></i></label>
                        <input type="date" name="joined_at" class="custom-input fancy-focus"
                            value="{{ optional($teacher->joined_at)->format('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label for="personal_no">Personal # <i class="bi-numeric"></i></label>
                        <input type="text" name="personal_no" class="custom-input fancy-focus"
                            placeholder="Personal No." value="{{ $teacher->personal_no }}" required>
                    </div>
                    <div class="flex justify-end space-x-3 text-center mt-8 md:col-span-2">
                        <a href="{{ url('/') }}" class="btn-gray rounded py-3 px-5">Cancel <i
                                class="bi-x text-white"></i></a>
                        <button class="btn-blue rounded py-3 px-5">Submit <i class="bi-check"></i></button>
                    </div>
                </div>
        </form>
    </div>
    {{-- roles --}}
    <div class="md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 rounded border relative">
        <form action="{{ route('admin.user.roles.update', [$teacher->user, 1]) }}" method='post' class="">
            @csrf
            @method('PATCH')
            <h2 class="md:col-span-2 text-decoration underline mb-3">Assigned Roles</h2>
            <div class="grid gap-1">
                @foreach ($roles as $role)
                    <div class="flex item checkable-row">
                        <label for="role{{ $role->id }}"
                            class="text-base hover:cursor-pointer text-slate-800 text-left py-1 flex-1">{{ ucfirst($role->name) }}</label>
                        <input type="checkbox" id='role{{ $role->id }}' name='role_names_array[]'
                            class="custom-input w-4 h-4 rounded" value="{{ $role->name }}"
                            @checked($teacher->user->hasRole($role->name))>
                        <i class="bx bx-check"></i>
                    </div>
                @endforeach
            </div>

            <div class="md:col-span-2 text-right mt-4">
                <button type="submit" class="btn-green rounded">Update</button>
            </div>
        </form>
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
        const form = document.getElementById('studentForm');
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
