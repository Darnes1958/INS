<div class="row " x-data="{open:  @entangle('ShowEditName')}">

  <div class="modal fade" id="PlaceModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" wire:click.prevent="ClosePlace" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <h3 class="modal-title fs-5" id="exampleModalToggleLabel2">ادخال مكان العمل الجديد ثم اضغط ENTER</h3>
        </div>
        <div class="modal-body">
          @livewire('aksat.add-place')
        </div>

      </div>
    </div>
  </div>

 <div  class="col-md-6 ">


  <div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
   <div class="col-md-5">
    <div class="row ">
        <div class="col-md-4  gx-3">
          <label  for="orderno" class="form-label-me ">رقم الفاتورة</label>
        </div>
        <div class="col-md-8 ">
         <input wire:model="orderno"  wire:keydown.enter="ChkOrderAndGo" type="number" class=" form-control "
           id="orderno"   autofocus >
        </div>
    </div>
    @error('order_no') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div   class="col-md-7" >

    @livewire('aksat.order-select')
  </div>
  @if($has_cont)
      <div class="col-md-12 text-warning">{{$last_cont_text}}</div>
      @endif
  <div class="col-md-12 mb-2" >
      <div class="row ">
          <div class="col-md-2  gx-3">
            <label  for="name" class="form-label-me">اسم الزبون</label>
          </div>
          <div class="col-md-10 d-flex">
              <input  x-bind:disabled="!$wire.OrderGet" wire:model="name" readonly

                class="form-control"   type="text"   >
            <button wire:click="DoEditName" x-show="$wire.name!=null"
                    type="button" class="btn btn-outline-primary btn-sm fa fa-edit border-0" ></button>

          </div>


      </div>
    <div class="row"  x-show:="open" @click.outside="open = false">
      <div class="col-md-2  gx-3"></div>
      <div class="col-md-9 ">
        <input  wire:model="NameToEdit" wire:keydown.enter="SaveName"  class="form-control"   type="text"  id="NameToEdit" autofocus>
      </div>

    </div>


  </div>
  <div class="col-md-4 mb-2" >
    <label  for="sul_tot" class="form-label-me">اجمالي الفاتورة</label>
    <input  wire:model="sul_tot" readonly  class="form-control"   type="text"   >
  </div>
  <div class="col-md-4 mb-2" >
    <label  for="dofa" class="form-label-me">المدفوع</label>
    <input   wire:model="dofa" readonly   class="form-control"   type="text"   >
  </div>
  <div class="col-md-4 mb-2" >
    <label  for="sul" class="form-label-me">اجمالي التقسيط</label>
    <input  wire:model="sul" readonly  class="form-control"   type="text"   >
  </div>

  <div class="col-md-6">
    <label for="no" class="form-label-me">رقم العقد</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="no" wire:keydown.enter="ChkNoAndGo"
            class="form-control"
            name="no" type="number"  id="no" >
    @error('no') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6">
    <label for="sul_date" class="form-label-me">تاريخ العقد</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="sul_date" wire:keydown.enter="$emit('goto','bankno')"
            class="form-control"
            name="sul_date" type="date"  id="sul_date" >
    @error('sul_date') <span class="error">{{ $message }}</span> @enderror
  </div>

  <div class="col-md-5 gy-2">
      <div class="row ">
        <div class="col-md-4  gx-3">
            <label  for="bankno" class="form-label-me ">المصرف</label>
        </div>
        <div class="col-md-8  gx-3">
              <input x-bind:disabled="!$wire.OrderGet" wire:model="bankno" min="1" max="999" wire:keydown.enter="ChkBankAndGo" type="number" class=" form-control "
               id="bankno"   autofocus >
                 @error('bankno') <span class="error">{{ $message }}</span> @enderror
        </div>
      </div>
  </div>
  <div x-bind:disabled="!$wire.OrderGet"  class="col-md-7 gy-2" >

    @livewire('bank.bank-select')
  </div>

  <div class="col-md-5 mb-2" >
    <label  for="acc" class="form-label-me">رقم الحساب</label>
    <input  x-bind:disabled="!$wire.BankGet" wire:model="acc" wire:keydown.enter="ChkAccAndGo"
            class="form-control"  name="acc" type="text"  id="acc" >
    @error('acc') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-7 mb-2" >
    <div>
      @if (session()->has('message'))
        <div class="alert alert-danger">
          {{ session('message') }}
        </div>
      @endif
    </div>
  </div>

  <div class="col-md-5">
      <div class="row ">
          <div class="col-md-4  gx-3">
              <label  for="place" class="form-label-me">جهة العمل</label>
          </div>
          <div class="col-md-7  gx-1">
             <input x-bind:disabled="!$wire.OrderGet" wire:model="place" wire:keydown.enter="ChkPlaceAndGo"
                  class="form-control  "
                name="place" type="number"  id="place" >
          </div>

         @error('place') <span class="error">{{ $message }}</span> @enderror
        <div class="col-md-1 gx-3" >
          <button wire:click="OpenPlace" type="button" class=" btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"></button>
        </div>
      </div>
  </div>
  <div x-bind:disabled="!$wire.OrderGet"  class="col-md-7" >

    @livewire('aksat.place-select')
  </div>

  <div class="col-md-12 gy-2">
      <div class="row ">
          <div class="col-md-2  gx-3">
            <label for="notes" class="form-label-me">ملاحظات</label>
          </div>
          <div class="col-md-10  ">
             <input x-bind:disabled="!$wire.OrderGet" wire:model="notes" wire:keydown.enter="$emit('goto','kstcount')"
                class="form-control  "
                   type="text"  id="notes" >
          </div>
      </div>
  </div>
  <div class="col-md-6">
    <label for="kstcount" class="form-label-me">عدد الأقساط</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="kstcount" wire:keydown.enter="ChkKstCountAndGo"
            class="form-control"
            name="kstcount" type="number"  id="kstcount" >
    @error('kstcount') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6">
    <label for="kst" class="form-label-me">القسط</label>
    <input  x-bind:disabled="!$wire.CountGet"  wire:model="kst" wire:keydown.enter="$emit('goto','chk_in')"
            class="form-control"
            name="kst" type="number"  id="kst" >
    @error('kst') <span class="error">{{ $message }}</span> @enderror
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

  <div class="my-3 align-center justify-content-center "  style="display: flex">

    <input x-bind:disabled="!$wire.OrderGet" type="button"  id="SaveBtn"
           class=" btn btn-outline-success  waves-effect waves-light   "
           wire:click.prevent="SaveCont"   value="تخزين العقد" />

  </div>

