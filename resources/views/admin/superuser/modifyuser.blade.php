@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">change user icon</div>
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>新增失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('admin/changeicon') }}" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="text" name="userid" class="form-control" required="required" placeholder="user id">
                        <br>
                        <div class="row">
            				<div class="col-md-12">
            					<input type="file" name="image"  />
            				</div>
                        </div>
                        <br>
                        <button class="btn btn-lg btn-info">go</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
