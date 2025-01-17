@extends('backend.layouts.master')
@section('title', __('onesignal_notification'))
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col col-lg-6 col-md-9">
                <div class="section-top">
                    <h6 class="section-title">{{ __('onesignal_notification') }}</h6>
                    <div class="d-flex gap-20">
                        <button type="button" class="btn sg-btn-primary"
                            id="check_onesignal_credentials">{{ __('check_onesignal_credentials') }}</button>
                        <button type="button" class="btn sg-btn-primary"
                            id="test_onesignal_notification">{{ __('test_onesignal_notification') }}</button>
                    </div>
                </div>
                <div class="bg-white redious-border pt-30 p-20 p-sm-30">
                    <form action="{{ route('onesignal.notification') }}" method="post" class="form">@csrf
                        <div class="row gx-20">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="d-flex gap-12 sandbox_mode_div mb-4">
                                        <input type="hidden" name="is_onesignal_active"
                                            value="{{ setting('is_onesignal_active') == 1 ? 1 : 0 }}">
                                        <label class="form-label" for="is_onesignal_active">{{ __('status') }}</label>
                                        <div class="setting-check">
                                            <input type="checkbox" value="1" id="is_onesignal_active"
                                                class="sandbox_mode"
                                                {{ setting('is_onesignal_active') == 1 ? 'checked' : '' }}>
                                            <label for="is_onesignal_active"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="onesignal_app_id" class="form-label">{{ __('app_id') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-2" id="onesignal_app_id"
                                        name="onesignal_app_id" placeholder="{{ __('enter_app_id') }}"
                                        value="{{ isDemoMode() ? '******************' : setting('onesignal_app_id') }}">
                                    <div class="nk-block-des text-danger">
                                        <p class="onesignal_app_id_error error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="onesignal_rest_api_key" class="form-label">{{ __('rest_api_key') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-2" id="onesignal_rest_api_key"
                                        name="onesignal_rest_api_key" placeholder="{{ __('enter_rest_api_key') }}"
                                        value="{{ isDemoMode() ? '******************' : setting('onesignal_rest_api_key') }}">
                                    <div class="nk-block-des text-danger">
                                        <p class="onesignal_rest_api_key_error error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="safari_web_id" class="form-label">{{ __('safari_web_id') }}</label>
                                    <input type="text" class="form-control rounded-2" id="safari_web_id"
                                        name="safari_web_id" placeholder="{{ __('enter_safari_web_id') }}"
                                        value="{{ isDemoMode() ? '******************' : setting('safari_web_id') }}">
                                    <div class="nk-block-des text-danger">
                                        <p class="safari_web_id_error error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-30">
                            <button type="submit" class="btn sg-btn-primary">{{ __('submit') }}</button>
                            @include('backend.common.loading-btn', ['class' => 'btn sg-btn-primary'])
                        </div>
                    </form>
                    <span class="text-center d-block">{{ __("if_doesn't_have_an_onesignal_account_yet?") }} <a
                            href="https://onesignal.com/" target="_blank"
                            class="sg-text-primary">{{ __('click_here') }}</a></span>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>
        <script src="{{ static_asset('admin/js/custom/onesignal.js') }}"></script>
        <script>
            var test_onesignal = "{{ route('admin.test.onesignal.notification') }}";
            var check_credentials = "{{ route('admin.check.onesignal.credentials') }}";
        </script>
    @endpush
@endsection
