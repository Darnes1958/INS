<div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >

  <div class="col-md-6 my-4 ">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="Proc"   id="OverRadio1" value="over_kst">
      <label class="form-check-label" for="OverRadio1">من الفائض</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="Proc"   id="OverRadio2" value="wrong_kst">
      <label class="form-check-label" for="OverRadio2">بالخطأ</label>
    </div>
  </div>

  <div class="col-md-6 my-4 ">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="ksm_type"  name="inlineRadioOptions1" id="inlineRadio1" value="1">
      <label class="form-check-label" for="inlineRadio1">نقدا</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="ksm_type"  name="inlineRadioOptions2" id="inlineRadio2" value="2">
      <label class="form-check-label" for="inlineRadio2">مصرفي</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="ksm_type"  name="inlineRadioOptions3" id="inlineRadio3" value="3">
      <label class="form-check-label" for="inlineRadio3">صك</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="ksm_type"  name="inlineRadioOptions4" id="inlineRadio4" value="4">
      <label class="form-check-label" for="inlineRadio4">الكتروني</label>
    </div>
  </div>
  <div class="col-md-5">
    <label for="date" class="form-label-me">التاريخ</label>
    <input wire:model="tar_date"
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
  <div class="my-4 align-center justify-content-center "  style="display: flex">

    <input type="button"  id="head-btn"
           x-show="$wire.BankGet" class=" btn btn-outline-success  waves-effect waves-light   "
           wire:click.prevent="SaveTar"   value="&nbsp;&nbsp;ترحيل&nbsp;&nbsp;" />

  </div>
</div>

@push('scripts')

  <script>
      Livewire.on('gotonext',postid=>  {

          if (postid=='head-btn') {
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
