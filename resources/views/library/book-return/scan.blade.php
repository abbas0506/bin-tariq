@extends('layouts.library')
@section('page-content')
    <div class="custom-container">
        <h2>Return Book</h2>
        <div class="bread-crumb">
            <a href="{{ url('library') }}">Dashoboard</a>
            <div>/</div>
            <div>Return Book</div>
        </div>
        <div class="h-96 flex justify-center items-center">


            <div class="w-full md:w-1/2 mx-auto">
                <!-- page message -->
                @if ($errors->any())
                    <x-message :errors='$errors'></x-message>
                @else
                    <x-message></x-message>
                @endif

                <form action="{{ route('library.book-return.scan') }}" method='post' class="mt-4"
                    onsubmit="return validate(event)">
                    @csrf
                    <div id="reader" class="w-64 md:w-80 mx-auto"></div>
                    <div class="relative">
                        <i class="bx  bx-book absolute right-2 top-4"></i>
                        <input type="text" id='book_ref' name='book_ref' class="custom-input" placeholder="Scan here"
                            value="">
                    </div>
                    <div class="flex mt-4 float-right">
                        <button type="submit" class="btn-teal rounded px-4">Next</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="module">
        $(document).ready(function() {
            Html5Qrcode.getCameras().then(devices => {
                /**
                 * devices would be an array of objects of type:
                 * { id: "id", label: "label" }
                 */
                if (devices && devices.length) {
                    var cameraId = devices[0].id;
                    // .. use this to start scanning.
                    const html5QrCode = new Html5Qrcode( /* element id */ "reader");
                    html5QrCode.start(
                            cameraId, {
                                fps: 4, // Optional, frame per seconds for qr code scanning
                                qrbox: {
                                    width: 200,
                                    height: 200
                                },
                                // Optional, if you want bounded box UI
                                videoConstraints: {
                                    facingMode: {
                                        exact: "environment" //use back camera
                                    },
                                },
                            },
                            (decodedText, decodedResult) => {
                                // do something when code is read
                                // $('#book_ref').val(decodedText);
                                console.log(decodedText);
                            },
                            (errorMessage) => {
                                // parse error, ignore it.
                                console.log('error');
                            })
                        .catch((err) => {
                            // Start failed, handle it.
                            console.log('camera not opened')
                        });

                }
            }).catch(err => {
                // handle err
            });


        });

        function validate(event) {

            var bookRef = $('#book_ref').val();
            var bookRegex = /^[A-E][0-9]-[0-9]{4}-[0-9]{1,2}$/;

            if (!bookRegex.test(bookRef)) {
                event.preventDefault();
                Swal.fire({
                    title: "Book Ref?",
                    text: "Invalid format",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500

                });
                return false;
            } else {
                //validated
                return true;
            }
        }
    </script>
@endsection
