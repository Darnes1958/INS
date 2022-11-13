
<div class=" gy-1 my-1" style="border:1px solid lightgray;background: white;">
  @livewire('tools.my-table',
  ['TableName' => $post,
  'ColNames' =>['ser','kst_date','ksm_date','kst','ksm'],
  'ColHeader' =>['ت','ت . الاستحقاق','ت . الخصم','القسط','الخصم'],
  'pagno'=>10,
  'haswhereequel' => true,
  'whereequelfield' => 'no',
  'whereequelvalue' => 0,
  ])


  @livewire('tools.my-table2',
  ['TableName' => $post2,
  'ColNames' =>['item_no','item_name','quant','price','sub_tot'],
  'ColHeader' =>['رقم الصنف','اسم الصنف','الكمية','السعر','المجموع'],
  'pagno'=>5,
  'haswhereequel' => true,
  'whereequelfield' => 'order_no',
  'whereequelvalue' => 0,
  ])

</div>

@stack('scripts')


