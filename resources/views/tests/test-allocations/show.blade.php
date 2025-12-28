@extends('layouts.app')
@section('page-content')
    <h2>{{ $testAllocation->test->title }} Result</h2>
    <div class="bread-crumb">
        <a href="{{ url('/') }}">Home</a>
        <div>/</div>
        <a href="{{ route('tests.index') }}">Tests</a>
        <div>/</div>
        <a href="{{ route('test.test-allocations.index', [$testAllocation->test, $testAllocation]) }}">Subjects</a>
        <div>/</div>
        <div>{{ $testAllocation->subject->short_name }}</div>

    </div>

    <div class="md:w-4/5 mx-auto flex justify-between flex-wrap mt-6 bg-white md:p-8 p-4 rounded border gap-3">
        <div class="flex-1 text-slate-400 text-sm ">
            <h2>{{ $testAllocation->subject->name }} - {{ $testAllocation->section->name }}</h2>
            @if ($testAllocation->result_date)
                <span>Result submitted at: {{ $testAllocation->result_date }}</span>
            @endif
        </div>
        <div class="flex space-x-3 items-center">
            {{-- print button --}}
            <a href="{{ route('subject-result', $testAllocation) }}" target="_blank"
                class="flex justify-center items-center w-8 h-8 btn-teal rounded-full text-xs text-white">
                <i class="bi-printer"></i>
            </a>
            <a href="{{ route('test-allocation.import.index', $testAllocation) }}"
                class="flex justify-center items-center btn-green w-8 h-8 btn-teal rounded-full text-xs text-white"><i
                    class="bi-person-add"></i></a>

            @if ($testAllocation->hasBeenSubmitted())
                <a href="{{ route('test.test-allocations.edit', [$test, $testAllocation]) }}"
                    class="flex justify-center items-center w-8 h-8 btn-blue rounded-full text-xs"><i
                        class="bx  bx-pencil"></i></a>
            @else
                <form action="{{ route('test.test-allocations.destroy', [$test, $testAllocation]) }}" method="POST"
                    onsubmit="confirmDel(event)" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex justify-center items-center w-8 h-8 btn-red rounded-full text-xs">
                        <i class="bi-trash3 text-white"></i>
                    </button>
                </form>
            @endif

        </div>
    </div>

    <div class="md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 rounded border gap-3">
        {{-- search --}}
        <div class="flex justify-end md:justify-between items-center gap-2 flex-wrap">
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>
            @if ($testAllocation->hasBeenSubmitted())
                <form action="{{ route('test-allocation.unlock', $testAllocation) }}" method="post">
                    @csrf
                    @method('patch')
                    <button type="submit"
                        class="flex justify-center items-center w-8 h-8 btn-red rounded-full text-sm text-white"><i
                            class="bi-lock"></i></button>
                </form>
            @else
                @if ($testAllocation->appearingStudents->count())
                    <a href="{{ route('test-allocation.results.edit', [$testAllocation, 0]) }}"
                        class="flex justify-center items-center w-8 h-8 btn-sky rounded-full text-sm text-white"><i
                            class="bx-pencil"></i></a>
                @endif
            @endif
        </div>


        <!-- error message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="text-slate-500 text-sm mt-6 text-right">Max. Marks: {{ $testAllocation->max_marks }} </div>
        <div class="overflow-x-auto w-full mt-2">
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
        <!-- dont show final submission if no student -->
        @if (!$testAllocation->hasBeenSubmitted() && $testAllocation->appearingStudents->count())
            <div class="md:w-2/3 mx-auto mt-8 text-center">
                <h3 class="text-red-600">Please note!</h3>
                <p>Once you have finished result, please make final submission as a last & necessary step. Remember, after
                    final, the result will be locked </p>
                <form action="{{ route('test-allocation.lock', $testAllocation) }}" method="post"
                    class="mt-6 text-center">
                    @csrf
                    @method('patch')
                    <button type="submit" class="btn-red rounded p-2 px-5 text-sm">Make Final Submission</button>
                </form>
            </div>
        @endif
    @endsection
    @section('script')
        <script type="text/javascript">
            function search(event) {
                var searchtext = event.target.value.toLowerCase();
                var str = 0;
                $('.tr').each(function() {
                    if (!(
                            $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                        )) {
                        $(this).addClass('hidden');
                    } else {
                        $(this).removeClass('hidden');
                    }
                });
            }

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
