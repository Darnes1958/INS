<div   class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div   class="col-md-12" >

        @livewire('aksat.no-select-all')
    </div>
    <div class="d-inline-flex align-items-center">
        <label for="no" class="form-label" style="width: 20%">الرقم الألي</label>
        <input  wire:model="no" wire:keydown.enter="ChkNoAndGo"
                class="form-control"   type="text" style="width: 30%" id="no" >
        <label for="acc" class="form-label" style="width: 20% ">&nbsp;رقم الحساب</label>
        <input  wire:model="acc" wire:keydown.enter="ChkAccAndGo"
                type="text" class="form-control" id="acc" style="width: 30%" >
    </div>

    <div   class="col-md-7" >

        <div>
            @if($errors->has('acc'))
                <span>{{ $errors->first('acc') }}</span>
            @endif
        </div>
        <div class="modal fade" id="ModalKstMany" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button wire:click="CloseMany" type="button" class="btn-close" ></button>
                        <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">اضغظ علي اختيار</h1>
                    </div>
                    <div class="modal-body">
                        @livewire('aksat.many-acc')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('CloseKstManyModal', event => {
            $("#ModalKstMany").modal('hide');
        })
        window.addEventListener('OpenKstManyModal', event => {
            $("#ModalKstMany").modal('show');
        })
    </script>
    <script type="text/javascript">
        Livewire.on('ksthead_goto',postid=>  {

            if (postid=='no') {  $("#no").focus();$("#no").select(); }
            if (postid=='acc') {  $("#acc").focus();$("#acc").select(); }
        })
    </script>

    <script>


        $(document).ready(function ()
        {
            $('#Main_L_All').select2({
                closeOnSelect: true
            });
            $('#Main_L_All').on('change', function (e) {
                var data = $('#Main_L_All').select2("val");
            @this.set('no', data);

            });
        });
        window.livewire.on('main-change-event',()=>{
            $('#Main_L_All').select2({
                closeOnSelect: true
            });

        });
    </script>
@endpush


