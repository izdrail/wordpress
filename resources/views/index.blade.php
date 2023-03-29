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

    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('Database Host') }}</th>
                    <th>{{ __('Database User') }}</th>
                    <th>{{ __('Database Pass') }}</th>
                    <th>{{ __('Database Name') }}</th>
                    <th>
                        {{ __('Actions') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($wordpressSites as $site)
                    <tr>
                        <td>{{ $site->database_host }}</td>
                        <td>{{ $site->database_user }}</td>
                        <td>{{ $site->database_pass }}</td>
                        <td>{{ $site->database_name }}</td>
                        <td>
                            <a href="{{ route('wordpress.site.delete', $site->id) }}" class="btn btn-danger btn-sm btn-flat">
                                <i class="fa fa-trash"></i>
                                {{ __('Delete') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="text-center">
                                <h4>{{ __('No Wordpress Sites Found') }}</h4>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
