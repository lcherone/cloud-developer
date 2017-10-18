<?php
namespace Framework {

    use RedBeanPHP\R;

    class Helper extends \Prefab
    {
        /**
         *
         */
        public function __construct()
        {
            // framework - not included; but available
            // $this->f3 = \Base::instance();
        }

        /**
         *
         */
        public function format_bytes($bytes = 0)
        {
            if ($bytes < 1024) {
                return $bytes.' B';
            } elseif ($bytes < 1048576) {
                return round($bytes / 1024, 2).' KiB';
            } elseif ($bytes < 1073741824) {
                return round($bytes / 1048576, 2).' MiB';
            } elseif ($bytes < 1099511627776) {
                return round($bytes / 1073741824, 2).' GiB';
            } else {
                return round($bytes / 1099511627776, 2).' TiB';
            }
        }

        /**
         *
         */
        public function short_number($n = 0)
        {
            // first strip any formatting;
            $n = (0+str_replace(",", "", $n));

            // is this a number?
            if (!is_numeric($n)) {
                return false;
            }

            // now filter it;
            if ($n > 1000000000000) {
                return round(($n/1000000000000), 2).'t';
            } elseif ($n > 1000000000) {
                return round(($n/1000000000), 2).'b';
            } elseif ($n > 1000000) {
                return round(($n/1000000), 2).'m';
            } elseif ($n > 1000) {
                return round(($n/1000), 2).'k';
            }

            return number_format($n);
        }

        /**
         *
         */
        public function time_elapsed_string($ptime)
        {
            $etime = time() - $ptime;

            if ($etime < 1) {
                return '0 seconds';
            }

            $plurals = array(
                'year'   => 'years',
                'month'  => 'months',
                'day'    => 'days',
                'hour'   => 'hours',
                'min' => 'mins',
                'sec' => 'secs'
            );

            foreach (array(
                365 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60  =>  'month',
                24 * 60 * 60  =>  'day',
                60 * 60  =>  'hour',
                60  =>  'min',
                1  =>  'sec'
            ) as $secs => $str) {
                $d = $etime / $secs;
                if ($d >= 1) {
                    $r = round($d);
                    return $r . ' ' . ($r > 1 ? $plurals[$str] : $str) . ' ago';
                }
            }
        }

        /**
         * Create a javascript escaped string.
         */
        public function html_js_encode($str)
        {
            $str = preg_replace('/^\s+|\n|\r|\s+$/m', '', $str);
            $enc = '';
            for ($i=0; $i < strlen($str); $i++) {
                $hex = dechex(ord($str[$i]));
                $enc .= ($hex == '') ? $enc.urlencode($str[$i]) : '%'.((strlen($hex) == 1) ? '0'.strtoupper($hex) : strtoupper($hex));
            }
            $enc = str_replace(
                array('.','+','_','-'),
                array('%2E','%20','%5F','%2D'),
                $enc
            );
            $sec = substr(sha1(microtime(true)), 0, 5);

            return '
            <div id="'.$sec.'"></div><script type="text/javascript">$(document).ready(function() {var x'.$sec.'x="'.$enc.'";$("#'.$sec.'").html(unescape(x'.$sec.'x));});</script>
            <noscript>
                <div id="noscript_notice">
                    <p>Please enable JavaScript!</p>
                </div>
            </noscript>'.PHP_EOL;
        }

        /**
         *
         */
        public function slugify($text)
        {
            // replace non letter or digits by -
            $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
            // trim
            $text = trim($text, '-');
            // transliterate
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
            // lowercase
            $text = strtolower($text);
            // remove unwanted characters
            $text = preg_replace('~[^-\w]+~', '', $text);
            if (empty($text)) {
                return 'n-a';
            }
            return $text;
        }

