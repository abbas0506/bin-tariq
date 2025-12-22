@extends('layouts.teacher')
@section('page-content')
    <h2>{{ $testAllocation->section->fullName() }}</h2>
    <div class="bread-crumb">
        <a href="{{ url('/') }}">Home</a>
        <div>/</div>
        <a href="{{ route('teacher.tests.index') }}">Tests</a>
        <div>/</div>
        <a href="{{ route('teacher.test.test-allocations.index', $testAllocation->test) }}">Subjects</a>
        <div>/</div>
        <div>Results</div>
    </div>

    <div class="divider my-3"></div>

    <div class="flex flex-row items-center gap-x-2">
        <i class="bi bi-info-circle text-2xl w-8"></i>
        <ul class="text-sm">
            <li>Subject result has been locked. If you want any change, contact admin </li>
        </ul>
    </div>
    <div class="divider my-3"></div>
    <!-- page message -->
    @if ($errors->any())
        <x-message :errors='$errors'></x-message>
    @else
        <x-message></x-message>
    @endif
    <div class="flex flex-wrap justify-between gap-3 items-center mt-8">
        <div>
            <h2 class="text-teal-600">{{ $testAllocation->test->title }}</h2>
            <p>{{ $testAllocation->subject->name }} - {{ $testAllocation->section->grade }}</p>
        </div>

        <a href="{{ route('shared.test-allocation.result.print', $testAllocation) }}" target="_blank"
            class="flex justify-center items-center w-12 h-12 rounded-full bg-blue-100">
            <i class="bi-printer text-blue-600"></i>
        </a>
    </div>

    <div class="overflow-x-auto w-full mt-8">
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
                        <td>{{ $result->obtained_marks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function confirmDel(event) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        }
    </script>
@endsection
