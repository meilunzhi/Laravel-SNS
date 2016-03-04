<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>社区后台管理</title>
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/metisMenu.css') }}">
	<link rel="stylesheet" href="{{ asset('css/sb-admin-2.css') }}">
	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
	@yield('css')
</head>
<body>
	<div id="wrapper">

	    <!-- 顶部导航条和侧边栏start -->
	    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	            <a class="navbar-brand" href="index.html">社区后台管理</a>
	        </div>
	        <!-- /.navbar-header -->

	        <ul class="nav navbar-top-links navbar-right">
	            
	            <!-- /.dropdown -->
	            <li class="dropdown">
	                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
	                </a>
	                <ul class="dropdown-menu dropdown-user">
	                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
	                    </li>
	                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
	                    </li>
	                    <li class="divider"></li>
	                    <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
	                    </li>
	                </ul>
	                <!-- /.dropdown-user -->
	            </li>
	            <!-- /.dropdown -->
	        </ul>
	        <!-- /.navbar-top-links -->

	        <div class="navbar-default sidebar" role="navigation">
	            <div class="sidebar-nav navbar-collapse">
	                <ul class="nav" id="side-menu">
	                    <li>
	                        <a href="{{ url('admin/dashboard/dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> 仪表盘</a>
	                    </li>
	                    <li>
	                    	<a href="{{ url('admin/user/users') }}"><i class="fa fa-user fa-fw"></i> 用户管理</a>
	                    </li>
	                    <li>
	                    	<a href="{{ url('admin/article/articles') }}"><i class="fa fa-list-alt fa-fw"></i> 帖子管理</a>
	                    </li>
	                    <li>
	                    	<a href="{{ url('admin/category/categories') }}"><i class="fa fa-th-list fa-fw"></i> 社区分类</a>
	                    </li>
	                </ul>
	            </div>
	            <!-- /.sidebar-collapse -->
	        </div>
	        <!-- /.navbar-static-side -->
	    </nav>
	    <!-- 顶部导航条和侧边栏end -->
		
		<!-- 主题内容start -->
		@yield('content')
	    
	    <!-- 主体内容end -->

	</div>
</body>
<script data-main="{{ asset('js/main') }}" src="{{ asset('js/require.js') }}" ></script>
@yield('js')
</html>