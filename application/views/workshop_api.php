<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>WorkShop API</title>
</head>
<body>
    <div class="container-fluid p-4">
        <div class="col-md-12">
            <form id="formSendUrl">
                <div class="row mb-2">
                    <div class="col-auto">
                        <select class="form-select" name="MethodType" id="MethodType">
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                            <option value="PUT">PUT</option>
                            <option value="PATCH">PATCH</option>
                        </select>
                    </div>
                    <div class="col px-0">
                        <input type="url" class="form-control" name="inputURL" id="inputURL" placeholder="Enter URL : https://example.com" >
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="button" onclick="sendURL()">SEND</button>
                    </div>
                </div>
            </form>
            <div class="row mb-2">
                <div class="col">
                    <label for="body">Body (raw JSON)</label>
                    <textarea class="form-control" id="body" rows="10"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="resData">Response Data</label>
                    <textarea class="form-control" id="resData" rows="10"></textarea>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function sendURL(){
        let method = $('#MethodType').val()
        let url = $('#inputURL').val()
        let body = $('#body').val()

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('workshopApiSendURL'); ?>',
            data: {
                method: method,
                url: url,
                body: body,
            },
            success: function (tResult) {
                $('#resData').val(tResult)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error:', errorThrown);
            }
        });
    }
</script>
</html>