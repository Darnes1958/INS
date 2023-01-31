@extends('admin.admin_master')

@section('admin')

  <div class="row">
    @if($who=='taj')  @livewire('bank.inp-taj') @endif
    @if($who=='bank')  @livewire('bank.inp-bank') @endif
    @if($who=='bankratio')  @livewire('bank.inp-bank-ratio') @endif
    @if($who=='repbankratio')  @livewire('bank.rep-bank-ratio') @endif

  </div>

  @stack('scripts')
@endsection
