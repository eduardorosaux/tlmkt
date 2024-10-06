<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{__('login')}}</title>
    <!--====== LineAwesome ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/line-awesome.min.css') }}">
    <!--====== Dropzone CSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/dropzone.min.css') }}">
    <!--====== Summernote CSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/summernote-lite.min.css') }}">
    <!--====== Choices CSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/choices.min.css') }}">
    <!--====== AppCSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/app.css') }}">
    <!--====== ResponsiveCSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/css/toastr.min.css') }}">
</head>
<body>
<section class="signup-section">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-8 col-sm-10 position-relative">

                <img src="{{ static_asset('admin/img/shape/rect.svg') }}" alt="Rect Shape" class="bg-rect-shape">
                <img src="{{ static_asset('admin/img/shape/circle.svg') }}" alt="Rect Shape" class="bg-circle-shape">
                <img src="{{ static_asset('admin/img/shape/circle-block.svg') }}" alt="Rect Shape" class="bg-circle-block-shape">

                <div class="login-form bg-white rounded-20">
                    <div class="logo d-flex justify-content-center items-center mb-4">
                        <a  href="{{url('/')}}">
                            <img style="max-height: 35px" src="{{ setting('light_logo') && @is_file_exists(setting('light_logo')['original_image']) ? get_media(setting('light_logo')['original_image']) : getFileLink('80x80',[]) }}" alt="Corporate Logo">
                        </a>
                    </div>
                        <div class="form-title text-align-center m-b-40">
                            <h3 class="m-0 text-uppercase">{{__('confirm_your_mail') }}</h3>
                            <p>{{__('forget_password_hints') }} {{ $email }}</p>
                        </div>
                        <form action="{{ route('confirm.password.otp-submit') }}" method="get" class="form otp-form needs-validation" novalidate>
                            @csrf
                            <div class="row text-center justify-content-center gx-3" dir="ltr">
                                <div class="col">
                                    <input type="number" required value="{{ $otp_array[0] }}" name="first">
                                    @if($errors->has('first'))
                                        <div class="nk-block-des text-danger">
                                            <p>{{ $errors->first('first') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <input type="number" required value="{{ $otp_array[1] }}" name="second">
                                    @if($errors->has('second'))
                                        <div class="nk-block-des text-danger">
                                            <p>{{ $errors->first('second') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <input type="number" required value="{{ $otp_array[2] }}" name="third">
                                    @if($errors->has('third'))
                                        <div class="nk-block-des text-danger">
                                            <p>{{ $errors->first('third') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <input type="number" required value="{{ $otp_array[3] }}" name="fourth">
                                    @if($errors->has('fourth'))
                                        <div class="nk-block-des text-danger">
                                            <p>{{ $errors->first('fourth') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <button class="template-btn m-t-sm-30 m-t-55 m-b-30" type="submit">{{__('verify') }}</button>
                                    @if($errors->has('email'))
                                        <div class="nk-block-des text-danger">
                                            <p>{{ $errors->first('email') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="forgot-pass-btn m-b-20">
                                        {{__('do_not_received_the_otp_code') }}? <a href="#">{{__('resend_otp') }}.</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
</body>
</html>
