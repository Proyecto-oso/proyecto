<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Print Test</title>
    <style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        border: solid 1px blue ;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
    }
    </style>
</head>
<body>
  <div>Top line</div>
  <div>Line 2</div>
</body>
</html>