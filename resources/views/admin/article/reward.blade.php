@extends('admin.layout')
@section('content')
<div id="page-wrapper">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{ $title }}</strong> 帖子打赏记录
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>打赏ID</th>
                                <th>用户</th>
                                <th>积分</th>
                                <th>打赏时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($rewards as $reward)
                            <tr class="odd gradeX">
                                <td>{{ $reward->id }}</td>
                                <td>{{ $reward->user->nickname }}</td>
                                <td>{{ $reward->score }}</td>
                                <td>{{ $reward->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $rewards->render() }}
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