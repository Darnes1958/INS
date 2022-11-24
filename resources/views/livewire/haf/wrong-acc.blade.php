<div>
  <div >
    <label for="wrongname" class="form-label">الاسم</label>
    <input wire:model="wrongname" wire:keydown.enter="$emit('goto','wrongkst')" class="form-control" type="text"  id="wrongname" >
  </div>
  <div  >
    <label  for="wrongkst" class="form-label">القسط</label>
    <input  wire:model="wrongkst" wire:keydown.enter="$emit('goto','wrongsave')" class="form-control"  type="text"  id="wrongkst" >
  </div>
  <div class="my-3 align-center justify-content-center "  style="display: flex">
    <input type="button"  id="wrongsave"
           class=" btn btn-outline-success  waves-effect waves-light "
           wire:click.prevent="WrongSave"  value="موافق" />
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
      Livewire.on('goto',postid=>  {
          if (postid=='wrongkst') {  $("#wrongkst").focus();$("#wrongkst").select(); }
          if (postid=='wrongname') {  $("#wrongname").focus(); $("#wrongname").select();}
          if (postid=='wrongsave') {
              setTimeout(function() { document.getElementById('wrongsave').focus(); },100);}
      })
  </script>
@endpush

