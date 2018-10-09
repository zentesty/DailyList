<?php
require_once "M3UFile.php";

/**
 * Created by PhpStorm.
 * User: martin-pierreroy
 * Date: 2018-10-03
 * Time: 3:46 PM
 */
//echo @date('dmy') . "</br>" ;

//$m3ufile = new M3UFile();
//$m3ufile->is_ready();


//echo @date_create(@date('dmy'))->modify('-15 days')->format('dmy');
//echo "</br>" ;
//
//$x = 0;
//echo @date_create(@date('dmy'))->modify('-' . $x .' days')->format('dmy');
//echo "</br>" ;
//
//$a = [];
//array_push($a, 10);
//array_push($a, 20);
//array_push($a, 30);
//foreach($a as $entry){
//    echo $entry . "</br>";
//}

//$sub = "#EXTINF:-1,CA: BBC WORLD NEWS | HD";
//echo substr($sub, 0, 8) . "</br>";
//if(substr($sub, 0, 8) == "#EXTINF:"){
//    echo "____YES_____" . "</br>";
//
//}
//echo substr($sub, 1, 8) . "</br>";

function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}


function URLIsValid($URL)
{
    $exists = true;
    $file_headers = @get_headers($URL);
    $InvalidHeaders = array('404', '403', '500');
    foreach($InvalidHeaders as $HeaderVal)
    {
        if(strstr($file_headers[0], $HeaderVal))
        {
            $exists = false;
            break;
        }
    }
    return $exists;
}

$ret = url_exists("http://aa.zcccentelia.com");
if($ret){
    echo "YES </bt>";
} else {
    echo "NO </bt>";

}


function checkURL($url, array $options = array()) {
    if (empty($url)) {
        throw new Exception('URL is empty');
    }

    // list of HTTP status codes
    $httpStatusCodes = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error'
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    if (isset($options['timeout'])) {
        $timeout = (int) $options['timeout'];
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    }

    curl_exec($ch);
    $returnedStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (array_key_exists($returnedStatusCode, $httpStatusCodes)) {
        return "URL: '{$url}' - Error code: {$returnedStatusCode} - Definition: {$httpStatusCodes[$returnedStatusCode]}";
    } else {
        return "'{$url}' does not exist";
    }
}

