<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex, nofollow">
  <title>Laravel log viewer</title>
  <link  href="{{ asset('datatables/datatables.min.css') }}" rel="stylesheet">
  <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">

  <style>
    .showData{
        cursor: pointer;
    }

    h1 {
      font-size: 1.5em;
      margin-top: 0;
    }

    #table-log {
        font-size: 0.85rem;
    }

    .sidebar {
        font-size: 0.85rem;
        line-height: 1;
    }

    .btn {
        font-size: 0.7rem;
    }

    .stack {
      font-size: 0.85em;
    }

    .date {
      min-width: 75px;
    }

    .text {
      word-break: break-all;
    }

    a.llv-active {
      z-index: 2;
      background-color: #f5f5f5;
      border-color: #777;
    }

    .list-group-item {
      word-break: break-word;
    }

    .folder {
      padding-top: 15px;
    }

    .div-scroll {
      height: 80vh;
      overflow: hidden auto;
    }
    .nowrap {
      white-space: nowrap;
    }
    .list-group {
            padding: 5px;
    }

  </style>

</head>

<body>

  <div class="container-fluid">
    <div class="row">
      <div class="col sidebar mb-3">
        <h3><i class="fa fa-calendar" aria-hidden="true"></i> Laravel Log Viewer</h3>
        <div class="list-group div-scroll ">
        <?php 
          for($i=1; $i<2; $i++){  
          ?>
          {{-- @foreach($folders as $folder) --}}
            <div class="list-group-item">
              <?php
              \ViewerLogic\ViewerLogic::DirectoryTreeStructure( $storage_path, $structure );
              ?>

            </div>
          <?php
          }
          ?>
            {{-- @endforeach --}}
            @if($folders < 1)
            @foreach($files as $file)
              <a href="logs_view?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                class="list-group-item @if ($current_file == $file) llv-active @endif">
                {{$file}}
              </a>
            @endforeach
            @endif
            </div>
      </div>
    </div>
  </div>

<!-- jQuery for Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<!-- FontAwesome -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<!-- Datatables -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <script>

  $(document).ready(function () {
    $('.table-container tr').on('click', function () {
      $('#' + $(this).data('display')).toggle();
    });
    $('#table-log').DataTable({
      "order": [$('#table-log').data('orderingIndex'), 'desc'],
      "stateSave": true,
      "stateSaveCallback": function (settings, data) {
        window.localStorage.setItem("datatable", JSON.stringify(data));
      },
      "stateLoadCallback": function (settings) {
        var data = JSON.parse(window.localStorage.getItem("datatable"));
        if (data) data.start = 0;
        return data;
      }
    });
    $('#delete-log, #clean-log, #delete-all-log').click(function () {
      return confirm('Are you sure?');
    });
  });
</script>
</body>
</html>



