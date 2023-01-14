<div class="col-md-10 col-lg-12">
    <form >
        <div class="row g-3">
            <div class="col-md-6">
                <label for="edithaf_date" class="form-label">التاريخ</label>
                <input wire:model="edithaf_date" wire:keydown.enter="$emit('gotonext','edithaf_tot')" type="date" class="form-control" id="edittran_date"  >
                @error('edithaf_date') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="edithaf_tot" class="form-label">المبلغ</label>
                <input wire:model="edithaf_tot"  wire:keydown.enter="$emit('gotonext','savebtns')" type="number" class="form-control"
                       id="edithaf_tot"  >
                @error('edithaf_tot') <span class="error">{{ $message }}</span> @enderror
            </div>

        </div>
        <input type="button"  id="savebtns"
               class="w-100 btn btn-outline-success  waves-effect waves-light  my-2 "
               wire:click.prevent="SaveEditHaf"   value="تخزين" />
        <br>
    </form>
</div>

@push('scripts')
    <script type="text/javascript">


        Livewire.on('gotonext',postid=>  {
            if (postid=='edithaf_date') {  $("#edithaf_date").focus(); $("#edithaf_date").select();};
            if (postid=='edithaf_tot') { $("#edithaf_tot").focus();  $("#edithaf_tot").select(); };

            if (postid=='savebtns') { setTimeout(function() { document.getElementById('savebtn').focus(); },100);};
        })

    </script>
@endpush


