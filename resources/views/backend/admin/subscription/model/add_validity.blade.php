<div class="modal fade" id="validity" tabindex="-1" aria-labelledby="validity" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="validity">{{__('add_extra_validity') }}</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" class="form" method="post" enctype="multipart/form-data">
					@csrf
						<div class="row gx-20 add-coupon">

							<div class="col-lg-12">
								<div class="mb-4">
									<label for="time" class="form-label">{{ __('number') }}<span
												class="text-danger">*</span></label>
									<input type="number" class="form-control rounded-2" id="time" name="time"
									       placeholder="{{ __('time') }}">
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="mb-3">
									<label for="interval" class="form-label">{{__('interval') }}<span
												class="text-danger">*</span></label>
									<select class="form-select rounded-0 mb-3 without_search"
									        aria-label=".form-select-lg example" id="interval" name="interval"
									        style="width: 100%">
										<option value="" selected>{{ __('select_value') }}</option>
										<option value="day">{{__('day') }}</option>
										<option value="month">{{__('month') }}</option>
										<option value="year">{{__('year') }}</option>
									</select>
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="d-flex justify-content-end align-items-center mt-30">
								<button type="submit" class="btn sg-btn-primary">{{__('submit') }}</button>
								@include('backend.common.loading-btn',['class' => 'btn sg-btn-primary'])
							</div>
						</div>
				</form>
			</div>
		</div>
	</div>
</div>