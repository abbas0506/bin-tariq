@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <h2>Books</h2>
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div class="bread-crumb">
            <a href="{{url('library')}}">Dashoboard</a>
            <div>/</div>
            <div>Domains / Books ( {{ $books->count() }} ) </div>
        </div>

        <a href="" class="btn-orange rounded">Search <i class="bi-search"></i></a>

    </div>


    <div class="mt-12 bg-white p-5 md:p-8 relative">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        @php $sr=1; @endphp
        <div class="overflow-x-auto w-full mt-2">
            <table class="table-fixed borderless w-full">
                <thead>
                    <tr class="">
                        <th class="w-8">Sr</th>
                        <th class="w-40 text-left">Domain / Category</th>
                        <th class="w-12"></th>
                        <th class="w-12">Books</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($domains->sortByDesc('updated_at') as $domain)
                    <tr class="tr">

                        <td>{{$sr++}}</td>
                        <td class="text-left">
                            <a href="{{route('library.domain.books.index', $domain)}}" class="link">{{$domain->name}}</a>
                        </td>
                        <td class="text-xs text-green-600">@if($domain->books()->createdToday()->count()) <i class="bi-arrow-up"></i>{{ $domain->books()->createdToday()->count() }} @endif</td>
                        <td>{{$domain->books->count()}} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function search(event) {
        // var searchtext = event.target.value.toLowerCase();
        var searchtext = $('#searchby').val().toLowerCase();
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

    function toggleFilterSection() {
        $('#filterSection').slideToggle().delay(500);
    }
</script>
@endsection