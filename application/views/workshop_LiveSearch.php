<!doctype html>
<html>
  <head>
    <link rel="stylesheet" href="lib/style.css">
    <script src="lib/script.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script>

    <style>
      .modal-dialog:not(.modal-fullscreen) .modal-body {
          max-height: calc(100vh - 225px);
          overflow-y: auto;
      }
    </style>
  </head>

  <body>
    <div class="container mt-5 text-center">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Show modal</button>
    </div>

    <div class="col-6">
                <label>Select without bug :</label>
                <select id="select1" class="form-control" data-live-search="true" data-live-search-style="begins">
                  <option>Option 1</option>
                  <option>Option 2</option>
                  <option>Option 3</option>
                </select>
    </div>

    <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              
              <div class="col-6">
                <label>Select with bug :</label>
                <select class="form-control" data-container="body" data-live-search="true" data-live-search-style="begins" multiple="multiple" data-actions-box="true">
                  <option>Option 1</option>
                  <option>Option 2</option>
                  <option>Option 3</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
        $('#select1').selectpicker();
    </script>
  </body>
</html>
