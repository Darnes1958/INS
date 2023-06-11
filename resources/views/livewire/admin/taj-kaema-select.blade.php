<div class="col-md-12" >

    <select   wire:model="TajNoKaema" id="TajNo_L_Kaema" class="TajNo_L_Kaema" >
        <option value="">اختيار من القائمة</option>
        @foreach($TajListKaema as  $s)
            <option value="{{ $s->TajNo }}">{{ $s->TajName }}</option>
        @endforeach
    </select>
</div>
