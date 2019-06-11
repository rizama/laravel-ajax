<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax Todo List Project</title>
    <link rel="stylesheet" href="{{ asset('bootstrap3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
</head>
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Ajax Todo List <a href="#" class="pull-right" id="addNew"><i class="icon-plus" aria-hidden="true" data-target="#myModal" data-toggle="modal"></i></a></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group" id="ulItem">
                          @foreach ($items as $item)
                            <li class="list-group-item ourItem" data-target="#myModal" data-toggle="modal">{{$item->item}}
                                <input type="hidden" id="itemId" value="{{$item->id}}">
                            </li>  
                          @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
              <input type="text" name="search" id="search" class="form-control" placeholder="Search">
            </div>
        </div>
    </div>

    

  <!-- /.modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="title">Add New Item</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id">
          <p><input type="text" name="item" class="form-control" id="item" placeholder="Add New Item" required></p>
          @csrf
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal" style="display: none;">Delete</button>
          <button type="button" class="btn btn-primary" id="saveChanges" style="display: none;" data-dismiss="modal">Save changes</button>
          <button type="button" class="btn btn-primary" id="addButton" data-dismiss="modal">Add Item</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap3/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script>
      $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
      })
  </script>
  <script>
    $(document).ready(function(){
      $(document).on('click', '.ourItem', function(event){
          var text = $.trim($(this).text());
          var id = $(this).find('#itemId').val();
          $('#title').text('Edit Item');
          $('#item').val(text);
          $('#delete').show('500');
          $('#saveChanges').show('500');
          $('#addButton').hide();
          $('#id').val(id);
          console.log(text);
      });
      
      $(document).on('click', '#addNew',function(event){
        $('#title').text('Add New Item');
        $('#item').val("");
        $('#delete').hide();
        $('#saveChanges').hide();
        $('#addButton').show();
      });

      $('#addButton').click(function(event){
        var item = $('input[name=item]').val();
        if (item == "") {
          alert('Please type anythin for item');
        }else{
          $.post('list', {
            'item' : item,
            '_token': $('input[name=_token]').val()
          }, function(data){
            console.log(data);
            $('#ulItem').load(location.href + ' #ulItem');
          });
        }
      });

      $('#delete').click(function(event){
        var id = $('#id').val();
        $.post('destroy', {
          'id' : id,
          '_token': $('input[name=_token]').val()
        }, function(data){
          console.log(data);
          $('#ulItem').load(location.href + ' #ulItem');
        });
      });

      $('#saveChanges').click(function(event){
        var item = $('input[name=item]').val();
        var id = $('#id').val();
        if (item == "") {
          alert('Please type anythin for item');
        }else{
          $.post('update', {
            'item' : item,
            'id': id,
            '_token': $('input[name=_token]').val(),
          }, function(data){
            console.log(data);
            $('#ulItem').load(location.href + ' #ulItem');
          });
        }
      });

      $(function() {
        $( "#search" ).autocomplete({
          source: '{{ route('search') }}'
        });
      });
    });
  </script>
</body>
</html>