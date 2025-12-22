@extends('layouts.teacher')
@section('page-content')
    <h2>Class {{ $testAllocation->section->fullName() }}</h2>
    <div class="bread-crumb">
        <a href="{{ url('/') }}">Home</a>
        <div>/</div>
        <a href="{{ route('teacher.tests.index') }}">Tests</a>
        <div>/</div>
        <a href="{{ route('teacher.test.test-allocations.index', $testAllocation->test) }}">Subjects</a>
        <div>/</div>
        <a href="{{ route('teacher.test-allocation.results.index', $testAllocation) }}">Result</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle text-2xl w-8"></i>
        <ul class="text-sm">
            <li>If student absent, leave the marks blank</li>
            <li>If some student is missing, go back and import the student from his respective class</li>
        </ul>
    </div>
    <!-- page message -->
    @if ($errors->any())
        <x-message :errors='$errors'></x-message>
    @else
        <x-message></x-message>
    @endif

    <form action="{{ route('teacher.test-allocation.results.update', [$testAllocation, 1]) }}" method="post"
        onsubmit="return validate(event)">
        @csrf
        @method('patch')
        <div class="flex flex-wrap items-center gap-x-16 gap-y-3 mt-8">
            <h2 class="text-teal-600">{{ $testAllocation->subject->name }}, {{ $testAllocation->section->fullName() }}</h2>
            <div class="flex space-x-3 items-center">
                <h3 class="text-red-600">Total Marks *</h3>
                <input type="number" id="max_marks" name="max_marks" value="{{ $testAllocation->max_marks }}"
                    class="custom-input-borderless w-16 h-8 text-center px-0" min='0' max='100'>
            </div>
        </div>
        <div class="overflow-x-auto w-full mt-6">
            <table class="table-fixed borderless w-full">
                <thead>
                    <tr>
                        <th class="w-12">Roll #</th>
                        <th class="w-40 text-left">Name</th>
                        <th class="w-12">Marks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testAllocation->results->sortBy('student.rollno') as $result)
                        <tr class="tr">
                            <td>{{ $result->student->rollno }}</td>
                            <td class="text-left">{{ $result->student->name }}<br><span
                                    class="text-xs text-slate-400">{{ $result->student->father_name }}</span></td>
                            <td>
                                <input type="text" name="result_ids_array[]" value="{{ $result->id }}" hidden>
                                <input type="number" name="obtained_marks_array[]" value="{{ $result->obtained_marks }}"
                                    class="custom-input-borderless w-16 h-8 text-center px-0 obtained-marks" min='0'
                                    max='100' onclick="selectMe(event)">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="divider my-3"></div>
        <div class="text-center">
            <button type="submit" class="btn-blue py-2 px-4">Update Now</button>
        </div>
    </form>
@endsection
@section('script')
    <script>
        function selectMe(event) {
            event.target.select()
        }

        function validate(event) {
            const maxMarks = parseFloat(document.getElementById('max_marks').value);
            const inputs = document.querySelectorAll('.obtained-marks');

            for (let i = 0; i < inputs.length; i++) {
                const obtained = parseFloat(inputs[i].value);

                if (obtained > maxMarks) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Marks',
                        text: `Obtained marks (${obtained}) > maximum marks.`,
                        confirmButtonText: 'Fix it'
                    }).then(() => {
                        inputs[i].focus();
                        inputs[i].select();
                    });

                    return false; // ❌ stop submission
                }
            }

            return true; // ✅ submit form
        }
    </script>
@endsection
