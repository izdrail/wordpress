@extends('marketing::layouts.app')

@section('title', __('Wordpress'))

@section('heading')
    {{ __('Wordpress') }}
@endsection

@section('content')
    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive">
            <form action="{{ route('wordpress.article.publish') }}" method="post">
                @csrf
                <select name="site">
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                    @endforeach
                </select>
                <button type="submit">Publish</button>
            </form>
        </div>
    </div>

@endsection
