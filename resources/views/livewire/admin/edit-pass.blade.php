
<div x-data class="card">
    <div class="card-body">
      <h4 class="card-title">تعديل الرقم السري</h4><br><br>
        <div class="row mb-3">
            <label for="example-text-input" class="col-sm-4 col-form-label">الرقـــم القديم</label>
            <div class="col-sm-8">
                <input x-bind:disabled="$wire.OldGeted" wire:model="OldPass" wire:keydown.enter="ChkOldAndGo"
                       name="oldpassword" class="form-control "  type="password"
                       id="oldpassword"  autocomplete="off">

            </div>
        </div>
        <div class="row mb-3">
            <label for="example-text-input" class="col-sm-4 col-form-label">الرقـــم الجديد</label>
            <div class="col-sm-8">
                <input x-bind:disabled="!$wire.OldGeted"  wire:model="NewPass" wire:keydown.enter="$emit('goto','confirm')"
                       name="newpassword" class="form-control" type="password"  id="newpassword" autocomplete="off">
                @error('NewPass') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="example-text-input" class="col-sm-4 col-form-label">تأكيد الرقـــم</label>
            <div class="col-sm-8">
                <input x-bind:disabled="!$wire.OldGeted"  wire:model="ConfirmPass" wire:keydown.enter="$emit('goto','save-btn')"
                       name="confirm_password" class="form-control" type="password"   id="confirm_password">
                @error('ConfirmPass') <span class="error">{{ $message }}</span> @enderror

            </div>
        </div>
      <input  x-bind:disabled="!$wire.OldGeted" wire:click="Save" type="button" id="save-btn" class="btn btn-info waves-effect waves-light" value="تعديل الرقم">
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    Livewire.on('goto',postid=>  {

        if (postid=='old') {  $("#oldpassword").focus();$("#oldpassword").select(); }
        if (postid=='new') {  $("#newpassword").focus();$("#newpassword").select(); }
        if (postid=='confirm') {  $("#confirm_password").focus();$("#confirm_password").select();}
        if (postid=='save') {
                setTimeout(function() { document.getElementById('save-btn').focus(); },100);};
   })
    window.addEventListener('mmsg',function(e){
        MyMsg.fire({
            confirmButtonText:  e.detail,
        })
    });
</script>
@endpush
