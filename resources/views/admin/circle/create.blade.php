@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Add a new circle</div>
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>新增失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('admin/circle') }}" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="text" name="name" class="form-control" required="required" placeholder="Name">
                        <br>
                        <textarea name="brief" rows="10" class="form-control" required="required" placeholder="Brief"></textarea>
                        <br>

                        <div class="row">
            				<div class="col-md-12">
            					<input type="file" name="image"  />
            				</div>

            			</div>

                        <br>
                        <button class="btn btn-lg btn-info">New circle</button>

                    </form>


                </div>
            </div>
        </div>
    </div>

</div>





@endsection