        /**
         * Attempts to get originating IP address of user,
         * Spoofable, but works load balancing and containers ect.
         * pulls first ip from multi level proxied HTTP_X_FORWARDED_FOR e.g "ip, ip, ip"
         */
        public function getIPAddress()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (stristr($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
                
                if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($_SERVER['HTTP_X_REAL_IP']) && filter_var($_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = $_SERVER['HTTP_X_REAL_IP'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            
            if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            
            return preg_replace("([^0-9\.])", '', $ip);
        }

        /**
         *
         */
        public function get_gravatar($email = null, $size = 100)
        {
            if ($email == null) {
                return '//secure.gravatar.com/avatar/?d=mm&secure=true';
            }
            return '//secure.gravatar.com/avatar/'.md5(trim($email)).'?default=mm&secure=true&size='.(int) $size;
        }

        /**
         *
         */
        public function strip_extra_spaces($str)
        {
            return preg_replace('/\s+/', ' ', $str);
        }

        /**
         * Validate json, throws exception or returns object/array
         *
         * @param string $str
         * @param bool $return_array
         * @return mixed
         */
        public function json_validate($str, $return_array = false)
        {
            // decode the JSON data
            $result = json_decode($str, $return_array);

            // switch and check possible JSON errors
            switch (json_last_error()) {
                case JSON_ERROR_NONE: {
                    $error = ''; // JSON is valid
                } break;

                case JSON_ERROR_DEPTH: {
                    $error = 'The maximum stack depth has been exceeded.';
                } break;

                case JSON_ERROR_STATE_MISMATCH: {
                    $error = 'Invalid or malformed JSON.';
                } break;

                case JSON_ERROR_CTRL_CHAR: {
                    $error = 'Control character error, possibly incorrectly encoded.';
                } break;

                case JSON_ERROR_SYNTAX: {
                    $error = 'Syntax error, malformed JSON.';
                } break;

                // PHP >= 5.3.3
                case JSON_ERROR_UTF8: {
                    $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                } break;

                // PHP >= 5.5.0
                case JSON_ERROR_RECURSION: {
                    $error = 'One or more recursive references in the value to be encoded.';
                } break;

                // PHP >= 5.5.0
                case JSON_ERROR_INF_OR_NAN: {
                    $error = 'One or more NAN or INF values in the value to be encoded.';
                } break;

                case JSON_ERROR_UNSUPPORTED_TYPE: {
                    $error = 'A value of a type that cannot be encoded was given.';
                } break;

                default: {
                    $error = 'Unknown JSON error occured.';
                } break;
            }

            if ($error !== '') {
                throw new \Exception($error);
                return false;
            }

            return $result;
        }

        /**
         *
         */
        public function http_response_code_text($domain)
        {
            $headers = @get_headers('http://'.$domain);

            if (empty($headers)) {
                return '<span class="label label-danger">503 ('.$this->response_code_text(503).')</span>';
            }

            $status = explode(' ', $headers[0])[1];

            if (strlen($status) > 0) {
                //set status color to warning if not 200
                if ($status == 200) {
                    $labelColor = 'success';
                } elseif ($status == 404) {
                    $labelColor = 'warning';
                } else {
                    $labelColor = 'danger';
                }

                return '<span class="label label-'.$labelColor.'">'.$status.' ('.$this->response_code_text($status).')</span>';
            } else {
                return '<span class="label label-danger">503 ('.$this->response_code_text(503).')</span>';
            }
        }

        /**
         *
         */
        public function response_code_text($code)
        {
            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    $text = $code;
                    break;
            }
            return $text;
        }

        /**
         * Unique multidim array
         *
         * @codeCoverageIgnore
         */
        public function unique_multidim_array($array = [], $key = '')
        {
            $temp_array = $key_array = [];

            $i = 0;
            foreach ($array as $val) {
                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }
                $i++;
            }
            return $temp_array;
        }

        /**
         * Sort array by column
         *
         * @codeCoverageIgnore
         */
        public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
        {
            $sort_col = array();
            foreach ($arr as $key => $row) {
                $sort_col[$key] = $row[$col];
            }
            return array_multisort($sort_col, $dir, $arr);
        }

        /**
         * simple encrypt string
         *
         * iv is stored as part of the returned ciphertext, uses base91 from Plinker lib
         */
        public function encrypt($plaintext, $secret = '')
        {
            $mode  = 'AES-256-CBC';
            $check = false;
            $ivlen = openssl_cipher_iv_length($mode);
            $iv    = openssl_random_pseudo_bytes($ivlen, $check);

            if (!$check) {
                throw new Exception("Non-cryptographically strong algorithm used for iv generation. This IV is not safe to use.");
            }

            return \Base91\Base91::encode(base64_encode($iv).':'.base64_encode(openssl_encrypt($plaintext, $mode, $secret, 0, $iv)));
        }

        /**
         * simple decrypt string
         */
        public function decrypt($ciphertext, $secret = '')
        {
            $mode  = 'AES-256-CBC';

            list($iv, $ciphertext) = explode(':', \Base91\Base91::decode($ciphertext));
            $iv = base64_decode($iv);
            $ciphertext = base64_decode($ciphertext);

            return openssl_decrypt($ciphertext, $mode, $secret, 0, $iv);
        }

        /**
         * Get IP info from ip address
         */
        public function get_ip_info($ip = null)
        {
            if ($ip == null) {
                $ip = $this->getIPAddress();
            }

            $ipinfo = R::findOrCreate('ipinfo', [
                'ip' => $ip
            ]);

            // if we dont have a status query the API
            if (empty($ipinfo['status'])) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://ip-api.com/json/'.$ip);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $data = curl_exec($ch);

                $data = json_decode($data, true);
                
                putenv('RES_OPTIONS=retrans:1 retry:1 timeout:1 attempts:1');

                $ipinfo['ip']       = $ip;
                $ipinfo['hostname'] = @gethostbyaddr($data['query']);
                $ipinfo['isp']      = @$data['isp'];
                $ipinfo['as']       = @$data['as'];
                $ipinfo['city']     = @$data['city'];
                $ipinfo['country']  = @$data['country'];
                $ipinfo['country_code'] = @$data['countryCode'];
                $ipinfo['lat']      = @$data['lat'];
                $ipinfo['lon']      = @$data['lon'];
                $ipinfo['org']      = @$data['org'];
                $ipinfo['region']   = @$data['region'];
                $ipinfo['region_name'] = @$data['regionName'];
                $ipinfo['timezone'] = @$data['timezone'];
                $ipinfo['zip']      = @$data['zip'];
                $ipinfo['dns']      = json_encode(@dns_get_record(@$ipinfo['hostname']));
                $ipinfo['iplong']   = @ip2long(@$data['query']);
                $ipinfo['status']   = ($data['status'] == 'success' ? 'success' : 'error');

                R::store($ipinfo);
            }

            return R::exportAll($ipinfo)[0];
        }

