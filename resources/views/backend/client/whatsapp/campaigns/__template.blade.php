<div class="accordion border-0" id="accordionPreview">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePreview"
                aria-expanded="true" aria-controls="collapsePreview">
                {{ __('preview') }}
            </button>
        </h2>
        <div id="collapsePreview" class="accordion-collapse collapse show" data-bs-parent="#accordionPreview">
            <div class="accordion-body">
                @if (!empty($template->components))
                    @foreach ($template->components as $component)
                        @switch($component['type'])
                            @case('HEADER')
                                @switch($component['format'])
                                    @case('DOCUMENT')
                                        <img style="" src="">
                                    @break
                                    @case('IMAGE')
                                        <img src="" style="">
                                    @break
                                    @case('VIDEO')
                                    @if(isset($component['example']['header_handle'][0]))
                                        <video width="100%" height="200" controls>
                                                <source src="{{ $component['example']['header_handle'][0] }}" type="video/mp4">
                                            </video>
                                        @else
                                            <!-- Handle if 'example' key or 'header_handle' sub-key does not exist -->
                                        @endif
                                        {{-- <video width="100%" height="200" controls>
                                            <source src="{{ $component['example']['header_handle'][0] }}" type="video/mp4">
                                        </video> --}}
                                    @break
                                    @case('TEXT')
                                        <?php
                                        $header = preg_replace('/{{(\d+)}}/', '<span id="" class="text-success header_$1">{{header_$1}}</span>', $component['text']);
                                        ?>
                                        <h6 class="card-title mb-2 vh-text">
                                            {!! $header !!}
                                        </h6>
                                    @break
                                @endswitch
                            @break
                            @case('FOOTER')
                                <?php
                                $footer = preg_replace('/{{(\d+)}}/', '<span class="text-success footer_$1">{{footer_$1}}</span>', $component['text']);
                                ?>
                                <span class="text-muted text-xs v-header">{!! $footer !!}</span>
                            @break
                            @case('BODY')
                                <?php
                                $body = preg_replace('/{{(\d+)}}/', '<span class="text-success body_$1">{{body_$1}}</span>', $component['text']);
                                ?>
                                <p class="card-text v-body">{!! $body !!}</p>
                            @break
                            @case('BUTTONS')
                                @foreach ($component['buttons'] as $button)
                                    <div>
                                        <div>
                                            @if ($button['type'] == 'URL')
                                                <a target="__blank" href="" class="btn btn-light btn-block btn-sm">
                                                    {{ $button['text'] }}
                                                </a>
                                            @else
                                                <a target="__blank" href=""
                                                    class="btn btn-info text-white btn-block btn-sm"> {{ $button['text'] }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @break
                        @endswitch
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@if ($variables)
    @foreach ($variables as $key => $variable)
        @if ($variable)
            <h6 class="v-section-title border-bottom pb-2">{{ ucfirst($key) }}</h6>
            <div class="">
                @switch($key)
                    @case('header')
                        {{-- @case('header', 'body') --}}
                        @foreach ($variable as $_key => $item)
                            <div class="row">
                                <div class="col-6 mb-3 match-value-select">
                                    <label class="form-label">
                                        {{ __('match_value') }}
                                    </label>
                                    <select name="header_matchs[{{ $item['id'] }}]" class="form-select body-match-select">
                                        <option value="input_value">{{ __('use_input_value') }}</option>
                                        <option value="contact_name">
                                            {{ __('contact_name') }}
                                        </option>
                                        <option value="contact_phone">
                                            {{ __('contact_phone') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-6 mb-3 body-value-input">
                                    <label class="form-label" for="{{ $item['id'] }}">
                                        {{ __('variable') }} {{ $item['id'] }}
                                    </label>
                                    <input type="text" class="form-control live_preview"
                                        data-target=".header_{{ $item['id'] }}" id="header_{{ $item['id'] }}"
                                        name="header_values[{{ $item['id'] }}]" placeholder="{{ $item['exampleValue'] }}"
                                        value="{{ $item['exampleValue'] }}" />
                                </div>
                            </div>
                        @endforeach
                    @case('body')
                        @foreach ($variable as $_key => $item)
                            <div class="row">
                                <div class="col-6 mb-3 match-value-select">
                                    <label class="form-label">
                                        {{ __('match_value') }} {{ $item['id'] }}
                                    </label>
                                    <select name="body_matchs[{{ $item['id'] }}]" class="form-select body-match-select">
                                        <option value="input_value">{{ __('use_input_value') }}</option>
                                        <option value="contact_name">
                                            {{ __('contact_name') }}
                                        </option>
                                        <option value="contact_phone">
                                            {{ __('contact_phone') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-6 mb-3 body-value-input">
                                    <label class="form-label" for="{{ $item['id'] }}">
                                        {{ __('variable') }} {{ $item['id'] }}
                                    </label>
                                    <input type="text" class="form-control live_preview"
                                        data-target=".body_{{ $item['id'] }}" id="body_{{ $item['id'] }}"
                                        name="body_values[{{ $item['id'] }}]" placeholder="{{ $item['exampleValue'] }}"
                                        value="{{ $item['exampleValue'] }}" />
                                </div>
                            </div>
                        @endforeach
                    @break
                    @case('document')
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="document" class="form-label">
                                    {{ __('document') }}
                                </label>
                                <input type="file" id="pdf" class="form-control boot-file-input" name="document" placeholder=""
                                    value="" accept="application/pdf" required />
                            </div>
                        </div>
                    @break
                    @case('image')
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">
                                    {{ __('image') }}
                                </label>
                                <input type="file" id="image" class="form-control boot-file-input" name="image" placeholder=""
                                    value="" accept="image/*" required />
                            </div>
                        </div>
                    @break
                    @case('video')
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="video" class="form-label">
                                    {{ __('video') }}
                                </label>
                                <input type="file" id="video" class="form-control boot-file-input" name="video" placeholder=""
                                    value="" accept="video/mp4,video/x-m4v,video/*" required />
                            </div>
                        </div>
                    @break
                    @case('buttons')
                        @foreach ($variable as $button)
                            @foreach ($button as $keybtn => $_item)
                                @switch($_item['type'])
                                    @case('URL')
                                        <div class="row">
                                            <div class="col-6 mb-3 match-value-select">
                                                <label class="form-label">
                                                    {{ __('match_value') }}
                                                </label>
                                                <select name="button_matchs[{{ $_item['id'] }}]"
                                                    class="form-select body-match-select">
                                                    <option value="input_value">{{ __('use_input_value') }}</option>
                                                    <option value="contact_name">
                                                        {{ __('contact_name') }}
                                                    </option>
                                                    <option value="contact_phone">
                                                        {{ __('contact_phone') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-6 mb-3 body-value-input">
                                                <label class="form-label" for="{{ $_item['id'] }}">
                                                    {{ __('variable') }}
                                                </label>
                                                <input type="text" class="form-control live_preview"
                                                    data-target=".button_{{ $_item['id'] }}" id="button_{{ $_item['id'] }}"
                                                    name="button_values[{{ $_item['id'] }}]"
                                                    placeholder="{{ $_item['exampleValue'] }}"
                                                    value="{{ $_item['exampleValue'] }}" />
                                            </div>
                                        </div>
                                    @break

                                    @case('COPY_CODE')
                                        <div class="row">
                                            <div class="col-6 mb-3 match-value-select">
                                                <label class="form-label">
                                                    {{ __('match_value') }}
                                                </label>
                                                <select name="button_matchs[{{ $_item['id'] }}]"
                                                    class="form-select body-match-select">
                                                    <option value="input_value">{{ __('use_input_value') }}</option>
                                                    <option value="contact_name">
                                                        {{ __('contact_name') }}
                                                    </option>
                                                    <option value="contact_phone">
                                                        {{ __('contact_phone') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-6 mb-3 body-value-input">
                                                <label class="form-label" for="{{ $_item['id'] }}">
                                                    {{ __('variable') }}
                                                </label>
                                                <input type="text" class="form-control live_preview"
                                                    data-target=".button_{{ $_item['id'] }}" id="button_{{ $_item['id'] }}"
                                                    name="button_values[{{ $_item['id'] }}]"
                                                    placeholder="{{ $_item['exampleValue'] }}"
                                                    value="{{ $_item['exampleValue'] }}" />
                                            </div>
                                        </div>
                                    @break
                                @endswitch
                            @endforeach
                        @endforeach
                    @break
                @endswitch
        @endif
    @endforeach
    </div>
@endif
