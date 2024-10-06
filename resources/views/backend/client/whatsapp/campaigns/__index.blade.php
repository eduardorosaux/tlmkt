@extends('backend.layouts.master')
@section('title', __('campaigns'))
@section('content')
    <section class="oftions">
        <div class="row mb-20">
            <div class="col-lg-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between">
                                <h3 class="section-title">{{ __('campaigns_management') }}</h3>
                                <div class="oftions-content-right mb-12">
                                    <a href="{{ route('client.whatsapp.campaign.create') }}"
                                        class="d-flex align-items-center btn sg-btn-primary gap-2">
                                        <i class="lab la-whatsapp"></i>
                                        <span>{{ __('new_campaign') }}</span>
                                    </a>
                                    <a href="{{ route('client.telegram.campaign.create') }}"
                                        class="d-flex align-items-center btn sg-btn-primary gap-2">
                                        <i class="lab la-telegram"></i>
                                        <span>{{ __('new_campaign') }}</span>
                                    </a>
                                    <a href="{{ route('message.schedule.send') }}"
                                        class="d-flex align-items-center btn sg-btn-primary gap-2">
                                        <i class="las la-calendar"></i>
                                        <span>{{ __('cron_job') }}</span>
                                    </a>
                                </div>
                            </div>
                            @if ($campaigns->isEmpty())
                                <div class="alert alert-info" role="alert">
                                    {{ __('No campaigns found.') }}
                                </div>
                            @else
                                @foreach ($campaigns as $campaign)
                                <?php
                                $client = Auth::user()->client;
                                $activeContactsCount = $client->contacts()->active()->count();
                                $campaign_contact = $campaign->total_contact ?? 0;
                                $campaign_contact_percent = ($campaign_contact != 0) ? ($campaign_contact /  $activeContactsCount) * 100 : 0;
                                $total_delivered = $campaign->total_delivered;
                                $total_delivered_percent = ($total_delivered != 0) ? ( $total_delivered  / $campaign_contact) * 100 : 0;
                                $total_read = $campaign->total_read;
                                $read_percent = ($total_read != 0) ? ( $total_read  / $campaign_contact) * 100 : 0;
                                ?>
                                <a href="{{ route('client.campaigns.view',$campaign->id) }}">
                                    <div class="redious-border mb-40 p-5 p-sm-20 bg-white" style="position: relative;">
                                        <span class="@if ($campaign->campaign_type->value == \App\Enums\TypeEnum::WHATSAPP->value ) whatsapp-badge @else telegram-badge @endif">{{ $campaign->campaign_name }} - @if ($campaign->campaign_type->value == \App\Enums\TypeEnum::WHATSAPP->value ) {{__('whatsapp')}} @else {{__('telegram')}} @endif</span>
                                        <div class="mt-4"></div>
                                        <div class="row">
                                            <div class="col-xxl-3 col-lg-6 col-md-6 mb-20 mb-xxl-0">
                                                <div class="bg-white redious-border p-20 p-sm-30">
                                                    <div class="analytics clr-1">
                                                        <div class="analytics-icon">
                                                            <i class="las la-bullhorn"></i>
                                                        </div>
                                                        <div class="analytics-content no-line-braek">
                                                            <h5 class="">{{ @$campaign->template->name }}</h5>
                                                            <p>{{ $campaign->created_at->format('d/m/Y') }}</p>
                                                            <div>
                                                                {{ __('templates') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-lg-6 col-md-6 mb-20 mb-xxl-0">
                                                <div class="bg-white redious-border p-20 p-sm-30">
                                                    <div class="analytics clr-2">
                                                        <div class="analytics-icon">
                                                            <i class="lar la-user"></i>
                                                        </div>
                                                        <div class="analytics-content">
                                                            <h4>{{ $campaign_contact }}</h4>
                                                            <p>{{ __('contacts') }}</p>
                                                            <div>
                                                                {{ number_format($campaign_contact_percent,0) }}% {{ __('of_your_contacts') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-lg-6 col-md-6 mb-20 mb-lg-0">
                                                <div class="bg-white redious-border p-20 p-sm-30">
                                                    <div class="analytics clr-3">
                                                        <div class="analytics-icon">
                                                            <i class="las la-check-circle"></i>
                                                        </div>
                                                        <div class="analytics-content">
                                                            <h4>{{ number_format($total_delivered_percent,0) }} %</h4>
                                                            <p>{{ __('delivered_to') }}</p>
                                                            <div>
                                                                {{ $campaign_contact }} {{ __('contacts') }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-lg-6 col-md-6">
                                                <div class="bg-white redious-border p-20 p-sm-30">
                                                    <div class="analytics clr-4">
                                                        <div class="analytics-icon">
                                                            <i class="las la-sms"></i>
                                                        </div>
                                                        <div class="analytics-content">
                                                            <h4>{{ number_format($read_percent,0) }}%</h4>
                                                            <p>{{ __('read_by') }}</p>
                                                            <div>
                                                                {{ $total_read }} {{ __('of_the') }}
                                                                    {{ $campaign_contact }} {{ __('contacts_messaged') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                    
                                @endforeach
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $campaigns->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
