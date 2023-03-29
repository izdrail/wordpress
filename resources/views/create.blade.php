@extends('marketing::layouts.app')

@section('title', __('Wordpress'))

@section('heading')
    {{ __('Wordpress') }}
@endsection

@section('content')

    @component('marketing::layouts.partials.actions')
        @slot('right')
            <a class="btn btn-primary btn-md btn-flat" href="{{ route('wordpress.site.create') }}">
                <i class="fa fa-plus mr-1"></i> {{ __('New Wordpress Site') }}
            </a>
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    {{ __('Create Wordpress Site') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('wordpress.site.store') }}" method="POST" class="form-horizontal">
                        @csrf
                        <x-sendportal.text-field name="name" :label="__('Website Name')" />
                        <x-sendportal.text-field name="database_host" :label="__('Database Host')" />
                        <x-sendportal.text-field name="database_user" :label="__('Database User')" />
                        <x-sendportal.text-field name="database_pass" :label="__('Database Password')" />
                        <x-sendportal.text-field name="database_name" :label="__('Database Name')" />
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
