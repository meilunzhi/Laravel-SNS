@extends('admin.layout')
@section('content')
<div id="page-wrapper">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{ $title }}</strong> 的评论
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <ul class="media-list">
                        @foreach($comments as $comment)
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="http://pic1a.nipic.com/2008-12-03/2008123122853189_2.jpg" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4>{{ $comment->user->nickname }} <small>{{ $comment->created_at }}</small></h4>
                                <p>{{ $comment->content }}</p>
                                @if(!empty($comment->childComment))
                                    @foreach($comment->childComment as $childComment)
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object" src="http://pic1a.nipic.com/2008-12-03/2008123122853189_2.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4>{{ $childComment->user->nickname }} <small>{{ $childComment->created_at }}</small></h4>
                                                <p>{{ $childComment->content }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    
</div>
<!-- /#page-wrapper -->

@stop