<!DOCTYPE html>
<html lang="">
<head>
  <title>{{$title??''}}</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- load uikit css -->
  <link rel="stylesheet" href="@url('library/uikit/css/uikit.min.css')" />

  <!-- load uikit js -->
  <script src="@url('library/uikit/js/uikit.min.js')"></script>

</head>
<body>

  @view($_page,$_all);

</body>
</html>
