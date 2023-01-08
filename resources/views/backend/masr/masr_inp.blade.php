@extends('admin.admin_master')

@section('admin')

    <div class="row">
    <div class="card col-md-4 p-0">
        <div class="card-header " style="background: #0e8cdb;color: white;">شاشة ادخال مصروفات</div>
        <div class="card-body ">
           @livewire('masr.masr-inp')
        </div>
    </div>

    <div class="col-md-8">

            @livewire('masr.masr-table')

    </div>
    </div>

    @stack('scripts')
@endsection
