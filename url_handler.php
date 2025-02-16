<?php
	const LOGIN =  'o_4dkf0dhc6p';
	const API_KEY =  'R_a9dbe6c319fe4397946c86b8798b7abb';
	const END_POINT =  'http://api.bit.ly/v3';
	const HELP_REPLY = 'Данный бот предназначен для работы со ссылками. Он умеет сокращать или расшифровывать уже сокращённые ссылки. Для того, чтобы воспользоваться ботом, отправьте ему ссылку, которую необходимо сократить. Для просмотра последних действий, воспользуйтесь командой /history';
	const DB_HOST = 'us-cdbr-iron-east-02.cleardb.net';
	const DB_USER = 'b8ee931ac989b3';
	const DB_PASS = '672ff549';
	const DB_NAME = 'heroku_3fd1c3b404a32b0';
	
	function getShortUrl($longUrl):string {
        $url = "http://api.bit.ly/shorten?version=2.0.1&longUrl=$longUrl&login=o_4dkf0dhc6p&apiKey=R_a9dbe6c319fe4397946c86b8798b7abb&format=json&history=1";
        $s = curl_init();
        curl_setopt($s,CURLOPT_URL, $url);
        curl_setopt($s,CURLOPT_HEADER,false);
        curl_setopt($s,CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($s);
        curl_close( $s );
        $obj = json_decode($result, true);
        $res = $obj["results"]["$longUrl"]["shortUrl"];
        if (strlen($res) != 0) {
            return $res;
        }
        else {
            return 'Ссылка некорректна';
        }
    }
	
	function getLongUrl($shortUrl):string {
		$query = http_build_query(
			array(
				'login' => LOGIN,
				'apiKey' => API_KEY,
				'shortUrl' => $shortUrl,
				'format' => 'txt'
			)
		);
		$res = file_get_contents(sprintf('%s/%s?%s', END_POINT, 'expand', $query));
		if ($res == 'NOT_FOUND' or $res == 'bit.ly') {
			return "Ссылка некорректна";
		}
		else { 	
			return $res;
		}
	}