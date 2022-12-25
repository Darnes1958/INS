<div class="col-md-12" >

    <select   wire:model="Database" id="Database_L" class="Database_L" >
        <option value="">اختيار من القائمة</option>
        @foreach($ItemList as  $s)
            <option value="{{ $s->Company }}">{{ $s->Company }}</option>
        @endforeach
    </select>
</div>
