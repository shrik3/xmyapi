@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Manage circles</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <a href="{{ url('admin/circle/create') }}" class="btn btn-lg btn-primary">新增</a>

                    @foreach ($circles as $circle)
                        <hr>
                        <div class="circle">
                            <h4>{{ $circle->name }}</h4>
                            <div class="content">
                                <p>
                                    {{ $circle->brief }}
                                </p>
                            </div>
                        </div>

                        <form action="{{ url('admin/circle/'.$circle->id) }}" method="POST" style="display: inline;">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">删除</button>
                        </form>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
