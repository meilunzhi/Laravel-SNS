/**
*	工具类
*/
define(['jquery'],function($){
	var baseUrl = baseUrl || '/index.php/admin';
	var utils = {
		// 生成后台uri
        // example: /index.php/admin/user
        makeUri: function(uri){
            return baseUrl.trim('/') + uri;
        },
        request : function(){
        	return {
	        	params : {
	        		type : 'GET',
	        		data : {},
	        		url:'',
	        		success : function($msg){},
	        		error:function($msg){}
	        	},
	        	get:function(){
	        		this.params.type = 'GET';
	        		return this;
	        	},
	        	post:function(){
	        		this.params.type = 'POST';
	        		return this;
	        	},
	        	data:function($data){
	        		this.params.data = $data;
	        		return this;
	        	},
	        	url:function($url){
	        		this.params.url = utils.makeUri($url);
	        		return this;
	        	},
	        	success:function($call){
	        		console.log('request success:' + this.params.url);
	        		if(typeof $call == 'function'){
	        			this.params.success = $call;
	        		}
	        		return this;
	        	},
	        	error:function($call){
	        		console.log('request error:' + this.params.url);
	        		if(typeof $call == 'function'){
	        			this.params.error = $call;
	        		}
	        		return this;
	        	},
	        	exec:function(){
	        		console.log(this.params);
	        		$('.loading').show();
					$.ajax(this.params).always(function(){
						//console.log('request finished:',this.params.url);
		                $('.loading').hide();
					});
	        	}
        	};
        },
        
		
	};
	return utils;
});