<div x-data >
  <div x-show="$wire.EditNameOpen">

    <div class="modal fade" id="EditNameModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <button wire:click="CloseEditName" type="button" class="btn-close" ></button>
          </div>
          <div class="modal-body">
            <input wire:model="TheName" wire:keydown.enter="$emit('yessave') class="form-control"  type="text"  id="TheEditName">
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@push('scripts')
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });

      window.addEventListener('CloseEditNameModal', event => {
          alert('close');
          $("#EditNameModal").modal('hide');
      })
      window.addEventListener('OpenEditNameModal', event => {

          $("#EditNameModal").modal('show');
      })
  </script>

@endpush


