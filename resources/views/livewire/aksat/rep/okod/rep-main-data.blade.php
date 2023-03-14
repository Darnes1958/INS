<div>
 <div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">
   <div class="d-inline-flex align-items-center">
     <label for="name" class="form-label align-right" style="width: 20% ">رقم الزبون</label>
     <input  wire:model="jeha" type="text" class="form-control " id="name" readonly style="width: 20%" >
     <input  wire:model="name" type="text" class="form-control " id="name" readonly style="width: 60%;margin-right: 4px;" >
   </div>
   <div class="d-inline-flex align-items-center">
     <label for="bank_name" class="form-label align-right" style="width: 20% ">المصرف</label>
     <input  wire:model="bank_name" type="text" class="form-control " id="bank_name" readonly style="width: 80%" >

   </div>
     <div class="d-inline-flex align-items-center">
         <label for="place_name" class="form-label align-right" style="width: 20% ">جهة العمل</label>
         <input  wire:model="place_name" type="text" class="form-control " id="place_name" readonly style="width: 80%" >

     </div>
    <div class="d-inline-flex align-items-center">
        <label for="no" class="form-label" style="width: 20%">رقم العقد</label>
        <input  wire:model="no"
                class="form-control"   type="text" style="width: 30%" id="no" readonly>
        <label for="acc" class="form-label" style="width: 20% " >&nbsp;&nbsp;رقم الحساب</label>
        <input  wire:model="acc"
                type="text" class="form-control" id="acc" style="width: 30%" readonly >
    </div>

    <div class="d-inline-flex align-items-center">
        <label for="ksm_date" class="form-label" style="width: 20%">تاريخ العقد</label>
        <input  wire:model="sul_date"  class="form-control"   type="date" style="width: 30%" id="ksm_date" readonly>
        <label for="order_no" class="form-label" style="width: 20% ">&nbsp;&nbsp;رقم الفاتورة</label>
        <input  wire:model="order_no" type="text" class="form-control" id="order_no" style="width: 30%" readonly>
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="sul_tot" class="form-label" style="width: 25%; ">إجمالي الفاتورة</label>
        <input wire:model="sul_tot" type="text" class="form-control" name="sul_tot" style="width: 25%" readonly>
        <label for="sul" class="form-label" style="width: 25% ">&nbsp;&nbsp;اجمالي التقسيط</label>
        <input  wire:model="sul" type="text" class="form-control" id="sul" style="width: 25%" readonly>
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="sul_pay" class="form-label" style="width: 20% ">المسدد</label>
        <input  wire:model="sul_pay" type="text" class="form-control" id="sul_pay" style="width: 30%" readonly>
        <label for="raseed" class="form-label" style="width: 20% ">&nbsp;&nbsp;المطلوب</label>
        <input  wire:model="raseed" type="text" class="form-control" id="raseed" style="width: 30%" readonly>
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="kst_count" class="form-label" style="width: 20% ">عدد الأقساط</label>
        <input wire:model="kst_count" type="text" class="form-control" id="kst_count" style="width: 10%" readonly>
        <label for="kst_count" class="form-label" style="width: 10% ;text-align: left;margin-left: 2px;">متبقي</label>
        <input wire:model="kst_raseed" type="text" class="form-control" id="kst_count" style="width: 10%" readonly>
        <label for="kst" class="form-label" style="width: 20% ">&nbsp;&nbsp;القسط</label>
        <input wire:model="kst"  type="text" class="form-control" id="kst" style="width: 30%" readonly>
    </div>
    <div class="d-inline-flex align-items-center">
      <label  x-show="$wire.chk_in!=0 && $wire.chk_in!=null" for="chk_in" class="form-label" style="width: 20% ">صكوك مستلمة</label>
      <input  x-show="$wire.chk_in!=0 && $wire.chk_in!=null" wire:model="chk_in" type="text" class="form-control" id="chk_in" style="width: 30%" readonly>
      <label  x-show="$wire.chk_in!=0 && $wire.chk_in!=null" for="chk_out" class="form-label" style="width: 20% ">&nbsp;صكوك مرجعة</label>
      <input  x-show="$wire.chk_in!=0 && $wire.chk_in!=null" wire:model="chk_out"  type="text" class="form-control" id="chk_out" style="width: 30%" readonly>
    </div>
   <div class="d-inline-flex align-items-center">
     <label  x-show="$wire.libyana!=''" for="libyana" class="form-label" style="width: 20%;  color:#6f42c1 ">لبيانا</label>
     <input  x-show="$wire.libyana!=''" wire:model="libyana" type="text" class="form-control"  style="width: 30%; color:#6f42c1" readonly>
     <label  x-show="$wire.mdar!=''" for="mdar" class="form-label" style="width: 20% ;color: #00ff80">&nbsp;&nbsp;مدار</label>
     <input  x-show="$wire.mdar!=''" wire:model="mdar"  type="text" class="form-control"  style="width: 30%;color: #00ff80" readonly>
   </div>
    <div  class="d-inline-flex align-items-center my-1">
        <label x-show="$wire.notes!='' && $wire.notes!=null && $wire.notes!='0'" for="notes" class="form-label-me" style="width: 20% ">ملاحظات</label>
        <textarea x-show="$wire.notes!='' && $wire.notes!=null && $wire.notes!='0'"  wire:model="notes"  class="form-control"  style="width: 80% " id="notes" readonly></textarea>
    </div>
   <div class="row">
     <div class="col-md-2">
       <a  href="{{route('pdfmain',$no)}}" class="btn btn-success waves-effect waves-light "><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
     </div>
     <div class="col-md-7"> </div>
     @unlessrole('info')
     @if (\App\Models\LarSetting::first()->ArcBtn=='rep')
      <div class="col-md-3 " >
        <a wire:click="Archive" class="btn btn-info waves-effect waves-light mx-10"><i class="fa fa-archive"> &nbsp;&nbsp;نقل للأرشيف&nbsp;&nbsp;</i></a>
      </div>
     @endif
     @endunlessrole
   </div>

    @livewire('tools.my-table2',
    ['TableName' => $mainitems,
    'ColNames' =>['item_no','item_name','quant','price','sub_tot'],
    'ColHeader' =>['رقم الصنف','اسم الصنف','الكمية','السعر','المجموع'],
    'pagno'=>5,
    'haswhereequel' => true,
    'whereequelfield' => 'order_no',
    'whereequelvalue' => 0,
    ])
    <div  class="d-inline-flex align-items-center">
        <a x-show="$wire.OverKst>0" wire:click="ShowOver" href="#" style="width: 20% ">فائض({{$OverKst}})</a>
        <a x-show="$wire.TarKst>0" wire:click="ShowTar" href="#" style="width: 20% ; color: green">ترجيع({{$TarKst}})</a>
        <a x-show="$wire.ArcMain>0" wire:click="ShowArc" href="#" style="width: 20% ; color: #6f1e43">عقود سابقة({{$ArcMain}})</a>
        <a x-show="$wire.ChkTasleem>0" wire:click="ShowChk" href="#" style="width: 20% ; color: #6f1e43">صكوك مرجعة({{$ChkTasleem}})</a>
    </div>
    <div x-show="$wire.HasOver"style="width: 40% " >
        <label class="form-label-me" >المبالغ المخصومة بالفائض</label>
        <table class="table table-sm table-bordered table-striped table-light "   >
            <thead class="font-size-12"><tr><th>التاريخ</th><th>المبلغ</th></tr></thead>
            <tbody>
            @foreach($TableOver as  $item) <tr class="font-size-12"><td>{{$item->tar_date}}</td><td>{{$item->kst}}</td></tr> @endforeach  </tbody>
        </table> {{ $TableOver->links('custom-pagination-links-view') }}
    </div>
    <div x-show="$wire.HasTar" style="width: 40% " >
        <label class="form-label-me" >المبالغ المرجعة</label>
        <table class="table table-sm table-bordered table-striped table-light "   >
            <thead class="font-size-12"><tr><th>التاريخ</th><th>المبلغ</th></tr></thead>
            <tbody>
            @foreach($TableTar as  $item) <tr class="font-size-12"><td>{{$item->tar_date}}</td><td>{{$item->kst}}</td></tr> @endforeach  </tbody>
        </table> {{ $TableTar->links('custom-pagination-links-view') }}
    </div>
    <div x-show="$wire.HasArc" style="width: 40% " >
        <label class="form-label-me" >عقود أرشيف</label>
        <table class="table table-sm table-bordered table-striped table-light "   >
            <thead class="font-size-12"><tr><th>تاريخ العقد</th><th>رقم العقد</th></tr></thead>
            <tbody>
            @foreach($TableArc as  $item) <tr class="font-size-12">
                <td><a wire:click="OpenArc({{ $item->no }})" href="#">{{$item->sul_date}}</a> </td>
                <td><a wire:click="OpenArc({{ $item->no }})" href="#">{{$item->no}}</a></td></tr> @endforeach  </tbody>
        </table> {{ $TableArc->links('custom-pagination-links-view') }}
    </div>

    <div x-show="$wire.HasChk" style="width: 40% " >
        <label class="form-label-me" >الصكوك المرجعة</label>
        <table class="table table-sm table-bordered table-striped table-light "   >
            <thead class="font-size-12"><tr><th>التاريخ</th><th>العدد</th></tr></thead>
            <tbody>
            @foreach($TableChk as  $item) <tr class="font-size-12"><td>{{$item->wdate}}</td><td>{{$item->chk_count}}</td></tr> @endforeach  </tbody>
        </table> {{ $TableChk->links('custom-pagination-links-view') }}
    </div>


</div>

 <div class="col-md-12">
     <div class="modal fade" id="ModalArc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-xl">
             <div class="modal-content">
                 <div class="modal-header">
                     <button wire:click="CloseArc" type="button" class="btn-close" ></button>
                     <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">بيانات عقد من الأرشيف</h1>
                 </div>
                 <div class="modal-body">
                     @livewire('aksat.rep.okod.arc-modal')
                 </div>
             </div>
         </div>
     </div>

 </div>

</div>

@push('scripts')
    <script type="text/javascript">
        window.addEventListener('CloseArcModal', event => {
            $("#ModalArc").modal('hide');
        })
        window.addEventListener('OpenArcModal', event => {
            $("#ModalArc").modal('show');
        })
        window.addEventListener('arch',function(e){
            MyConfirm.fire({
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Livewire.emit('DoArch');
                }
            })
        });
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
    </script>


@endpush




