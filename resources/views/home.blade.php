@extends('layouts.app')

@section('scriptYeild')
<script src="{{ asset('js/home.js') }}" ></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br/>
                    <hr>
                    <button id="goToProjects" type="button" class="btn-primary" onclick="changeLocation('/project/all');" > view projects </button> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

