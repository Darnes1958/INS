@extends('admin.admin_master')

@section('admin')

  <div class="row">
      @livewire('jeha.add-supp',['jeha_type'=>$jeha_type])

  </div>

  @stack('scripts')
@endsection
