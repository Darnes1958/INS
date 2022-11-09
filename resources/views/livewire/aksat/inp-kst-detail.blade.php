


<div  class="row g-3 " style="border:1px solid lightgray;background: white;">


    <div class="d-inline-flex align-items-center">
        <label for="name" class="form-label align-right" style="width: 20% ">اســــــم الزبون</label>
        <input  wire:model="name" type="text" class="form-control" id="name" readonly style="width: 80%" >
    </div>

    <div class="d-inline-flex align-items-center">
        <label for="sul_tot" class="form-label" style="width: 20%; ">إجمالي الفاتورة</label>
        <input wire:model="sul_tot" type="text" class="form-control" name="sul_tot" style="width: 30%" >
        <label for="sul" class="form-label" style="width: 20% ">&nbsp;&nbsp;اجمالي التقسيط</label>
        <input  wire:model="sul"type="text" class="form-control" id="sul" style="width: 30%" >
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="sul_pay" class="form-label" style="width: 20% ">المسدد</label>
        <input  wire:model="sul_pay" type="text" class="form-control" id="sul_pay" style="width: 30%" >
        <label for="raseed" class="form-label" style="width: 20% ">&nbsp;&nbsp;المطلوب</label>
        <input  wire:model="raseed" type="text" class="form-control" id="raseed" style="width: 30%" >
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="kst_count" class="form-label" style="width: 20% ">عدد الأقساط</label>
        <input wire:model="kst_count" type="text" class="form-control" id="kst_count" style="width: 30%" >
        <label for="kstfromtable" class="form-label" style="width: 20% ">&nbsp;&nbsp;القسط</label>
        <input wire:model="kstfromtable" type="text" class="form-control" id="kstfromtable" style="width: 30%" >
    </div>

  <div class="col-md-12">
    <label for="notes" class="form-label-me">ملاحظات</label>
    <input wire:model="notes" wire:keydown.enter="$emit('gotonext','kst_date')"
           class="form-control  "
           type="text"  id="notes" >
  </div>

  <div class="col-md-6">
    <label for="kst_date" class="form-label-me">التاريخ</label>
    <input wire:model="kst_date" wire:keydown.enter="$emit('gotonext','kst')"
           class="form-control  "
           type="date"  id="kst_date" >
    @error('kst_date') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="my-3 col-md-6">
    <label  for="kst" class="form-label-me">القسط</label>
    <input wire:model="kst"
           class="form-control  "
           type="text"  id="kst" >
    @error('kst') <span class="error">{{ $message }}</span> @enderror
  </div>
  <br>
</div>

@push('scripts')
  <script type="text/javascript">
      Livewire.on('gotonext',postid=>  {
          if (postid=='notes') {  $("#notes").focus();$("#notes").select(); };
          if (postid=='kst_date') {  $("#kst_date").focus();$("#kst_date").select(); };
          if (postid=='kst') {  $("#kst").focus(); $("#kst").select();};
      })

  </script>
@endpush

