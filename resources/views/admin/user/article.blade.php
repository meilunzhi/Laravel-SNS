@extends('admin.layout')
@section('content')
<div id="page-wrapper">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{ $nickname }}</strong>发表的帖子
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>文章ID</th>
                                <th>标题</th>
                                <th>作者</th>
                                <th>类别</th>
                                <th>访问量</th>
                                <th>点赞量</th>
                                <th>评论数</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($articles as $article)
                            <tr class="odd gradeX">
                                <td>{{ $article->id }}</td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->user->nickname }}</td>
                                <td>{{ $article->category->name }}</td>
                                <td>{{ $article->view }}</td>
                                <td>{{ $article->praise }}</td>
                                <td>{{ count($article->comments) }}</td>
                                <td>{{ $article->created_at }}</td>
                                <td>
                                    <a href="{{ url('admin/article/comment',['id'=>$article->id]) }}" class="btn btn-primary btn-xs">评论</a>
                                    <a href="{{ url('admin/article/reward',['id'=>$article->id]) }}" class="btn btn-success btn-xs">打赏</a>
                                	<a href="{{ url('admin/article/delete',['id'=>$article->id]) }}" class="btn btn-danger btn-xs">删除</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
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