@extends('admin.admin_master')

@section('admin')
    <div class="card col-md-8 p-0">
        <div class="card-header " style="background: #0e8cdb;color: white;">شاشة ادخال سحب من المرتب</div>
        <div class="card-body ">
           @livewire('salary.inp-saheb')
        </div>
    </div>
    @stack('scripts')
@endsection
