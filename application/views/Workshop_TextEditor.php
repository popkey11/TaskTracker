
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('/assets/texteditor/editor.js');?>"></script>
    <script>
    $(document).ready(function() {
        $("#txtEditor").Editor();
    });
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="<?php echo base_url('/assets/texteditor/editor.css');?>" type="text/css" rel="stylesheet" />
    <title>LineControl | v1.1.0</title>



    <div class="col-lg-12 nopadding">
        <textarea id="txtEditor" style="height:500px"></textarea>
    </div>