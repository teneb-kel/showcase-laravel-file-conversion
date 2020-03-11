@extends('layout')

@section('title')
    Modify country list
@stop

@section('content')
    <div class="float-right mb-3 mr-2">
        <button class="action-append btn btn-primary d-inline">Add row</button>
            <div class="dropdown d-inline">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Export as...
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <form action="/export" method="POST" target="_blank" class="action-export d-inline">
                        @csrf
                        <input type="submit" name="format" class="dropdown-item" value="JSON"/>
                    </form>
                    <form action="/export" method="POST" target="_blank" class="action-export d-inline">
                        @csrf
                        <input type="submit" name="format" class="dropdown-item" value="CSV"/>
                    </form>
                    <form action="/export" method="POST" target="_blank" class="action-export d-inline">
                        @csrf
                        <input type="submit" name="format" class="dropdown-item" value="XML"/>
                    </form>
                </div>
            </div>
    </div>
    <table id="content" class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th data-override="country">Country</th>
                <th data-override="capital">Capital</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $entry)
            <tr>
                <td contenteditable="true">{{$entry['country']}}</td>
                <td contenteditable="true">{{$entry['capital']}}</td>
                <td>
                    <button class="action-delete btn btn-danger btn-flat btn-sm">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('styles')
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/table-to-json@1.0.0/lib/jquery.tabletojson.min.js" integrity="sha256-H8xrCe0tZFi/C2CgxkmiGksqVaxhW0PFcUKZJZo1yNU=" crossorigin="anonymous"></script>

    <script>

        $(document).on('click', '.action-delete', function(e)
        {
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.action-append', function(e)
        {
            $('#content tbody tr:last').clone().appendTo('#content tbody').find('[contenteditable=true]').empty();
        });

        $(document).on('submit', '.action-export', function(e)
        {
            var content = $('#content').tableToJSON({
                ignoreColumns: [2],
                ignoreEmptyRows: true
            });

            $("<input />").attr("type", "hidden")
                .attr("name", "content")
                .attr("value", JSON.stringify(content))
                .appendTo(this);
            return true;
        });
    </script>
@stop
