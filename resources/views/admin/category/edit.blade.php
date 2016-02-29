@extends('admin.layout')
@section('content')
<div id="page-wrapper">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    社区分类信息修改
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form action="{{ url('admin/category/update') }}" method="post" class="form-horizontal">
                        <input type="hidden" name="id" value="{{ $category->id }}" />
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" value="{{ $category->name }}" id="name" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.panel-body -->
                <div class="panel-footer text-center">
                    修改成功后会自动转到分类列表
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    
</div>
<!-- /#page-wrapper -->

@stop