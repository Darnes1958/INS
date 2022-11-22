<div class="col-md-12" >
    <select wire:model="MainNo" id="Main_L_All" class="Main_L_All" >
        <option value="">اختيار من القائمة</option>
        @foreach($MainList as $s)
            <option value="{{ $s->no }}">{{ $s->name }}</option>
        @endforeach
    </select>
</div>
