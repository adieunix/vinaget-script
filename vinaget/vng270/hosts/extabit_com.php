<?php

class dl_extabit_com extends Download {

    public function CheckAcc($cookie){
         $data = $this->lib->curl("http://extabit.com/premium.jsp", "language=en;".$cookie, "");
         if(stristr($data, 'Premium is active till')) return array(true, "Until ".$this->lib->cut_str($data, 'Premium is active till','<img src="http://st.extabit.com/s/img/menu/star.png" width="9" height="10" alt="*" /></span>'));
         else if(stristr($data, 'Buy premium <img src="http://st.extabit.com/s/img/menu/star.png" width="9" height="10" alt="*" /></span>')) return array(false, "accfree");
		 else return array(false, "accinvalid");
    }

	public function Login($user, $pass){
		$post['email'] = $user;
		$post['pass'] = $pass;
		$post['auth_submit_login'] = "Enter";
		$post['remember'] = "1";
		$data = $this->lib->curl("http://extabit.com/login.jsp", "language=en", $post);
		$cookie = "language=en;".$this->lib->GetCookies($data);
		return $cookie;
	}
	
    public function Leech($url) {
		$data = $this->lib->curl($url,$this->lib->cookie,"");
		if(stristr($data,'An error occurred')) $this->error("An error occurred. Please try again later.", true, false, 2);
		elseif (stristr($data,'File is temporary unavailable') || stristr($data,'<h3>File not found</h3>')) $this->error("dead", true, false, 2);
		elseif(!preg_match('@https?:\/\/p(\d+)?\.extabit\.com\/[^"\'><\r\n\t]+@i', $data, $giay))
		$this->error("notfound", true, false, 2); 
		else 	
		return trim($giay[0]);
		return false;
    }

}

/*
* Open Source Project
* Vinaget by ..::[H]::..
* Version: 2.7.0
* Extabit Download Plugin 
* Downloader Class By [FZ]
* Add check account, fix error by giaythuytinh176 [21.7.2013]
*/
?>