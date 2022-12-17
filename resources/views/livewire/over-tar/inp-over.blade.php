<div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">
  <div class="col-md-6 mb-2">
    <label for="tar_date" class="form-label-me">التاريخ</label>
    <input x-bind:disabled="!$wire.OpenDetail" wire:model="tar_date" wire:keydown.enter="$emit('gotodet','kst')"
           class="form-control  "
           type="date"  id="tar_date" >
    @error('tar_date') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6 mb-2">
    <label  for="kst" class="form-label-me">المبلغ</label>
    <input x-bind:disabled="!$wire.OpenDetail" wire:model="kst" wire:keydown.enter="$emit('gotodet','SaveBtn')"
           class="form-control  "
           type="number"  id="kst" >
    @error('kst') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="my-3 align-center justify-content-center "  style="display: flex">
    <input x-bind:disabled="!$wire.OpenDetail" type="button"  id="SaveBtn"
           class=" btn btn-outline-success  waves-effect waves-light   "
           wire:click.prevent="DoSave"   value="تخزين" />
  </div>
</div>

@push('scripts')
<script type="text/javascript">
    Livewire.on('gotodet',postid=>  {

        if (postid=='kst') {  $("#kst").focus();$("#kst").select(); }
        if (postid=='tar_date') {  $("#tar_date").focus();$("#tar_date").select(); }
        if (postid=='SaveBtn') {
            setTimeout(function() { document.getElementById('SaveBtn').focus(); },100);};
    })
</script>
@endpush
