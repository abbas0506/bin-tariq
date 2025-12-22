@extends('layouts.basic')
@section('title', 'Signup')
@section('body')

    <div class="grid min-h-screen place-items-center p-5 bg-gradient-to-b from-blue-50 via-white to-blue-100">

        <!-- <div><img src="{{ url('images/small/key.png') }}" alt="key" class="w-32"></div> -->
        <div class="grid place-items-center w-full md:w-1/2 mx-auto">
            <img src="{{ asset('images/logo/dark_green.png') }}" alt="" class="w-24 md:w-36 mx-auto">
            <!-- <h2 class="text-xl font-bold mt-6">SIGN UP</h2> -->
            <!-- <label for="">https://www.ghsscb.edu.pk</label> -->

            <form action="{{ route('signup.store') }}" method="post" class="w-full mt-3">
                @csrf

                <!-- page message -->
                @if ($errors->any())
                    <x-message :errors='$errors'></x-message>
                @else
                    <x-message></x-message>
                @endif

                <div class="grid md:grid-cols-2 gap-2 mt-3">
                    <div class="col-span-full">
                        <label for="">Your Name</label>
                        <div class="flex items-center w-full relative">
                            <i class="bi bi-person absolute left-2 text-slate-600"></i>
                            <input type="text" id="name" name="name" class="w-full custom-input px-8"
                                placeholder="Your name">
                        </div>
                    </div>
                    <div>
                        <label for="">Email</label>
                        <div class="flex items-center w-full relative">
                            <i class="bi bi-at absolute left-2 text-slate-600"></i>
                            <input type="text" id="email" name="email" class="w-full custom-input px-8"
                                placeholder="Email address">
                        </div>
                    </div>
                    <div>
                        <label for="">CNIC (without dashes)</label>
                        <div class="flex items-center w-full relative">
                            <i class="bi bi-person-vcard absolute left-2 text-slate-600"></i>
                            <input type="text" id="cnic" name="cnic" class="w-full custom-input px-8"
                                placeholder="Without dashes">
                        </div>
                    </div>
                    <div>
                        <label for="">Designation</label>
                        <div class="flex items-center w-full relative">
                            <i class="bi bi-layers absolute left-2 text-slate-600"></i>
                            <input type="text" id="bps" name="designation" class="w-full custom-input px-8"
                                placeholder="e.g SS, SST, EST">
                        </div>
                    </div>

                    <div>
                        <label for="" class="text-red-600">What is the answer of
                            {{ $numA }}+{{ $numB }}=?</label>
                        <input type="text" name="secret_code" class="custom-input">
                    </div>
                    <input type="hidden" name="num_a" value="{{ $numA }}">
                    <input type="hidden" name="num_b" value="{{ $numB }}">
                </div>
                <div class="mt-8 text-center">
                    <button type="submit" class="btn-teal rounded px-4 p-2">Sign Up Now</button>
                </div>

            </form>
            <div class="text-center text-sm mt-3">
                I have an account?<a href="{{ url('login') }}" class="font-bold ml-2 link">Login</a>
            </div>
        </div>
    </div>




@endsection

@section('script')
    <script type="module">
        $(document).ready(function() {
            $('.bi-eye-slash').click(function() {
                $('#password').prop({
                    type: "text"
                });
                $('.eye-slash').hide()
                $('.eye').show();
            })
            $('.bi-eye').click(function() {
                $('#password').prop({
                    type: "password"
                });
                $('.eye-slash').show()
                $('.eye').hide();
            })

        });
    </script>

@endsection
