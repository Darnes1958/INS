<div class=" gy-1 my-1" style="border:1px solid lightgray;background: white;">
   @livewire('tools.my-many-acc-table',
  ['TableName' => $post3,
  'ColNames' =>['no','name','sul','kst'],
  'ColHeader' =>['رقم العقد','الاسم','اجمالي التقسيط','القسط'],
  'pagno'=>6,
  'haswhereequel' => true,
  'whereequelfield' => 'bank',
  'whereequelvalue' => '0',
  ])
</div>
@stack('scripts')