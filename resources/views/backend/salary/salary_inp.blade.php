@extends('admin.admin_master')

@section('admin')

    <div class="row">
    <div class="card col-md-4 p-0">
        <div class="card-header " style="background: #0e8cdb;color: white;">شاشة ادخال مرتبات</div>
        <div class="card-body ">
           @livewire('salary.salary-inp')
        </div>
    </div>

    <div class="col-md-8">

            @livewire('salary.salary-table')

    </div>
    </div>

    @stack('scripts')
@endsection
