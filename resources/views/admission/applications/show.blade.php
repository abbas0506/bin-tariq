@extends('layouts.admission')

@section('page-content')
    <div class="custom-container">
        <!-- Title     -->
        <h1>Applications</h1>

        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <a href="{{ route('admission.applications.index') }}">Applications</a>
            <div>/</div>
            <div>{{ $application->rollno }}</div>
            <div>/</div>
            <div>View</div>
        </div>

        <div class="container grid gap-4 px-5 relative mt-3 shadow-lg md:w-2/3 mx-auto  p-8 rounded-lg">
            <div>
                @if ($errors->any())
                    <x-message :errors='$errors'></x-message>
                @else
                    <x-message></x-message>
                @endif
            </div>
            <div class="absolute top-2 right-2">
                <div class="flex items-center justify-center space-x-2">
                    @if ($application->status != 'pending')
                        <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                            <form action="{{ route('admission.applications.destroy', $application) }}" method="post"
                                onsubmit="return confirmDel(event)">
                                @csrf
                                @method('DELETE')
                                <button><i class="bx  bx-trash text-red-600"></i></button>
                            </form>
                        </div>

                        <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                            <a href="{{ route('admission.applications.edit', $application) }}"><i
                                    class="bx  bx-pencil text-green-600"></i></a>
                        </div>
                    @endif
                    <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                        <a href="{{ route('admission.applications.index') }}"><i class="bi-x-lg"></i></a>
                    </div>
                </div>
            </div>

            <!-- display info -->
            <div class="grid md:grid-cols-3 mt-8 gap-4">
                <div class="grid md:col-span-2 gap-3 order-2 md:order-1">
                    <div>
                        <label for="">Application # <span class="text-red-600 font-bold"> (
                                {{ $application->status }} )</span></label>
                        <div class="flex flex-wrap items-center gap-x-4">
                            <h2>{{ $application->rollno }}</h2>
                            <label>submitted on {{ $application->created_at->addHours(5) }}</label>
                        </div>
                    </div>
                    <div>
                        <label for="">Personal Info</label>
                        <p>{{ $application->name }}</p>
                        <p class="text-slate-600 text-sm"><i
                                class="bi-balloon"></i>{{ $application->dob->format('d-m-Y') }} <i
                                class="bi-card-heading ml-2"></i> {{ $application->bform }} <i
                                class="bi-telephone ml-2"></i> {{ $application->phone }}</p>
                        <p class="text-slate-600 text-sm">{{ $application->id_mark }} </p>
                        <p class="text-slate-600 text-sm">{{ $application->address }} </p>
                    </div>
                    <div>
                        <label for="">Father / Guardian Info</label>
                        <p>{{ $application->father_name }} </p>
                        <p class="text-slate-600 text-sm">{{ $application->father_cnic }} </p>
                        <p class="text-slate-600 text-sm">{{ $application->caste }} / {{ $application->profession }} </p>
                        <p class="text-slate-600 text-sm"><i class="bi-currency"></i>{{ $application->income }} </p>
                    </div>
                    <div>
                        <label for="">Group</label>
                        <p>{{ $application->group->name }}</p>
                    </div>
                    <div>
                        <label for="">Academic Info</label>
                        <p>BISE {{ $application->bise }}, #{{ $application->rollno }} ({{ $application->pass_year }}),
                            &nbsp &nbsp {{ $application->obtained_marks }}/{{ $application->max_marks }} (
                            {{ $application->obtained_percentage() }} % )</p>
                        <p class="text-slate-600 text-sm">{{ $application->previous_school }}</p>
                    </div>
                    @if ($application->status == 'admitted')
                        <div>
                            <label for="">Fee</label>
                            <p>{{ $application->amount_paid }} @if ($application->fee_concession > 0)
                                    <span class="text-sm">( fee_concession: {{ $application->fee_concession }} )</span>
                                @endif <label> <i class="bi-clock ml-2"></i>
                                    {{ $application->payment_date?->diffForHumans() ?? '' }} </label></p>
                        </div>
                    @endif
                    @if ($application->status == 'rejected')
                        <div>
                            <label for="">Rejection Note</label>
                            <p>{{ $application->rejection_note }} </p>
                        </div>
                    @endif

                    <div class="flex items-center mt-4 space-x-4">
                        @if ($application->status == 'pending')
                            <form action="{{ route('admission.applications.accept', $application->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-green px-5 rounded-full">Accept</button>
                            </form>
                            <button type="button" id="openRejectModal" class="btn btn-red px-5 rounded-full"
                                data-bs-toggle="modal" data-bs-target="#rejectModal">
                                Reject
                            </button>
                        @elseif($application->status == 'accepted')
                            <button type="button" id='openFeeModal' class="btn-green px-5 rounded-full"
                                data-bs-toggle="modal" data-bs-target="#feeModal">Get Fee</button>
                            <button type="button" id="openRejectModal" class="btn btn-red px-5 rounded-full"
                                data-bs-toggle="modal" data-bs-target="#rejectModal">Reject</button>
                        @elseif($application->status == 'rejected')
                            <form action="{{ route('admission.applications.accept', $application->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-green px-5 rounded-full">Accept</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <div>
                        <img src="{{ asset('storage/' . $application->photo) }}" alt="Student Photo" width="100"
                            height="100">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md md:w-3/4 mx-auto p-4 relative">
            <h2 class="text-lg font-semibold mb-4">Reason</h2>
            <form id='rejectApplicationForm' action="{{ route('admission.applications.reject', $application->id) }}"
                method="POST">
                @csrf
                @method('PATCH')
                <textarea id="rejection_note" name='rejection_note' rows="2" class="w-full p-2 border border-gray-300 rounded"
                    placeholder="Enter reason..."></textarea>
                <div class="flex justify-end mt-3">
                    <button type="submit" class="btn-red px-5 rounded-full">Reject</button>
                </div>
            </form>
            <button id="closeRejectionModal"
                class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl">&times;</button>
        </div>
    </div>

    <!-- fee payment modeal -->
    <div id="feeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md md:w-1/3 mx-auto p-5 relative">
            <h2 class="text-lg font-semibold">Fee Collection</h2>
            <form action="{{ route('admission.applications.admit', $application) }}" method="post" class="mt-3">
                @csrf
                @method('PATCH')
                <input type="number" name='amount_paid' class="custom-input fancy-input" placeholder="Amount"
                    min="5000" max=5200 value="{{ $application->group->admission_fee }}">
                <button type="submit" class="btn-green px-5 rounded-full mt-4 float-right">Collect</button>
            </form>
            <button id="closeFeeModal"
                class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl">&times;</button>
        </div>
    </div>
@endsection

@section('script')
    <script type="module">
        $(document).ready(function() {
            $('#openRejectModal').on('click', function() {
                $('#rejectModal').removeClass('hidden').addClass('flex');
            });
            $('#openFeeModal').on('click', function() {
                $('#feeModal').removeClass('hidden').addClass('flex');
            });

            $('#closeRejectionModal').on('click', function() {
                $('#rejectModal').removeClass('flex').addClass('hidden');
            });

            $('#closeFeeModal').on('click', function() {
                $('#feeModal').removeClass('flex').addClass('hidden');
            });

            $('#rejectApplicationForm').on('submit', function(e) {
                const note = $('#rejection_note').val();
                if (!note.trim()) {
                    e.preventDefault()
                    alert('Please enter a rejection note.');
                }

                $('#rejectModal').removeClass('flex').addClass('hidden');
            });
        });
    </script>
@endsection
