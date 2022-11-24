<div>
  <div >
    <label for="updatedate" class="form-label">التاريخ</label>
    <input wire:model="updatedate" wire:keydown.enter="$emit('goto','updatekst')" class="form-control" type="date"  id="updatedate" >
  </div>
  <div  >
    <label  for="updatekst" class="form-label">القسط</label>
    <input  wire:model="updatekst" wire:keydown.enter="$emit('goto','updatesave')" class="form-control"  type="text"  id="updatekst" >
  </div>
  <div class="my-3 align-center justify-content-center "  style="display: flex">
    <input type="button"  id="updatesave"
           class=" btn btn-outline-success  waves-effect waves-light "
           wire:click.prevent="UpdateSave"  value="موافق" />
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
      Livewire.on('goto',postid=>  {
          if (postid=='updatekst') {  $("#updatekst").focus();$("#updatekst").select(); }
          if (postid=='updatedate') {  $("#updatedate").focus(); $("#updatedate").select();}
          if (postid=='updatesave') {
              setTimeout(function() { document.getElementById('updatesave').focus(); },100);}
      })
  </script>
@endpush