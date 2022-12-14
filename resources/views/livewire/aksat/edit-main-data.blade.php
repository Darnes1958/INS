


<div x-data x-bind:hidden="!$wire.OrderShow" class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
  <div class="col-md-4">
    <label for="no" class="form-label-me">رقم العقد</label>
    <input    wire:model="no"   class="form-control" readonly
              name="no" type="number"  id="no" >
  </div>
  <div class="col-md-4">
    <label  for="orderno" class="form-label-me ">رقم الفاتورة</label>
    <input wire:model="orderno"  type="number" class=" form-control " readonly
           id="orderno"   autofocus >
  </div>
  <div class="col-md-4">
    <label for="sul_date" class="form-label-me">تاريخ العقد</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="sul_date"
            class="form-control" readonly
            name="sul_date" type="date"  id="sul_date" >
    @error('sul_date') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-12 mb-2" >
    <label  for="name" class="form-label-me">اسم الزبون</label>
    <input   wire:model="name" readonly
            class="form-control"   type="text"   >
  </div>
  <div class="col-md-4 mb-2" >
    <label  for="sul_tot" class="form-label-me">اجمالي الفاتورة</label>
    <input  wire:model="sul_tot" readonly  class="form-control"   type="text"   >
  </div>
  <div class="col-md-4 mb-2" >
    <label  for="dofa" class="form-label-me">المدفوع مقدما</label>
    <input   wire:model="dofa" readonly   class="form-control"   type="text"   >
  </div>
  <div class="col-md-4 mb-2" >
    <label  for="sul" class="form-label-me">اجمالي التقسيط</label>
    <input  wire:model="sul" readonly  class="form-control"   type="text"   >
  </div>
  <div class="col-md-5">
    <label  for="bankno" class="form-label-me ">المصرف</label>
    <input x-bind:disabled="!$wire.OrderGet" wire:model="bankno" min="1" max="999" wire:keydown.enter="ChkBankAndGo" type="number" class=" form-control "
           id="bankno"   autofocus >
    @error('bankno') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div x-bind:disabled="!$wire.OrderGet"  class="col-md-7" >
    <label  class="form-label-me">.</label>
    @livewire('bank.bank-select')
  </div>

  <div class="col-md-4 mb-2" >
    <label  for="acc" class="form-label-me">رقم الحساب</label>
    <input  x-bind:disabled="!$wire.BankGet" wire:model="acc" wire:keydown.enter="ChkAccAndGo"
            class="form-control"  name="acc" type="text"  id="acc" >
    @error('acc') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-4">
    <label for="kst" class="form-label-me">القسط</label>
    <input    wire:model="kst" class="form-control" readonly
              name="kst" type="number"  id="kst" >
    @error('kst') <span class="error">{{ $message }}</span> @enderror
  </div>

  <div class="col-md-4 mb-2" >
    <div>
      @if (session()->has('message'))
        <div class="alert alert-danger">
          {{ session('message') }}
        </div>
      @endif
    </div>
  </div>

  <div class="col-md-5">
    <label  for="place" class="form-label-me">جهة العمل</label>
    <input x-bind:disabled="!$wire.OrderGet" wire:model="place" wire:keydown.enter="ChkPlaceAndGo"
           class="form-control  "
           name="place" type="number"  id="place" >
    @error('st_no') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div x-bind:disabled="!$wire.OrderGet"  class="col-md-7" >
    <label  class="form-label-me">.</label>
    @livewire('aksat.place-select')
  </div>

  <div class="col-md-12">
    <label for="notes" class="form-label-me">ملاحظات</label>
    <input x-bind:disabled="!$wire.OrderGet" wire:model="notes" wire:keydown.enter="$emit('goto','chk_in')"
           class="form-control  "
           type="text"  id="notes" >
  </div>
  <div class="col-md-6">
    <label for="chk_in" class="form-label-me">صكوك مستلمة</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="chk_in" wire:keydown.enter="$emit('goto','ref_no')"
            class="form-control"
            name="chk_in" type="number"  id="chk_in" >
    @error('chk_in') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6">
    <label for="ref_no" class="form-label-me">اشاري العقد</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="ref_no" wire:keydown.enter="$emit('goto','SaveBtn')"
            class="form-control"
            name="ref_no" type="text"  id="ref_no" >
    @error('ref_no') <span class="error">{{ $message }}</span> @enderror
  </div>

  <div  class="my-3 py-3 align-center justify-content-center  "  style="display: flex;border: solid lightgray 1px;">
    <div x-show="$wire.EditMe" class="my-3 align-center justify-content-center "  style="display: flex">
      <input  x-bind:disabled="!$wire.OrderGet" type="button"  id="SaveBtn"
             class=" btn btn-outline-success  waves-effect waves-light   "
             wire:click.prevent="SaveCont"   value="تخزين العقد" />
    </div>
    <div x-show="$wire.DeleteMe" class="my-3 align-center justify-content-center "  style="display: flex">

      <input x-bind:disabled="!$wire.DeleteBtn"  type="button"  id="DeleteBtn"
             class=" btn btn-outline-danger  waves-effect waves-light   "
             wire:click.prevent="DeleteCont"   value="الغاء العقد" />
    </div>
  </div>

</div>

@push('scripts')

  <script type="text/javascript">
      Livewire.on('goto',postid=>  {


          if (postid=='orderno') {  $("#orderno").focus();$("#orderno").select(); }
          if (postid=='bankno') {  $("#bankno").focus();$("#bankno").select(); }
          if (postid=='no') {  $("#no").focus();$("#no").select(); }
          if (postid=='acc') {  $("#acc").focus();$("#acc").select(); }
          if (postid=='place') {  $("#place").focus();$("#place").select(); }
          if (postid=='notes') {  $("#notes").focus();$("#notes").select(); }
          if (postid=='kstcount') {  $("#kstcount").focus();$("#kstcount").select(); }
          if (postid=='kst') {  $("#kst").focus();$("#kst").select(); }
          if (postid=='chk_in') {  $("#chk_in").focus();$("#chk_in").select(); }
          if (postid=='ref_no') {  $("#ref_no").focus();$("#ref_no").select(); }
          if (postid=='sul_date') {  $("#sul_date").focus();$("#sul_date").select(); }
          if (postid=='SaveBtn') {
              setTimeout(function() { document.getElementById('SaveBtn').focus(); },100);};
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
          @this.set('TheBankNoListIsSelectd', 1);
          });
      });
      window.livewire.on('bank-change-event',()=>{
          $('#Bank_L').select2({
              closeOnSelect: true
          });
      });



      $(document).ready(function ()
      {
          $('#Place_L').select2({
              closeOnSelect: true
          });
          $('#Place_L').on('change', function (e) {
              var data = $('#Place_L').select2("val");
          @this.set('place', data);
          @this.set('ThePlaceNoListIsSelectd', 1);
          });
      });
      window.livewire.on('place-change-event',()=>{
          $('#Place_L').select2({
              closeOnSelect: true
          });

      });
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>
@endpush
