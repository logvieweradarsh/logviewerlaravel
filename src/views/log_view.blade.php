<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log Viewer</title>
  <link rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
  crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
  <div class="row mb-4 demad-listing demand-form">
  <div class="col-md-12">
      <div class="demad-listing__top d-flex align-items-center justify-content-between mb-3">
          <div class="header">
              <h1>Log View </h1>
              <p class="mb-0">{{$current_file}} </p>
          </div>
          <div class="actions d-flex align-items-center">
              <a href="{{ route('log.viewer') }}" class="back-btn"> Back</a>
          </div>
      </div>

      <div class="container-fluid">
            <div class="card text-left demand-card">
              <div class="card-body">
                <div class="col-12 table-container">
                  @if ($logs === null)
                    <div>
                      Log file >50M, please download it.
                    </div>
                  @else
                    <table id="table-log" class="table table-striped" data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                      <thead>
                      <tr>
                        @if ($standardFormat)
                          <th>Level</th>
                          <th>Context</th>
                          <th>Date</th>
                        @else
                          <th>Line number</th>
                        @endif
                        <th>Content</th>
                      </tr>
                      </thead>
                      <tbody>
            
                      @foreach($logs as $key => $log)
                        <tr data-display="stack{{{$key}}}">
                          @if ($standardFormat)
                            <td class="nowrap text-{{{$log['level_class']}}}">
                              <span class="fa fa-{{{$log['level_img']}}}" aria-hidden="true"></span>&nbsp;&nbsp;{{$log['level']}}
                            </td>
                            <td class="text">{{$log['context']}}</td>
                          @endif
                          <td class="date">{{{$log['date']}}}</td>
                          <td class="text">
                            @if ($log['stack'])
                            {{-- <div class=" mr-2"> --}}
                              <button type="button"
                                      class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2" 
                                      data-display="stack{{{$key}}}">
                                <span class="fa fa-ellipsis-v"></span>
                              </button>
                            @endif
                            {{{$log['text']}}}
                            @if (isset($log['in_file']))
                              <br/>{{{$log['in_file']}}}
                            @endif
                            @if ($log['stack'])
                              <div class="stack" id="stack{{{$key}}}"
                                  style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                              </div>
                            @endif
                          </td>
                        </tr>
                      @endforeach
            
                      </tbody>
                    </table>
                  @endif
                  <div class="p-3">
                    @if($current_file)
                      <a href="?dl={{ $path }}">
                        <span class="fa fa-download"></span> Download file
                      </a>
                      -
                      <a id="clean-log" href="?clean={{ $path }}" data-val="Clean File">
                        <span class="fa fa-sync"></span> Clean file
                      </a>
                      -
                      <a id="delete-log" href="?del={{ $path }}" data-val="Delete File">
                        <span class="fa fa-trash"></span> Delete file
                      </a>
                      {{-- @if(count($files) > 1)
                        -
                        <a id="delete-all-log" href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                          <span class="fa fa-trash-alt"></span> Delete all files
                        </a>
                      @endif --}}
                    @endif
                  </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
      });

      $('#delete-log, #clean-log, #delete-all-log').click(function () {
        event.preventDefault();
        var link = $(this);
        new swal({
              title: 'Are you sure?',
              type: 'error',
              text: 'You Want to ' + $(this).data('val') + '!',
              showCancelButton: true,
              cancelButtonText: 'No',
              confirmButtonText: 'Yes'
          }).then(function(result) {
            console.log(result);
            if(result.isConfirmed){
              window.location = link.attr('href');
            }
          }).catch(function(result) {
                console.log(result);
            });
          });
  </script>
 </body>
</html>