        /**
         * encode multiple numbers into 2 way short hashes
         *
         * @see composer.json
         * @usage:
         * $ids = $this->app->helper->hashid()->encode(1,2,3);
         * $ids = $this->app->helper->hashid()->decode($ids);
         */
        public function hashid(
            $salt = 'SHA256ed.f0r.4a5h.sa1tlng',
            $length = 6,
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ) {
            return new \Hashids\Hashids(
                hash('sha256', $salt),
                (int) $length,
                $alphabet
            );
        }
        
        /**
         * Build pagination HTML in bootstrap format.
         *
         * @param int $totalposts
         * @param int $p
         * @param int $last_page
         * @return string
         */
        public function pagination($totalposts, $p, $last_page, $link_class = 'ajax-link', $adjacents = 3, $key = 'pg')
        {
            $ret = null;
            $prev = ($p-1);
            $next = ($p+1);
            $last_page = ($totalposts-1);
            
            // sorting
            $sorting =
            (!empty($_GET['c']) ? '&c='.$_GET['c'] : '').
            (!empty($_GET['o']) ? '&o='.($_GET['o'] == 'asc' ? 'asc' : 'desc') : '');

            if ($totalposts > 1) {
                $ret .= '<ul class="pagination" style="margin-top: -1px">';
                
                // previous button
                if ($p > 1) {
                    $ret.= '<li><a href="?'.$key.'='.$prev.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">&laquo; Previous</a></li> ';
                } else {
                    $ret.= '<li class="disabled"><a href="javascript:void(0)">&laquo; Previous</a></li> ';
                }
                
                if ($totalposts < 7 + ($adjacents * 2)) {
                    for ($counter = 1; $counter <= $totalposts; $counter++) {
                        if ($counter == $p) {
                            $ret.= '<li class="active"><a href="javascript:void(0)">'.$counter.'</a></li> ';
                        } else {
                            $ret.= '<li><a href="?'.$key.'='.$counter.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">'.$counter.'</a></li> ';
                        }
                    }
                } elseif ($totalposts > 5 + ($adjacents * 2)) {
                    if ($p < 1 + ($adjacents * 2)) {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                            if ($counter == $p) {
                                $ret.= '<li class="active"><a href="javascript:void(0)">'.$counter.'</a></li> ';
                            } else {
                                $ret.= '<li><a href="?'.$key.'='.$counter.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">'.$counter.'</a></li> ';
                            }
                        }
                        $ret.= ' <li class="disabled"><a href="javascript:void(0)">...</a></li> ';
                        $ret.= ' <li><a href="?'.$key.'='.$last_page.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">'.$last_page.'</a></li> ';
                        $ret.= ' <li><a href="?'.$key.'='.$totalposts.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">'.$totalposts.'</a></li> ';
                    }
                    //in middle; hide some front and some back
                    elseif ($totalposts - ($adjacents * 2) > $p && $p > ($adjacents * 2)) {
                        $ret.= ' <li><a href="?'.$key.'=1'.$sorting.'" class="'.$link_class.'" data-keep-state="true">1</a></li> ';
                        $ret.= ' <li><a href="?'.$key.'=2'.$sorting.'" class="'.$link_class.'" data-keep-state="true">2</a></li> ';
                        $ret.= ' <li class="disabled"><a href="javascript:void(0)">...</a></li> ';
                        for ($counter = $p - $adjacents; $counter <= $p + $adjacents; $counter++) {
                            if ($counter == $p) {
                                $ret.= ' <li class="active"><a href="javascript:void(0)">'.$counter.'</a></li> ';
                            } else {
                                $ret.= ' <li><a href="?'.$key.'='.$counter.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">'.$counter.'</a></li> ';
                            }
                        }
                        $ret.= ' <li class="disabled"><a href="javascript:void(0)">...</a></li> ';
                        $ret.= ' <li><a href="?'.$key.'='.$last_page.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">'.$last_page.'</a></li> ';
                        $ret.= ' <li><a href="?'.$key.'='.$totalposts.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">'.$totalposts.'</a></li> ';
                    } else {
                        $ret.= ' <li><a href="?'.$key.'=1'.$sorting.'" class="'.$link_class.'" data-keep-state="true">1</a></li> ';
                        $ret.= ' <li><a href="?'.$key.'=2'.$sorting.'" class="'.$link_class.'" data-keep-state="true">2</a></li> ';
                        $ret.= ' <li class="active"><a href="javascript:void(0)">...</a></li> ';
                        for ($counter = $totalposts - (2 + ($adjacents * 2)); $counter <= $totalposts; $counter++) {
                            if ($counter == $p) {
                                $ret.= ' <li class="active"><a href="javascript:void(0)">'.$counter.'</a></li> ';
                            } else {
                                $ret.= ' <li><a href="?'.$key.'='.$counter.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">'.$counter.'</a></li> ';
                            }
                        }
                    }
                }
                
                if ($p < $counter - 1) {
                    $ret.= ' <li><a href="?'.$key.'='.$next.''.$sorting.'" class="'.$link_class.'" data-keep-state="true">Next &raquo;</a></li> ';
                } else {
                    $ret.= ' <li class="disabled"><a href="javascript:void(0)">Next &raquo;</a></li> ';
                }
                
                $ret.= '</ul>';
            }
            return $ret;
        }

