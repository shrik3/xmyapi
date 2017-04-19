@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">MANAGE COMMENTS</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif


                        @foreach ($comments as $comment)
                            <hr>
                            <div class="comment">
                                <h4>{{ $comment->nickname }}</h4>
                                <div class="content">
                                    <p>
                                        {{ $comment->content }}
                                    </p>
                                </div>
                            </div>
                                <form action="{{ url('admin/manage_comments/'.$comment->id) }}" method="POST" style="display: inline;">
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