@extends('admin.layout')
@section('content')
<div id="page-wrapper">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    所有分类<a href="{{ url('admin/category/add') }}" class="pull-right btn btn-success btn-xs">新增分类</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @foreach($categories as $category)
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>{{ $category->name }}</strong><a href="{{ url('admin/category/edit',['categoryId'=>$category->id]) }}" class="btn btn-primary btn-xs pull-right">修改</a></div>
                        @if(!empty($category->subCategories))
                        <ul class="list-group">
                            @foreach($category->subCategories as $sub)
                                <li class="list-group-item"> {{ $sub->name }}<a href="{{ url('admin/category/edit',['categoryId'=>$sub->id]) }}" class="btn btn-primary btn-xs pull-right">修改</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endforeach
                    {{ $categories->render() }}
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