        /**
         * Calculates the great-circle distance between two points, with
         * the Haversine formula.
         *
         * Note: This formula is stable for calculating small distances regarding rounding errors.
         *
         * @param float $latitudeFrom Latitude of start point in [deg decimal]
         * @param float $longitudeFrom Longitude of start point in [deg decimal]
         * @param float $latitudeTo Latitude of target point in [deg decimal]
         * @param float $longitudeTo Longitude of target point in [deg decimal]
         * @param float $earthRadius Mean earth radius in [m]
         * @return float Distance between points in [m] (same as earthRadius)
         */
        public function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
        {
            // convert from degrees to radians
            $latFrom = deg2rad($latitudeFrom);
            $lonFrom = deg2rad($longitudeFrom);
            $latTo = deg2rad($latitudeTo);
            $lonTo = deg2rad($longitudeTo);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
            return $angle * $earthRadius;
        }

        /**
         * Calculates the great-circle distance between two points, with
         * the Vincenty formula.
         *
         * An alternative to the haversine formula is the vincenty formula, it is slightly more complex, but does not suffer from the weakness with antipodal points (rounding errors).
         *
         * @param float $latitudeFrom Latitude of start point in [deg decimal]
         * @param float $longitudeFrom Longitude of start point in [deg decimal]
         * @param float $latitudeTo Latitude of target point in [deg decimal]
         * @param float $longitudeTo Longitude of target point in [deg decimal]
         * @param float $earthRadius Mean earth radius in [m]
         * @return float Distance between points in [m] (same as earthRadius)
         */
        public function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
        {
            // convert from degrees to radians
            $latFrom = deg2rad($latitudeFrom);
            $lonFrom = deg2rad($longitudeFrom);
            $latTo = deg2rad($latitudeTo);
            $lonTo = deg2rad($longitudeTo);

            $lonDelta = $lonTo - $lonFrom;
            $a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
            $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

            $angle = atan2(sqrt($a), $b);
            return $angle * $earthRadius;
        }
    }

}
