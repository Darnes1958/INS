@extends('admin.admin_master')

@section('admin')

    <div class="row mx-2 my-2">
    <div class="card col-md-3 p-0">
        <div class="card-header " style="background: #0e8cdb;color: white;">شاشة ادراج مرتب شهري</div>
        <div class="card-body ">
           @livewire('salary.idraj-head')
        </div>
    </div>

    <div class="col-md-5">

            @livewire('salary.idraj-table')

    </div>
    </div>

    @stack('scripts')
@endsection
