<div x-data>
    <div class="my-1">
        <label  class="form-label">طريقة احتساب العمولة</label>
        <select  wire:model.defer="tajmeehy.ratio_type"  @change="$focus.focus(ratio_val)"
                 class="form-control  form-select "
                 style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;" >
            <option value="">اختيار</option>
            <option value="R">نسبة مئوية</option>
            <option value="V">قيمة ثابتة</option>
        </select>
        @error('tajmeehy.ratio_type') <span class="error">{{ $message }}</span> @enderror

    </div>
    <div class="my-2">
        <label    class="form-label">القيمة</label>
        <input  wire:model.defer="tajmeehy.ratio_val"
                @keydown.enter="$focus.focus(taj_btn)"
                class="form-control  " type="text"  id="ratio_val" >
        @error('tajmeehy.ratio_val') <span class="error">{{ $message }}</span> @enderror
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <button type="submit" wire:click.defer="SaveTaj" class="my-2 btn btn-primary" id="taj_btn">
        تخزين
    </button>

</div>