</div>
 </div>

    <div  class="col-md-6 p-1 my-1" >
            <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                <caption class="caption-top">بيان الفاتورة</caption>
                <thead class="font-size-12">
                <tr>

                    <th style="width: 14%">رقم الصنف</th>
                    <th >اسم الصنف</th>
                    <th style="width: 10%">الكمية</th>
                    <th style="width: 14%">السعر</th>
                    <th style="width: 16%">المجموع</th>
                </tr>
                </thead>
                <tbody id="addRow" class="addRow">
                @foreach($RepTable as $key=> $item)
                    <tr class="font-size-12">
                        <td> {{ $item->item_no }} </td>
                        <td> {{ $item->item_name }} </td>
                        <td> {{ $item->quant }} </td>
                        <td> {{ $item->price}} </td>
                        <td> {{ $item->sub_tot }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $RepTable->links() }}

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
          if (postid=='NameToEdit') {  $("#NameToEdit").focus();$("#NameToEdit").select(); }
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
          $('#Order_L').select2({
              closeOnSelect: true
          });
          $('#Order_L').on('change', function (e) {
              var data = $('#Order_L').select2("val");
          @this.set('orderno', data);
          @this.set('TheOrderNoListIsSelectd', 1);
          });
      });
      window.livewire.on('order-change-event',()=>{
          $('#Order_L').select2({
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
