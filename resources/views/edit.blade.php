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

        /*$(document).on('click', '.action-export', function(e)
        {
            var format = $(this).attr('data-format');
            var content = $('#content').tableToJSON({
                ignoreColumns: [2],
                ignoreEmptyRows: true
            });

            $.ajax({
                type: "POST",
                url: '/export',
                data: {
                    format: format,
                    content: JSON.stringify(content)
                }
            }).done(function (response, status, xhr) {
                var filename = "";
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                }

                var type = xhr.getResponseHeader('Content-Type');
                var blob = new Blob([response], { type: type });

                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);

                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }

                    setTimeout(function () { URL.revokeObjectURL(downloadUrl); }, 100); // cleanup
                }
            });
        });*/
    </script>
@stop
