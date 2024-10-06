@extends('backend.layouts.master')
@section('title', __('whatsApp_settings'))
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="section-title">{{ __('whatsApp_settings') }}</h3>
				<div class="default-tab-list default-tab-list-v2  bg-white redious-border p-20 p-sm-30 mb-4">
					@if (whatsappConnected())
						<div class="alert alert-success" role="alert">
							{{__('success_!_you_are_now_connected_to_whatsapp_cloud_api')}}
						</div>
					@else
						<div class="alert alert-danger" role="alert">
							{{__('not_connected!_please_complete_all_the_steps_in_order_to_connect_to_whatsapp_cloud_api')}}
						</div>
					@endif

					@if (!isWhatsAppWebhookConnected())
						<div class="alert alert-danger" role="alert">
							<strong>{{ __('oops') }}</strong> {{ __('whatsapp_webhook_not_connected') }}<br>
							<small>{{ __('real_time_updates_will_not_be_available_until_the_webhook_is_connected') }}</small>
						</div>
					@endif

					<form action="{{ route('client.settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="row row-eq-height mb-3">
							<div class="col-lg-6">
								<div class="card h-100 ">
									<div class="card-header d-flex justify-content-between">
										<h5>{{ __('webhook_config') }}</h5>
										@if (setting('whatsApp_settings_video_url'))
										<a href="#" class="d-flex align-items-center gap-2"
										   data-bs-toggle="modal" data-bs-target="#config_tutorial">
											<i class='lab la-youtube' style='font-size:40px'></i>
										</a>
										@endif
									</div>
									<div class="card-body">
										<div class="mb-4">
											<label for="webhook_callback_url"
											       class="form-label">{{ __('callback_url') }}</label>
											<div class="input-group">
												<input type="url"
												       value="{{ isDemoMode() ? '******************' : route('whatsapp.webhook', @Auth::user()->client->webhook_verify_token) }}"
												       readonly name="webhook_callback_url" class="form-control"
												       placeholder="{{ __('enter_webhook_callback_url') }}"
												       aria-label="{{ __('enter_webhook_callback_url') }}"
												       aria-describedby="webhook_callback_url">
												<span class="input-group-text copy-text" id="webhook_callback_url"><i
															class="la la-copy"></i></span>
											</div>
											<div class="nk-block-des text-danger">
												<p class="first_name_error error">
													{{ $errors->first('webhook_callback_url') }}</p>
											</div>
										</div>
										<div class="mb-4">
											<label for="webhook_verify_token"
											       class="form-label">{{ __('verify_token') }}</label>
											<div class="input-group">
												<input type="url"
												       value="{{ isDemoMode() ? '******************' : old('webhook_verify_token', @Auth::user()->client->webhook_verify_token) }}"
												       readonly name="webhook_verify_token" class="form-control"
												       placeholder="{{ __('enter_webhook_verify_token') }}"
												       aria-label="{{ __('enter_webhook_verify_token') }}"
												       aria-describedby="webhook_verify_token">
												<span class="input-group-text copy-text" id="webhook_verify_token"><i
															class="la la-copy"></i></span>
											</div>
											<div class="nk-block-des text-danger">
												<p class="first_name_error error">
													{{ $errors->first('webhook_verify_token') }}</p>
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="card h-100">
									<div class="card-header">
										<h5>{{__('get_started_with_whatsApp_cloud_api')}}</h5>
									</div>
									<div class="card-body">
										<ul class="list-unstyled">
											<li>1. {{__('whatsApp_cloud_api_line_one')}} <a
														href="https://developers.facebook.com/" class="lern-more" target="_blank">Facebook
													Developer</a>.
											</li>
											<li>2. {{__('whatsApp_cloud_api_line_two')}}</li>
											<li>3. {{__('whatsApp_cloud_api_line_three')}} {{ __('callback_url') }}
												and {{ __('verify_token') }}.
											</li>
											<li>4. {{__('whatsApp_cloud_api_line_four')}}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-6">
								<div class="card h-100">
									<div class="card-header">
										<h5>{{__('whatsApp_access_token')}}</h5>
									</div>
									<div class="card-body">
										<div class="mb-4">
											<label for="access_token" class="form-label">{{__('access_token')}} <span class="text-danger">*</span></label>
											<input type="text" class="form-control rounded-2" id="access_token"
											       name="access_token"
											       value="{{ isDemoMode() ? '******************' : old('access_token', @Auth::user()->client->whatsappSetting->access_token) }}"
											       placeholder="{{ __('enter_access_token') }}">
											<div class="nk-block-des text-danger">
												<p class="access_token_error error">
													{{ $errors->first('access_token') }}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="card h-100">
									<div class="card-header">
										<h5>{{__('get_your_permanent_access_token')}}</h5>
									</div>
									<div class="card-body">
										<ul class="list-unstyled">
											<li>
												1. {{__('follow_the_detailed_process_outlined_in_the_facebook_docs_to_create_a_permanent_access_token')}}
												<a class="lern-more"
														href="https://developers.facebook.com/docs/whatsapp/business-management-api/get-started#1--acquire-an-access-token-using-a-system-user-or-facebook-login"
														target="_blank">{{__('facebook_docs')}}</a></li>
											<li>
												2. {{__('once_you_have_obtained_the_permanent_access_token_enter_it_here')}}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-6">
								<div class="card h-100">
									<div class="card-header">
										<h5>{{__('account_id_and_phone_number_id')}}</h5>
									</div>
									<div class="card-body">
										<div class="mb-4">
											<label for="phone_number_id"
											       class="form-label">{{ __('phone_number_id') }}</label>
											<input type="text" class="form-control rounded-2" id="phone_number_id"
											       name="phone_number_id"
											       value="{{ isDemoMode() ? '******************' : old('phone_number_id', @Auth::user()->client->whatsappSetting->phone_number_id) }}"
											       placeholder="{{ __('enter_phone_number_id') }}">
											<div class="nk-block-des text-danger">
												<p class="phone_number_id_error error">
													{{ $errors->first('phone_number_id') }}</p>
											</div>
										</div>
										<div class="mb-4">
											<label for="business_account_id"
											       class="form-label">{{ __('business_account_id') }} <span class="text-danger">*</span></label>
											<input type="text" class="form-control rounded-2" id="business_account_id"
											       name="business_account_id"
											       value="{{ isDemoMode() ? '******************' : old('business_account_id', @Auth::user()->client->whatsappSetting->business_account_id) }}"
											       placeholder="{{ __('enter_business_account_id') }}">
											<div class="nk-block-des text-danger">
												<p class="business_account_id_error error">
													{{ $errors->first('business_account_id') }}</p>
											</div>
										</div>
										<div class="mb-4">
											<label for="app_id"
											       class="form-label">{{ __('app_id') }}</label>
											<input type="text" class="form-control rounded-2" id="app_id"
											       name="app_id"
											       value="{{ isDemoMode() ? '******************' : old('app_id', @Auth::user()->client->whatsappSetting->app_id) }}"
											       placeholder="{{ __('enter_app_id') }}">
											<div class="nk-block-des text-danger">
												<p class="app_id_id_error error">
													{{ $errors->first('app_id') }}</p>
											</div>
										</div>
										<div class="d-flex justify-content-end align-items-center mt-30 gap-2">
											@if (@Auth::user()->client->whatsappSetting->access_token)
												<button type="button"
												        class="btn btn-danger text-white __js_delete"
												        id="remove_access_token"
												        data-id="{{ @Auth::user()->client->whatsappSetting->id }}"
												        data-url="{{ route('client.whatsAppSettings.remove-token',@Auth::user()->client->whatsappSetting->id) }}"
												>{{ __('remove_whatsapp_setting') }}</button>
											@endif
											<button type="submit"
											        class="btn sg-btn-primary">{{ __('save') }}</button>
											@include('backend.common.loading-btn', [
												'class' => 'btn sg-btn-primary',
											])
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="card h-100">
									<div class="card-header">
										<h5>{{__('get_Your_account_id_and_phone_number_id')}}</h5>
									</div>
									<div class="card-body">
										<ul class="list-unstyled mb-4">
											<li>1. {{__('setting_line_one')}}</li>
											<li>2. {{__('setting_line_two')}}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade modal-lg" id="config_tutorial" tabindex="-1" aria-labelledby="config_tutorial" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="embed-responsive videowrapper">
					<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ getYoutubeVideoId(setting('whatsApp_settings_video_url')) }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>
	<script>
        $(document).ready(function() {
            $('.copy-text').click(function() {
                var inputField = $(this).closest('.input-group').find('input');
                inputField.select();
                document.execCommand("copy");
                toastr.success("{{ __('copied') }}");
            });
        });

        $(document).on('click', '.__js_delete', function () {
            confirmationAlert(
                $(this).data('url'),
                $(this).data('id'),
                'Yes, Delete It!'
            )
        })

        const confirmationAlert = (url, data_id, button_test = 'Yes, Confirmed it!') => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: button_test,
                confirmButtonColor: '#ff0000'
            }).then((confirmed) => {
                if (confirmed.isConfirmed) {
                    axios.post(url, {data_id: data_id})
                        .then(response => {
                            console.log(response);
                            Swal.fire(
                                response.data.message,
                                '',
                                response.data.status == true ? 'success' : 'error',
                            ).then(() => {
                                if (response.data.status == true) {
                                    location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            console.log(error);
                            Swal.fire(...error.response.data);
                        })
                }
            });
        };
	</script>

@endpush
