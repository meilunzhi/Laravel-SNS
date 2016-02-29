@extends('admin.layout')
@section('content')
<div id="page-wrapper">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    用户信息修改
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form action="{{ url('admin/user/update') }}" method="post" class="form-horizontal">
                        <input type="hidden" name="id" value="{{ $user->id }}" />
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nickname" value="{{ $user->nickname }}" id="nickname" placeholder="昵称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="login_type" class="col-sm-2 control-label">注册类型</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="login_type" value="{{ $user->login_type }}" id="login_type" placeholder="注册类型" disabled="">
                            </div>
                            <div class="col-sm-2">
                                <strong>注册类型不可修改</strong>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">积分</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="score" value="{{ $user->score }}" id="score" placeholder="积分">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">电话</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" id="phone" placeholder="电话">
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
                    修改成功后会自动转到用户列表
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    
</div>
<!-- /#page-wrapper -->

@stop