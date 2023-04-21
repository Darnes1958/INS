@extends('admin.admin_master')

@section('admin')
   <div >
         @livewire('salary.rep-salaries')
   </div>


  @stack('scripts')
@endsection
