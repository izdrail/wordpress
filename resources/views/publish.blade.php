@extends('marketing::layouts.app')

@section('title', __('Wordpress'))

@section('heading')
    {{ __('Wordpress') }}
@endsection

@section('content')
    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive">
            <form action="#" method="POST">
                @csrf
                <select name="site">
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->database_host }}</option>
                    @endforeach
                </select>
                <button type="submit">Publish</button>
            </form>
        </div>
    </div>

@endsection
