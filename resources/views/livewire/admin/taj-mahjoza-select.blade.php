<div class="col-md-12" >

    <select   wire:model="TajNoMahjoza" id="TajNo_L_Mahjoza" class="TajNo_L_Mahjoza" >
        <option value="">اختيار من القائمة</option>
        @foreach($TajListMahjoza as  $s)
            <option value="{{ $s->TajNo }}">{{ $s->TajName }}</option>
        @endforeach
    </select>
</div>
