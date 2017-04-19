@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Manage communities</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <a href="{{ url('admin/community/create') }}" class="btn btn-lg btn-primary">新增</a>

                    @foreach ($communities as $community)
                        <hr>
                        <div class="community">
                            <h4>{{ $community->name }}</h4>
                            <div class="content">
                                <p>
                                    {{ $community->brief }}
                                </p>
                            </div>
                        </div>

                        <form action="{{ url('admin/community/'.$community->id) }}" method="POST" style="display: inline;">
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
