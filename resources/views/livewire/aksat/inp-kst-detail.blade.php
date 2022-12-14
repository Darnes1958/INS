


<div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">


    <div class="d-inline-flex align-items-center">
        <label for="name" class="form-label align-right" style="width: 20% ">اســــــم الزبون</label>
        <input  wire:model="name" type="text" class="form-control" id="name" readonly style="width: 80%" >
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

  <div class="col-md-12">
    <label for="notes" class="form-label-me">ملاحظات</label>
    <input x-bind:disabled="!$wire.OpenKstDetail" wire:model="notes" wire:keydown.enter="$emit('kstdetail_goto','kst_date')"
           class="form-control  "
           type="text"  id="notes" >
  </div>

  <div class="col-md-6 mb-2">
    <label for="ksm_date" class="form-label-me">التاريخ</label>
    <input x-bind:disabled="!$wire.OpenKstDetail" wire:model="ksm_date" wire:keydown.enter="$emit('kstdetail_goto','ksm')"
           class="form-control  "
           type="date"  id="ksm_date" >
    @error('ksm_date') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6 mb-2">
    <label  for="ksm" class="form-label-me">القسط</label>
    <input x-bind:disabled="!$wire.OpenKstDetail" wire:model="ksm" wire:keydown.enter="ChkKsm"
           class="form-control  "
           type="text"  id="ksm" >
    @error('ksm') <span class="error">{{ $message }}</span> @enderror
    <div>
      @if (session()->has('message'))
        <div class="alert alert-danger">
          {{ session('message') }}
        </div>
      @endif
    </div>
  </div>
  <br>
</div>

@push('scripts')
  <script type="text/javascript">
      Livewire.on('kstdetail_goto',postid=>  {

          if (postid=='notes') {  $("#notes").focus();$("#notes").select(); }
          if (postid=='ksm_date') {  $("#ksm_date").focus();$("#ksm_date").select(); }
          if (postid=='ksm') {  $("#ksm").focus(); $("#ksm").select();}
      })


  </script>
@endpush

