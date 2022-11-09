

<div  class="row g-3 " style="border:1px solid lightgray;background: white;">
  <div class="col-md-12">
    <label  for="name" class="form-label-me ">اسم الزبون</label>
    <input wire:model="name"  type="text" class=" form-control "  id="name" readonly >
  </div>

  <div class="col-md-6">
    <label  for="sul_tot" class="form-label-me ">إجمالي الفاتورة</label>
    <input wire:model="sul_tot"  type="text" class=" form-control "  id="sul_tot" readonly >
  </div>
  <div class="col-md-6">
    <label  for="dofa" class="form-label-me ">المدفوع</label>
    <input wire:model="dofa"  type="text" class=" form-control "  id="dofa"  readonly>
  </div>

  <div class="col-md-6">
    <label  for="sul" class="form-label-me ">إجمالي التقسيط</label>
    <input wire:model="sul"  type="text" class=" form-control "  id="sul"  readonly>
  </div>
  <div class="col-md-6">
    <label  for="sul_pay" class="form-label-me ">المسدد</label>
    <input wire:model="sul_pay"  type="text" class=" form-control "  id="sul_pay"  readonly>
  </div>

  <div class="col-md-6">
    <label  for="kst_count" class="form-label-me ">عدد الاقساط</label>
    <input wire:model="kst_count"  type="text" class=" form-control "  id="kst_count"  readonly>
  </div>
  <div class="col-md-6">
    <label  for="kstfromtable" class="form-label-me ">القسط</label>
    <input wire:model="kstfromtable"  type="text" class=" form-control "  id="kstfromtable"  readonly>
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

