@extends('layouts/app_admin');
@section('content_admin')
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        Balance
                    </div>
                    <div class="card-body">
                        <h4>Rp.{{ number_format($balance, 2, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection