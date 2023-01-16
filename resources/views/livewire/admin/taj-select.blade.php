<div class="col-md-12" >

    <select   wire:model="TajNo" id="TajNo_L" class="TajNo_L" >
        <option value="">اختيار من القائمة</option>
        @foreach($TajList as  $s)
            <option value="{{ $s->TajNo }}">{{ $s->TajName }}</option>
        @endforeach
    </select>
</div>
