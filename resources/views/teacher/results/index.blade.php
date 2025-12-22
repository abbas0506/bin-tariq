@extends('layouts.teacher')
@section('page-content')
    <h2>{{ $testAllocation->subject->name }} , {{ $testAllocation->section->fullName() }}</h2>
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
    <div class="p-4 bg-blue-100 border border-blue-200 rounded">
        <h2>How to submit result?</h2>
        <ul class="text-xs list-outside ml-4 mt-3 list-disc">
            <li><span class="font-bold">Step 1: </span>Import Students</li>
            <li><span class="font-bold">Step 2: </span>Feed result</li>
            <li><span class="font-bold">Step 3: </span>Make final submission</li>
        </ul>
    </div>

    <!-- page message -->
    @if ($errors->any())
        <x-message :errors='$errors'></x-message>
    @else
        <x-message></x-message>
    @endif
    <div class="flex flex-wrap justify-between gap-3 items-center mt-8">
        <h2 class="text-center">Appearing Students: <i
                class="bx bx-group mr-2"></i>{{ $testAllocation->appearingStudents->count() }}/{{ $testAllocation->section->students->count() }}
        </h2>

        <div class="flex items-center gap-3">

            <a href="{{ route('teacher.test-allocation.import-students.index', $testAllocation) }}"
                class="btn-blue rounded text-sm py-2 px-4">Import <i class="bi bi-file-earmark-excel"></i></a>
            @if ($testAllocation->appearingStudents->count())
                <a href="{{ route('teacher.test-allocation.results.edit', [$testAllocation, 0]) }}"
                    class="btn-teal rounded text-sm py-2 px-4">Feed Result</i></a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto w-full mt-8">
        <table class="table-fixed borderless w-full">
            <thead>
                <tr>
                    <th class="w-12">Roll #</th>
                    <th class="w-40 text-left">Name </th>
                    <th class="w-12">Marks</th>
                    <th class="w-16">Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testAllocation->results->sortBy('student.rollno') as $result)
                    <tr class="tr">
                        <td>{{ $result->student->rollno }}</td>
                        <td class="text-left">{{ $result->student->name }} <br><span
                                class="text-xs text-slate-400">{{ $result->student->father_name }}</span></td>
                        <td>{{ $result->obtained_marks }}</td>
                        <td>
                            <form
                                action="{{ route('teacher.test-allocation.results.destroy', [$testAllocation, $result]) }}"
                                method="post" onsubmit="return confirmDel(event)">
                                @csrf
                                @method('DELETE')
                                <button><i class="bi-x text-red-600"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- dont show final submission if no student -->
    @if ($testAllocation->appearingStudents->count())
        <div class="md:w-2/3 mx-auto mt-8 text-center">
            <h3 class="text-red-600">Please note!</h3>
            <p>After feeding complete result, you need to make final submission as a last step. Use this option only when
                you are sure about the result. Once submitted, result will not remain editable for this subject.</p>
            <form action="{{ route('teacher.test.test-allocations.update', [$testAllocation->test, $testAllocation]) }}"
                method="post" class="mt-6 text-center">
                @csrf
                @method('patch')
                <button type="submit" class="btn-red rounded p-2 px-5 text-sm">Make Final Submission</button>
            </form>
        </div>
    @endif
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
