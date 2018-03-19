@extends('master.master')

@section('title', 'Book Import')


@section('success')

    {{\Session::get('success')}}

@endsection

@section('error')

    {{\Session::get('error')}}

@endsection

@section('content')
    <meta name="_token" content="{{ csrf_token() }}" />
    <script>

        $(document).ready(function () {

            $('#btn-Upload').on('click',function (e) {
                $("#LoadingImage").show();
                e.preventDefault();
                var extension = $('#file_name').val().split('.').pop().toLowerCase();

                if($.inArray(extension,['xls','xlsx']) == -1)
                {
                    $("#LoadingImage").hide();

                    $.alert({
                        title: 'Error',
                        content: 'Invalid file type.Select Excel File!',
                    });

                }else{

                    var file_data = $('#file_name').prop('files')[0];

                    var form_data = new FormData();
                    form_data.append('file',file_data);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-Token': $('meta[name=_token]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{url('BookImport')}}", // point to server-side PHP script
                        data: form_data,
                        type: 'POST',
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        success: function(data) {

                            $("#LoadingImage").hide();

                            $.alert({
                                title: 'Info',
                                content: data,
                            });

                        },
                        error: function (data) {
                            $("#LoadingImage").hide();
                            console.log('Error:', data);
                        }
                    });


                }



            });
        });
    </script>
    <div class="container content-body">

        <div id="LoadingImage" style="display:none;position: absolute; top: 280px;left:500px; z-index: 99999; height: 600px;">
            <img src="{{asset('images/loader.gif')}}" style="" />
        </div>

        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Book Importing</h4>
            </div>
        </div>
        <form method="POST"  id="search-form" action="{{'BookImport'}}" enctype="multipart/form-data">
            {{csrf_field()}}


            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <div class="row datatable-content">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_name">Excel File Name:</label>
                            <input type="file" class="form-control" id="file_name" name="file_name">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary form-control" id="btn-Upload">Upload</button>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection