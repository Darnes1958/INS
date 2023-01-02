<div  class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">
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
    <div class="col-md-12">
        <label for="notes" class="form-label-me">ملاحظات</label>
        <input wire:model="notes"  class="form-control"   type="text"  id="notes" readonly>
    </div>

</div>



