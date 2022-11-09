


  <div x-data  class="row g-3" style="border:1px solid lightgray;background: white; margin-bottom: 20px;margin-top: 16px;" >
    <div class="col-md-4">
      <label  for="bank_no" class="form-label-me ">المصرف</label>
      <input wire:model="bankno"  wire:keydown.enter="$emit('gotonext','no')" type="text" class=" form-control "
             id="bank_no" name="bank_no"  autofocus >
      @error('bankno') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div   class="col-md-8" >
      <label  class="form-label-me">.</label>
      @livewire('bank.bank-select')
    </div>

     <div class="col-md-4">
      <label for="no" class="form-label-me">الرقم الألي</label>
      <input  x-bind:disabled="!$wire.BankGet"  wire:model="no" wire:keydown.enter="$emit('gotonext','acc')"
             class="form-control  "
             name="no" type="text"  id="no" >
      @error('no') <span class="error">{{ $message }}</span> @enderror
    </div>
     <div   class="col-md-8" >
      <label  class="form-label-me">.</label>
      @livewire('aksat.no-select')
    </div>

     <div class="col-md-4">
      <label  for="acc" class="form-label-me">رقم الحساب</label>
      <input  x-bind:disabled="!$wire.BankGet" wire:model="acc"
             class="form-control  "
             name="acc" type="text"  id="acc" >
      @error('acc') <span class="error">{{ $message }}</span> @enderror
    </div>
     <div   class="col-md-8" >
      <label   class="form-label-me">.</label>

    </div>

     <div class="my-3 col-md-4">
      <label  for="orderno" class="form-label-me">رقم الفاتورة</label>
      <input  x-bind:disabled="!$wire.BankGet" wire:model="orderno"
             class="form-control  "
             name="orderno" type="text"  id="orderno" >
      @error('orderno') <span class="error">{{ $message }}</span> @enderror
    </div>
     <div   class="col-md-8" >
      <label class="form-label-me">.</label>
    </div>


  </div>




@push('scripts')
  <script type="text/javascript">
      Livewire.on('gotonext',postid=>  {
          if (postid=='bankno') {  $("#no").focus();$("#bank_no").select(); };
          if (postid=='no') {  $("#no").focus();$("#no").select(); };
          if (postid=='acc') {  $("#acc").focus();$("#acc").select(); };
          if (postid=='orderno') {  $("#orderno").focus(); $("#orderno").select();};
      })

  </script>

  <script>
      $(document).ready(function ()
      {
          $('#Bank_L').select2({
              closeOnSelect: true
          });
          $('#Bank_L').on('change', function (e) {
              var data = $('#Bank_L').select2("val");
          @this.set('bankno', data);

          });
      });
      window.livewire.on('bank-change-event',()=>{
          $('#Bank_L').select2({
              closeOnSelect: true
          });
          Livewire.emit('gotonext', 'bankno');

      });

      $(document).ready(function ()
      {
          $('#Main_L').select2({
              closeOnSelect: true
          });
          $('#Main_L').on('change', function (e) {
              var data = $('#Main_L').select2("val");
          @this.set('no', data);

          });
      });
      window.livewire.on('main-change-event',()=>{
          $('#Main_L').select2({
              closeOnSelect: true
          });
          Livewire.emit('gotonext', 'no');

      });
  </script>
@endpush
