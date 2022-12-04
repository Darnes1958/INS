<div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">
    <div class="d-inline-flex align-items-center">
        <label for="no" class="form-label" style="width: 20%">الرقم الألي</label>
        <input  wire:model="no"
                class="form-control"   type="text" style="width: 30%" id="no" readonly>
        <label for="acc" class="form-label" style="width: 20% " >&nbsp;رقم الحساب</label>
        <input  wire:model="acc"
                type="text" class="form-control" id="acc" style="width: 30%" readonly >
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="name" class="form-label align-right" style="width: 20% ">اســــــم الزبون</label>
        <input  wire:model="name" type="text" class="form-control" id="name" readonly style="width: 80%" >
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
        <input wire:model="kst_count" type="text" class="form-control" id="kst_count" style="width: 30%" readonly>
        <label for="kst" class="form-label" style="width: 20% ">&nbsp;&nbsp;القسط</label>
        <input wire:model="kst"  type="text" class="form-control" id="kst" style="width: 30%" readonly>
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="chk_in" class="form-label" style="width: 20% ">صكوك مستلمة</label>
        <input wire:model="chk_in" type="text" class="form-control" id="chk_in" style="width: 30%" readonly>
        <label for="chk_out" class="form-label" style="width: 20% ">&nbsp;صكوك مرجعة</label>
        <input wire:model="chk_out"  type="text" class="form-control" id="chk_out" style="width: 30%" readonly>
    </div>
    <div class="d-inline-flex align-items-center my-1">
        <label for="notes" class="form-label-me" style="width: 20% ">ملاحظات</label>
        <textarea wire:model="notes"  class="form-control"  style="width: 80% " id="notes" readonly></textarea>
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
        <a x-show="$wire.ArcMain>0" href="#" style="width: 20% ; color: #6f1e43">عقود سابقة({{$ArcMain}})</a>
        <a x-show="$wire.ChkTasleem>0" href="#" style="width: 20% ; color: #6f1e43">صكوك مرجعة({{$ChkTasleem}})</a>
    </div>
    <div x-show="$wire.HasOver"style="width: 40% " >
        <label class="form-label-me" >المبالغ المخصومة بالفائض</label>
        <table class="table table-sm table-bordered table-striped table-light "   >
            <thead class="font-size-12"><tr><th>التاريخ</th><th>المبلغ</th></tr></thead>
            <tbody id="addRow" class="addRow">
            @foreach($TableOver as  $item) <tr class="font-size-12"><td>{{$item->tar_date}}</td><td>{{$item->kst}}</td></tr> @endforeach  </tbody>
        </table> {{ $TableOver->links('custom-pagination-links-view') }}
    </div>
    <div x-show="$wire.HasTar"style="width: 40% " >
        <label class="form-label-me" >المبالغ المرجعة</label>
        <table class="table table-sm table-bordered table-striped table-light "   >
            <thead class="font-size-12"><tr><th>التاريخ</th><th>المبلغ</th></tr></thead>
            <tbody id="addRow" class="addRow">
            @foreach($TableTar as  $item) <tr class="font-size-12"><td>{{$item->tar_date}}</td><td>{{$item->kst}}</td></tr> @endforeach  </tbody>
        </table> {{ $TableTar->links('custom-pagination-links-view') }}
    </div>
</div>



