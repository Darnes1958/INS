<div class="row ">


<div  class="col-md-6 ">


<div  x-data="{open:  @entangle('ShowEditAcc')}" class="row  my-1" style="border:1px solid lightgray;background: white; " >
  <div class="col-md-5">
    <label   class="form-label-me ">رقم الفاتورة الجديدة</label>
    <input wire:model="orderno"  wire:keydown.enter="ChkOrderAndGo" type="number" class=" form-control "
           id="orderno"   autofocus >
    @error('order_no') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div   class="col-md-7" >
    <label  class="form-label-me">.</label>
    @livewire('aksat.order-select',['maintwo'=>true])
  </div>

    <div class="col-md-3" >
        <label  class="form-label-me">رقم العقد السابق</label>
        <input   wire:model="no_old"  class="form-control" readonly>
    </div>
    <div class="col-md-4 mb-3 " >
        <label   class="form-label-me">رقم الحساب</label>
      <div class="d-flex">
        <input  wire:model="acc"  class="form-control"  readonly >
        <button wire:click="DoEditAcc" x-show="$wire.acc!=null"
                type="button" class="btn btn-outline-primary btn-sm fa fa-edit border-0" ></button>
      </div>
    </div>
    <div class="col-md-5">
      <label  class="form-label-me ">المصرف</label>
      <input  wire:model="bank_name"  class=" form-control "  readonly >
    </div>

  <div class="col-md-2"  x-show:="open" >
  </div>
  <div class="col-md-5 mb-2"  x-show:="open" @click.outside="open = false">

    <input  wire:model="accToEdit" wire:keydown.enter="SaveAcc" class="form-control"  id="accToEdit" >
  </div>
  <div class="col-md-5"  x-show:="open" >
  </div>

  <div class="col-md-4 mb-2" >
    <label   class="form-label-me">اجمالي العقد السابق</label>
    <input  wire:model="sul_old" readonly  class="form-control"   type="text"   >
  </div>
  <div class="col-md-4 mb-2" >
    <label   class="form-label-me">المسدد</label>
    <input   wire:model="sul_pay_old" readonly   class="form-control"   type="text"   >
  </div>
  <div class="col-md-4 mb-2" >
    <label   class="form-label-me">المتبقي</label>
    <input  wire:model="raseed_old" readonly  class="form-control"   type="text"   >
  </div>
    <div class="col-md-3 mb-2" >
        <label   class="form-label-me">اجمالي الفاتورة الحالية</label>
        <input  wire:model="tot" readonly  class="form-control"   type="text"   >
    </div>
    <div class="col-md-3 mb-2" >
        <label   class="form-label-me">اجمالي العقد الحالي</label>
        <input  wire:model="sul_tot" readonly  class="form-control"   type="text"   >
    </div>
    <div class="col-md-3 mb-2" >
        <label   class="form-label-me">المدفوع</label>
        <input   wire:model="dofa" readonly   class="form-control"   type="text"   >
    </div>
    <div class="col-md-3 mb-2" >
        <label   class="form-label-me">اجمالي العقد الجديد</label>
        <input  wire:model="sul" readonly  class="form-control"   type="text"   >
    </div>

  <div class="col-md-6">
    <label  class="form-label-me">رقم العقد الجديد</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="no" wire:keydown.enter="ChkNoAndGo"
            class="form-control"
            name="no" type="number"  id="no" >
    @error('no') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6">
    <label  class="form-label-me">تاريخ العقد</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="sul_date" wire:keydown.enter="$emit('goto','notes')"
            class="form-control"
             type="date"  id="sul_date" >
    @error('sul_date') <span class="error">{{ $message }}</span> @enderror
  </div>


  <div class="col-md-12">
    <label  class="form-label-me">ملاحظات</label>
    <input x-bind:disabled="!$wire.OrderGet" wire:model="notes" wire:keydown.enter="$emit('goto','kstcount')"
           class="form-control  "
           type="text"  id="notes" >
  </div>
  <div class="col-md-6">
    <label  class="form-label-me">عدد الأقساط</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="kstcount" wire:keydown.enter="ChkKstCountAndGo"
            class="form-control"
            name="kstcount" type="number"  id="kstcount" >
    @error('kstcount') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6">
    <label  class="form-label-me">القسط</label>
    <input  x-bind:disabled="!$wire.CountGet"  wire:model="kst" wire:keydown.enter="$emit('goto','chk_in')"
            class="form-control"
            name="kst" type="number"  id="kst" >
    @error('kst') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6">
    <label  class="form-label-me">صكوك مستلمة</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="chk_in" wire:keydown.enter="$emit('goto','ref_no')"
            class="form-control"
            name="chk_in" type="number"  id="chk_in" >
    @error('chk_in') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6">
    <label  class="form-label-me">اشاري العقد</label>
    <input  x-bind:disabled="!$wire.OrderGet"  wire:model="ref_no" wire:keydown.enter="$emit('goto','SaveBtn')"
            class="form-control"   type="text"  id="ref_no" >
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
        <div>
            <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                <caption class="caption-top">بيان الفاتورة القديمة</caption>
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
                @foreach($RepTableOld as $key=> $item)
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
            {{ $RepTableOld->links() }}
        </div>
        <div>
            <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                <caption class="caption-top">بيان الفاتورة الجديدة</caption>
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
                @foreach($RepTableNew as $key=> $item)
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
            {{ $RepTableNew->links() }}
        </div>
    </div>



</div>

@push('scripts')

  <script type="text/javascript">
      Livewire.on('goto',postid=>  {


          if (postid=='orderno') {  $("#orderno").focus();$("#orderno").select(); }

          if (postid=='no') {  $("#no").focus();$("#no").select(); }


          if (postid=='notes') {  $("#notes").focus();$("#notes").select(); }
          if (postid=='kstcount') {  $("#kstcount").focus();$("#kstcount").select(); }
          if (postid=='kst') {  $("#kst").focus();$("#kst").select(); }
          if (postid=='chk_in') {  $("#chk_in").focus();$("#chk_in").select(); }
          if (postid=='ref_no') {  $("#ref_no").focus();$("#ref_no").select(); }
          if (postid=='sul_date') {  $("#sul_date").focus();$("#sul_date").select(); }
          if (postid=='accToEdit') {  $("#accToEdit").focus();$("#accToEdit").select(); }
          if (postid=='SaveBtn') {
              setTimeout(function() { document.getElementById('SaveBtn').focus(); },100);};
      })

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


      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>
@endpush
