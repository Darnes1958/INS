@extends('admin.admin_master')

@section('admin')

  <div class="row">
    @if($who=='taj')  @livewire('bank.inp-taj') @endif
    @if($who=='bank')  @livewire('bank.inp-bank') @endif
  </div>

  @stack('scripts')
@endsection
