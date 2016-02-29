/**
*   20160223
*	require.js入口文件
*/
require.config({
	baseUrl:'/js',
	paths:{
		jquery:'//cdn.bootcss.com/jquery/1.11.3/jquery.min',
		bootstrap:'//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min',
		metisMenu:'metisMenu',
		admin:'sb-admin-2'
	},
	shim:{
        bootstrap : ['jquery']
	}
});

define('jquery-private', ['jquery'], function (jq) {
    return jq.noConflict(true);
});

require(['jquery','bootstrap','metisMenu','admin']);