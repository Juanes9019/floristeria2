@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('home') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('estoy en el home!') }}
                </div>

                <div class="col-md-8">
                    <h3 class="pb-4 mb-4 fst-italic border-bottom">Flores para todas las ocasiones</h3>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
