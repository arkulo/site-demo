<?php
/**
 * 网易微博 API client for PHP
 *
 * @author PiscDong (http://www.piscdong.com/)
 */
class t163PHP
{
	public $api_url='https://api.t.163.com/';
	public $format='json';

	public function __construct($client_id, $client_secret, $access_token=NULL){
		$this->client_id=$client_id;
		$this->client_secret=$client_secret;
		$this->access_token=$access_token;
	}

	//生成授权网址
	public function login_url($callback_url){
		$params=array(
			'response_type'=>'code',
			'client_id'=>$this->client_id,
			'redirect_uri'=>$callback_url
		);
		return 'https://api.t.163.com/oauth2/authorize?'.http_build_query($params);
	}

	//获取access token
	public function access_token($callback_url, $code){
		$params=array(
			'grant_type'=>'authorization_code',
			'code'=>$code,
			'client_id'=>$this->client_id,
			'client_secret'=>$this->client_secret,
			'redirect_uri'=>$callback_url
		);
		$url='https://api.t.163.com/oauth2/access_token';
		return $this->http($url, http_build_query($params), 'POST');
	}

	//使用refresh token获取新的access token
	public function access_token_refresh($refresh_token){
		$params=array(
			'grant_type'=>'refresh_token',
			'refresh_token'=>$refresh_token,
			'client_id'=>$this->client_id,
			'client_secret'=>$this->client_secret
		);
		$url='https://api.t.163.com/oauth2/access_token';
		return $this->http($url, http_build_query($params), 'POST');
	}

	//获取登录用户信息
	public function me(){
		$params=array();
		return $this->api('users/show', $params);
	}

	//获取用户微博列表
	public function user_timeline($id, $count=10){
		$params=array(
			'user_id'=>$id,
			'count'=>$count
		);
		return $this->api('statuses/user_timeline', $params);
	}

	//发布微博
	public function update($status){
		$params=array(
			'status'=>$status
		);
		return $this->api('statuses/update', $params, 'POST');
	}

	//调用接口
	/**
	//示例：获取登录用户信息
	$result=$t163->api('users/show', array(), 'GET');
	**/
	public function api($url, $params=array(), $method='GET'){
		$url=$this->api_url.$url.'.'.$this->format;
		$params['access_token']=$this->access_token;
		if($method=='GET'){
			$result=$this->http($url.'?'.http_build_query($params));
		}else{
			$result=$this->http($url, http_build_query($params), 'POST');
		}
		return $result;
	}

	//提交请求
	private function http($url, $postfields='', $method='GET', $headers=array()){
		$ci=curl_init();
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ci, CURLOPT_TIMEOUT, 30);
		if($method=='POST'){
			curl_setopt($ci, CURLOPT_POST, TRUE);
			if($postfields!='')curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
		}
		$headers[]='User-Agent: t163.PHP(piscdong.com)';
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ci, CURLOPT_URL, $url);
		$response=curl_exec($ci);
		curl_close($ci);
		$json_r=array();
		if($response!='')$json_r=json_decode($response, true);
		return $json_r;
	}
}
