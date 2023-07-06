
<div class=" gy-1 my-1" style="border:1px solid lightgray;background: white;">
   @livewire('tools.my-table',
    ['TableName' => $post,
    'ColNames' =>['ser','kst_date','ksm_date','kst','ksm','ksm_type_name'],
    'ColHeader' =>['ت','ت . الاستحقاق','ت . الخصم','القسط','الخصم','طريقة الدفع'],
    'pagno'=>15,
    'haswhereequel' => true,
    'whereequelfield' => 'no',
    'whereequelvalue' => 0,
    ])

</div>

@stack('scripts')


