

<!doctype html>

<html lang="ar" dir="rtl">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet" />
  <style>
      .order-td {
          border-left: none;
          border-top: none;
          border-right: none;
          font-size: 14pt;
          text-align: right;
      }
      #content {
          align-items: center;
          display: inline-flex;
      }
      #towlabel {

          display: inline;
      }
      .float-container {
          border: 3px solid #fff;
          padding: 20px;
      }

      .float-child {

          float: right;
          padding: 2px;

      }
      float-child2 {
          width: 60%;
          float: left;
          padding: 2px;

      }
      body {
          counter-increment: pageplus1 page;
          counter-reset: pageplus1 1;
          direction: rtl;
          font-family: Amiri ;

      }

      #header {
          position: fixed;
          top: -115px;

          height: 109px;

      }
      #footer {
          position: fixed;
          bottom: -25px;
          height: 20px;

          text-align: center;
      }

      #footer .page:after {

          content: counter(page);
      }
      #footer .pageplus1:after {

          content:  counter(pageplus1);
      }
      @page {
          size: 21cm 29.7cm ;
          margin: 30px 40px 30px 40px;
      }
      table {
          width: 60%;
          border-collapse: collapse;
          font-size: 14px;
      }
      tr {
          line-height: 14px;
      }
      th {
          text-align: center;

          font-size: 14px;
          height: 30px;
      }
      caption {
          font-family: DejaVu Sans, sans-serif ;

      }
      thead {

          font-family: DejaVu Sans, sans-serif;
      }

      td {
          text-align: right;

      }
      .page-break {
          page-break-after: always;
      }
      br[style] {
          display:none;
      }
      .page-break {
          page-break-after: always;
      }
      #mainlabel  {
          display:inline-block;border-style: dotted;border-top: none;border-right: none;
          border-left: none;padding-left: 4px;padding-right: 4px;text-align: center;
      }
      #mainlabel2  {
          display:inline-block; height: 20px;
      }
  </style>
</head>
<body  >

<div >



        <table  width="60%"   align="right" >
            @foreach($items as $key => $item)
            <thead style=" font-family: DejaVu Sans, sans-serif; margin-top: 8px;" >
            <tr  style="background: lightgray;" >
                <th width="10%">السعر</th>
                <th  width="40%">الصنف</th>
            </tr>
            </thead>
            <tbody style="margin-bottom: 40px; ">
                <tr >
                    <td style=" text-align: center;"> {{ $item['price_sell'] }} </td>
                    <td style=" text-align: right;"> {{ $item['item_name'] }} </td>
                </tr>
                <br>
             <tbody>
            @endforeach
        </table>
</div>
</body>
</html>

