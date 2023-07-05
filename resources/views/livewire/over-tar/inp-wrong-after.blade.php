<div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >



  <div class="col-md-5">
    <label for="date" class="form-label-me">التاريخ</label>
    <input wire:model="tar_date" wire:keydown.enter="$emit('goto','bankno')"
           class="form-control  "
           type="date"  id="tar_date" >
    @error('tar_date') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-7">
  </div>

  <div class="col-md-5">
    <label  for="bank_no" class="form-label-me ">المصرف</label>
    <input wire:model="bankno"  wire:keydown.enter="ChkBankAndGo" type="number" class=" form-control "
           id="bank_no"   autofocus >
    @error('bankno') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div   class="col-md-7" >
    <label  class="form-label-me">.</label>
    @livewire('bank.bank-select')
  </div>
  <div class="col-md-5 mb-2" >
    <label  for="acc" class="form-label-me">رقم الحساب</label>
    <input  x-bind:disabled="!$wire.BankGet" wire:model="acc" wire:keydown.enter="$emit('goto','name')"
            class="form-control"  name="acc" type="text"  id="acc" >
  </div>
  <div class="col-md-7 mb-2" >
    <label  for="name" class="form-label-me">الاسم</label>
    <input  x-bind:disabled="!$wire.BankGet" wire:model="name" wire:keydown.enter="$emit('goto','kst')"
            class="form-control"   type="text"  id="name" >
  </div>
  <div class="col-md-5 mb-2">
    <label  for="kst" class="form-label-me">المبلغ</label>
    <input x-bind:disabled="!$wire.BankGet" wire:model="kst" wire:keydown.enter="$emit('goto','SaveBtn')"
           class="form-control  "
           type="number"  id="kst" >
    @error('kst') <span class="error">{{ $message }}</span> @enderror
  </div>

  <div class="my-4 align-center justify-content-center "  style="display: flex">

    <input type="button"  id="head-btn"
           x-show="$wire.BankGet" class=" btn btn-outline-success  waves-effect waves-light   "
           wire:click.prevent="SaveWrong"   value="&nbsp;&nbsp;تخزين&nbsp;&nbsp;" />
  </div>
</div>

@push('scripts')

  <script>
      Livewire.on('goto',postid=>  {
          if (postid=='bankno') {  $("#bank_no").focus();$("#bank_no").select(); }
          if (postid=='name') {  $("#name").focus();$("#name").select(); }
          if (postid=='kst') {  $("#kst").focus();$("#kst").select(); }
          if (postid=='acc') {  $("#acc").focus();$("#acc").select(); }
          if (postid=='SaveBtn') {
              setTimeout(function() { document.getElementById('head-btn').focus(); },100);};
      })
      $(document).ready(function ()
      {
          $('#Bank_L').select2({
              closeOnSelect: true
          });
          $('#Bank_L').on('change', function (e) {
              var data = $('#Bank_L').select2("val");
          @this.set('bankno', data);
          @this.set('TheBankListIsSelectd', 1);
          });
      });
      window.livewire.on('bank-change-event',()=>{
          $('#Bank_L').select2({
              closeOnSelect: true
          });
      });

  </script>
@endpush
