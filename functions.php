<?php

function db_bind_array($stmt, &$row){
	$stmt->store_result();
	$md = $stmt->result_metadata();
	$params = array();
	while($field = $md->fetch_field())  $params[] = &$row[$field->name];
	return call_user_func_array(array($stmt, 'bind_result'), $params);
}

/*
* HAGO UNA COPIA DE UN ARRAY A OTRO
*
*/
function copyArray($from){
	$final = array();
	foreach ($from as $key => $value){
		$final[$key] = $value;
	}
	return $final;
}

function recurseCopy($src,$dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			if ( is_dir($src . '/' . $file) ) recurseCopy($src . '/' . $file,$dst . '/' . $file);
			else copy($src . '/' . $file,$dst . '/' . $file);
		}
	}
	closedir($dir);
}

/*
* OBTENGO EL VALOR DE UNA VARIABLE QUE SE PASA POR POST O GET.
* $k: Key a buscar dentro de POST o GET
* $def:  Valor que devuelve por defecto si no esta, Por defecto devuelve ''
*/

function getVar($k, $def = ''){
	if (isset($_POST[$k])) return $_POST[$k];
	else if (isset($_GET[$k])) return $_GET[$k];
	else return $def;
}

/*
* HACE UN UTF8_ENCODE DENTRO DE UN OBJETO
* */
function utf8_encode_deep(&$input) {
	if (is_string($input)) $input = utf8_encode($input);
	else if (is_array($input)) {
		foreach ($input as &$value) utf8_encode_deep($value);
		unset($value);
	} else if (is_object($input)) {
		$vars = array_keys(get_object_vars($input));
		foreach ($vars as $var) utf8_encode_deep($input->$var);
	}
}

function deleteDir($dirPath){
	if (is_dir($dirPath)) {
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') $dirPath .= '/';
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file))deleteDir($file);
			else unlink($file);
		}
		rmdir($dirPath);
	}
}

function getTotalRows($stmt2){
	$mysqli = ConnectionFactory::getFactory()->getConnection();
	$sql = $mysqli->prepare($stmt2);
	$sql->execute();
	$row = array(); db_bind_array($sql, $row); $sql->fetch();
	return $row["c"];
}

function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

/*
* ELIMINAR LOS CARACTERES ESPECIALES DE UN STRING
*/
function changeSpecialCharacters($string) {
	$string = trim($string);
	$string = str_replace(" ", "-", $string);;
	$string = str_replace(array('�', '�', '�', '�', '�', '�', '�', '�', '�'),array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),$string);
	$string = str_replace(array('�', '�', '�', '�', '�', '�', '�', '�'),array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),$string);
	$string = str_replace(array('�', '�', '�', '�', '�', '�', '�', '�'),array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),$string);
	$string = str_replace(array('�', '�', '�', '�', '�', '�', '�', '�'),array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),$string);
	$string = str_replace(array('�', '�', '�', '�', '�', '�', '�', '�'),array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),$string);
	$string = str_replace(array('�', '�', '�', '�'),array('n', 'N', 'c', 'C',),$string);
	$string = str_replace(array("\\", "�", "�","--", "~","#", "@", "|", "!", "\"","�", "$", "%", "&", "/","(", ")", "?", "'", "�","�", "[", "^", "`", "]",
	"+", "}", "{", "�", "�",">", "<", ";", ",", ":","."),'',$string);
	return strtolower($string);
}

function removerCaracteresEspeciales($string) {
	$string = trim($string);
	$string = str_replace(" ", "-", $string);;
	$string = str_replace(array('&aacute;', '&agrave;', '&auml;', '&acirc;', '&ordf;', '&Aacute;', '&Agrave;', '&Acirc;', '&Auml;'),array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),$string);
	$string = str_replace(array('&eacute;', '&egrave;', '&euml;', '&ecirc;', '&Eacute;', '&Egrave;', '&Ecirc;', '&Euml;'),array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),$string);
	$string = str_replace(array('&iacute;', '&igrave;', '&iuml;', '&icirc;', '&Igrave;', '&Iacute;', '&Iuml;', '&Icirc;'),array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),$string);
	$string = str_replace(array('&oacute;', '&ograve;', '&ouml;', '&ocirc;', '&Oacute;', '&Ograve;', '&Ouml;', '&Ocirc;'),array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),$string);
	$string = str_replace(array('&uacute;', '&ugrave;', '&uuml;', '&ucirc;', '&Uacute;', '&Ugrave;', '&Ucirc;', '&Uuml;'),array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),$string);
	$string = str_replace(array('&ntilde;', '&Ntilde;', '&ccedil;', '&Ccedil;'),array('n', 'N', 'c', 'C',),$string);
	$string = str_replace(array("\\", "&uml;", "&deg;","--", "~","#", "@", "|", "!", "\"","�", "$", "%", "&", "/","(", ")", "?", "'", "&iexcl;","&iquest;", "[", "^", "`", "]",
	"+", "}", "{", "&acute;",">", "<", ";", ",", ":","."),'',$string);
	return strtolower($string);
}

	/*
	* DEVUELVE LA URL ACTUAL
	*/
function curPageURL() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
	}

function returnEncryptedName($name,$title){
	$dotpos = strrpos($name, ".");
	if ($dotpos) $ext = strtolower(substr($name, $dotpos)); else $ext = "";
	return uniqid("") . substr(md5($title), 2, 12) . $ext;
}

function generateBrief($text,$lenght){
	$brief = $text;
	$brief = substr($brief, 0,$lenght);
	if (strlen($text) > $lenght) $brief .= "...";
	return $brief;
}

//USE: list($_POST,$_GET,$_COOKIE)
function stripPredefinedVariablesSlashes(){
	if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) ){
		$_POST = array_map( 'stripslashes', $_POST );
		$_GET = array_map( 'stripslashes', $_GET );
		$_COOKIE = array_map( 'stripslashes', $_COOKIE );
	}
	return array($_POST,$_GET,$_COOKIE);
}

		//////IMAGES
		//0: Widht; 1:Height
		function GetThumbnailSize($imgfilename, $maxw, $maxh){
			$origsize = @getimagesize($imgfilename);
			$newsize = array($origsize[0], $origsize[1]);
			if ($newsize[0] > $maxw){
				$newsize[0] = $maxw;
				$newsize[1] = round($origsize[1]/$origsize[0]*$maxw);
			}
			if ($newsize[1] > $maxh){
				$newsize[1] = $maxh;
				$newsize[0] = round($origsize[0]/$origsize[1]*$maxh);
			}
			return $newsize;
		}

		function resizeImage($file, $w, $h, $crop=FALSE) {
			list($width, $height) = getimagesize($file);
			$r = $width / $height;
			if ($crop) {
				if ($width > $height) {
					$width = ceil($width-($width*($r-$w/$h)));
				} else {
					$height = ceil($height-($height*($r-$w/$h)));
				}
				$newwidth = $w;
				$newheight = $h;
			} else {
				if ($w/$h > $r) {
					$newwidth = $h*$r;
					$newheight = $h;
				} else {
					$newheight = $w/$r;
					$newwidth = $w;
				}
			}
			$src = getImageFromFile($file);
			$dst = imagecreatetruecolor($newwidth, $newheight);
			imagesavealpha($dst, true);
			$trans_colour = imagecolorallocatealpha($dst, 0, 0, 0, 127);
			imagefill($dst, 0, 0, $trans_colour);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			return $dst;
		}

		function getImageFromFile($filename){
			$size=getimagesize($filename);
			switch($size["mime"]){
				case "image/jpeg":
				$img = ImageCreateFromJPEG($filename);
				break;
				case "image/gif":
					$img = imagecreatefromgif($filename);
					break;
					case "image/png":
					$img = imagecreatefrompng($filename);
					break;
					default:
					$img = FALSE;
					break;
				}
				return $img;
			}

			function saveImage($image,$path, $name){
				$size=getimagesize($path);
				switch($size["mime"]){
					case "image/jpeg":
					ImageJPEG($image , $name);
					break;
					case "image/gif":
						ImageGIF($image , $name);
						break;
						case "image/png":
						ImagePNG($image , $name);
						break;
					}
				}

				/*
				* DEVUELVE LA URL DE UNA IMAGEN Y EL TAMA�O OPTIMO. SI NO EXISTE PUEDE DEVOLVER UNA IAMGEN ALTERNATIVA
				* $imageName: Nombre de la imagen que se va a buscar en los directorios (variables de abajo)
				* $pathHtml: Directorio (HTML) en donde esta la imagen. EJ: IMAGES_PATH_HTML
				* $pathPhp: Directorio (HTML) en donde esta la imagen. EJ: IMAGES_PATH
				* $maxWidth: Maximo ancho de la imagen (no le den bola)
				* $maxHeight: Maximo alto de la iamgen (no le den bola)
				* $altHtml:En el caso de que no exista cual es la imagen que devuelve. Tienen que poner la url completa. Ej: IMAGES_PATH_HTML.'no-image.jpg'
				* $altPhp: En el caso de que no exista cual es la imagen que devuelve. Tienen que poner la url completa. Ej: IMAGES_PATH.'no-image.jpg'
				*/

				function returnThumbnailImage($imageName,$pathHtml,$pathPhp,$maxWidth,$maxHeight,$altHtml,$altPhp){
					$url = $imageName;
					if (isset($url) && $url != null && $url != "" && file_exists($pathPhp.$url)) {
						$url = $pathHtml.$url;
						$urlPhp = $pathPhp.$imageName;
					}else {
						$url = $altHtml;
						$urlPhp = $altPhp;
					}
					$size = GetThumbnailSize($urlPhp, $maxWidth, $maxHeight);
					return array($url, $size);
				}

				/*
				* GUARDA LA IMAGEN EN UN DIRECTORIO. SI NO EXISTE EL DIRECTORIO LO CREA. SI SE LE PASA LA VARIABLE $oldImage Y SI EXISTE ELIMINA LA IMAGEN
				* $path: Path donde va a subirse la imagen. Ej: IMAGES_PATH o IMAGES_PATH.'usuarios/'
				* $photo: Nombre que se le va a dar a la imagen. EJ: mi-imagen.jpg
				* $fileName: Name del input file con el que se subio la imagen
				* $oldImage: Nombre viejo de la imagen. Si existe la borra.
				*/

				function saveImageToPath($path,$photo,$fileName,$oldImage){
					$uploadsDir = $path;
					if (!is_dir($uploadsDir)) mkdir($uploadsDir,0777);
					move_uploaded_file($_FILES[$fileName]["tmp_name"], "$uploadsDir/$photo");
					if ($oldImage && file_exists($uploadsDir.$oldImage) && !is_dir($uploadsDir.$oldImage)) unlink($uploadsDir.$oldImage);
				}

				function saveOriginalImage($path,$photo,$fileName,$oldImage){
					$uploadsDir = $path.'original/';
					if (!is_dir($uploadsDir)) mkdir($uploadsDir,0777);
					move_uploaded_file($_FILES[$fileName]["tmp_name"], "$uploadsDir/$photo");
					if ($oldImage && file_exists($uploadsDir.$oldImage) && !is_dir($uploadsDir.$oldImage)) unlink($uploadsDir.$oldImage);
				}

				function resizeAndSaveImage($path,$photo,$oldImage,$maxWidth,$maxHeight){
					$uploadsDirThumb = $path.'thumb/';
					$uploadsDir = $path.'original/';
					if (!is_dir($uploadsDirThumb)) mkdir($uploadsDirThumb,0777);
					$image = resizeImage("$uploadsDir/$photo", $maxWidth, $maxHeight);
					saveImage($image , "$uploadsDir/$photo", "$uploadsDirThumb/$photo");
					if ($oldImage && file_exists($uploadsDirThumb.$oldImage) && !is_dir($uploadsDirThumb.$oldImage)) unlink($uploadsDirThumb.$oldImage);
				}

				function is_image($path){
					$a = getimagesize($path);
					$image_type = $a[2];
					if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))){
						return true;
					}
					return false;
				}
				//////END IMAGES

				function convertMysqlDateToTimezone($format,$date){
					$phpdate = strtotime( $date );
					$diff = USER_TIMEZONE + (DATABASE_TIMEZONE * -1);
					return date( $format, strtotime($diff.' hours', $phpdate) );
				}

				/*
				* CONVIERTE UNA FECHA EN FORMAT MYSQL A OTRO FORMATO. Formato: https://www.php.net/manual/es/function.date.php
				* $format: Formato al que la queremos convertir. EJ: l jS \of F Y h:i:s A.
				* $date: Fecha en formato MYSQL (siempre las guardamos asi en la base de datos)
				*/
				function convertMysqlDateTo($format,$date){
					$phpdate = strtotime( $date );
					$j = getMonthName(date('F', $phpdate));
					$l = getDayName(date('l', $phpdate));
					$ff = date( $format, $phpdate);
					$ff = str_ireplace(array(date('F', $phpdate), date('l', $phpdate)), array($j, $l), $ff);
					return $ff;
				}

				function getDayName($d){
					$dias = array('Monday' => 'Lunes', 'Tuesday' =>'Martes', 'Wednesday' =>'Mi&eacute;rcoles', 'Thursday' =>'Jueves', 'Friday' =>'Viernes', 'Saturday' =>'S&aacute;bado', 'Sunday' => 'Domingo');
					return $dias[$d];
				}

				function getMonthName($n){
					$months = array('January' => "Enero", 'February' =>"Febrero" ,'March' => "Marzo", 'April' => "Abril", 'May' => "Mayo", 'June' => "Junio", 'July' => "julio",
					'August' => "Agosto", 'September' => "Septiembre", 'October' => "Octubre", 'November' => "Noviembre", 'December' => "Diciembre");
					return $months[$n];
				}

				/////////////////////////////////// ADMIN ////////////////////////////////////////
				function showAdminPagination($rows,$totalRows,$pageName, $page, $lang){
					$totalItems = 1000;
					$itemsPerPage = 50;
					$currentPage = 8;
					$pageName = $pageName.'page=(:num)';
					$paginator = new Paginator($totalRows, $rows, $page, $pageName);
					$paginator->setNextText(showLang($lang, 'NEXT'));
					$paginator->setPreviousText(showLang($lang, 'PREVIOUS'));
					return $paginator;
				}

				function showYesNo($selected,$lang,$name){
					$select = '<select name="'.$name.'" class="form-control">';
					$select .= '<option value="0"'; if ('0' == $selected) $select .= ' selected="selected" ';$select .= '>'.$lang['NO'].'</option>';
					$select .= '<option value="1"'; if ('1' == $selected) $select .= ' selected="selected" ';$select .= '>'.$lang['YES'].'</option>';
					$select .= '</select>';
					return $select;
				}

				function rowsPerPageSelect($selected){
					$select = '<select class="rowsPerPage form-control">';
					$select .= '<option value="10"'; if ('10' == $selected) $select .= ' selected="selected" ';$select .= '>10</option>';
					$select .= '<option value="20"'; if ('20' == $selected) $select .= ' selected="selected" ';$select .= '>20</option>';
					$select .= '<option value="50"'; if ('50' == $selected) $select .= ' selected="selected" ';$select .= '>50</option>';
					$select .= '<option value="100"'; if ('100' == $selected) $select .= ' selected="selected" ';$select .= '>100</option>';
					$select .= '</select>';
					return $select;
				}

				function returnOrderBy($className,$orderBy, $default){
					$vars = get_class_vars($className);
					$orders = explode(' ', $orderBy);
					if (count($orders) <= 2){
						if (isset($orders[1])){if ($orders[1] != 'desc' && $orders[1] != 'asc') return $default;}
						$found = false;
						foreach ($vars as $name => $val) {if ($name == $orders[0]) $found = true;}
						if ($found) return $orderBy;
						else return $default;
					}else return $default;
				}

				function setAdminCookieValue($index,$value){
					$data = isset($_COOKIE['admin_settings']) ? unserialize($_COOKIE['admin_settings']) : array();
					$data[$index] = $value;
					setcookie('admin_settings', serialize($data), time()+3600*24*100, '/');
				}

				function getAdminCookieValue($index){
					$data = isset($_COOKIE['admin_settings']) ? unserialize($_COOKIE['admin_settings']) : array();
					return isset($data[$index]) ? $data[$index] : null;
				}

				function changeHeaderVariablesAdmin($keyword, $desc, $title, $metaTags){
					$output = ob_get_contents();
					var_dump($output);
					$keyword = $metaTags['keywords'] . $keyword;
					$desc = $metaTags['description'] . $desc;
					$keys = str_replace(" ",",", $keyword);
					$keywords = '<meta name="keywords" content="'.$keys.'" />';
					$description = '<meta name="description" content="'.$desc.'" />';
					$dump = str_replace(
						array('<!--  ##META_TAGS## -->','<!--  ##TITLE## -->'),
						array($keywords.$description,$title),
						$output);
						ob_end_clean();
						ob_start();
						echo($dump);
						ob_end_flush();
					}

					function updateMetaTags($desc, $key, $author) {
						$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
						if (getMetaTags() != null)
						$sql = $mysqli->prepare("update meta_tag set description = ?, keywords = ?, author = ?");
						else
						$sql = $mysqli->prepare("insert into meta_tag(meta_tag_id, description,keywords,author) values (1,?,?,?)");
						$sql->bind_param("sss", $desc,$key,$author);
						$sql->execute();
						$sql->close();
						$mysqli->close();
					}

					/*
					* SIRVE PARA MOSTRAR EL TEXTO DE LAS VARIABLES DE LENGUAJE.
					* $lang: Array con todas las variables
					* $index: Indice que estamos buscando en el array
					*/
					function showLang($lang, $index){
						return isset($lang[$index]) ? utf8_encode($lang[$index]) : $index;
					}

					/////////////////////////////////// FRONT ////////////////////////////////////////
					function getFrontLanguage(){
						$l = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : FRONT_LANGUAGE;
						if (file_exists(LANG_PATH.$l.'.inc')){
							$path = LANG_PATH.$l.'.inc';
							define( "LANGUAGE", $l );
						}else {
							$path = LANG_PATH.FRONT_LANGUAGE.'.inc';
							define( "LANGUAGE", FRONT_LANGUAGE );
						}
						return array($path,$l);
					}

					function getMetaTags() {
						$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
						$sql = $mysqli->prepare("SELECT * FROM meta_tag limit 1");
						$sql->execute();
						$row = array(); db_bind_array($sql, $row); $sql->fetch();
						$sql->close();
						$mysqli->close();
						if ( $row["description"] != "" ) return $row;
					}

					function isUserLogued(){if (isset($_COOKIE['user_id'])){return Customer::getSession();}else return false;}

					function setFrontCookieValue($index,$value){
						$data = isset($_COOKIE['front_settings']) ? unserialize($_COOKIE['front_settings']) : array();
						$data[$index] = $value;
						setcookie('front_settings', serialize($data), time()+3600*24*100, '/');
					}

					function getFrontCookieValue($index){
						$data = isset($_COOKIE['front_settings']) ? unserialize($_COOKIE['front_settings']) : array();
						return isset($data[$index]) ? $data[$index] : null;
					}

					function checkSSL(){
						if (USE_SSL){
							if ($_SERVER['HTTPS'] != "on") {
								$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
								header("Location: $url");
								exit;
							}
						}
					}

					function diffDays($date_i,$date_f){
						$days = (strtotime($date_i)-strtotime($date_f))/86400;
						$days = abs($days);
						$days = floor($days);
						return $days;
					}

					function showLangFront($lang, $index){
						return isset($lang[$index]) ? $lang[$index] : $index;
					}

					////////////////////////////////////////// VALIDATIONS //////////////////////////////////////////
					function validateEmail($email){
						return preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email );
					}

					function validatePrice($price){
						return (preg_match('#^\d+(\.(\d+))?$#', $price));
					}

					////////////////////////////////////////// END VALIDATIONS ///////////////////////////////////////
					function getYoutubeId($url){
						parse_str(parse_url( $url, PHP_URL_QUERY), $vars );
						return isset($vars['v']) && $vars['v'] != '' ? $vars['v'] : null;
					}

					function getVimeoId($url){
						$videoId = substr(parse_url($url, PHP_URL_PATH), 1);
						return $videoId && $videoId != '' && strstr($url, 'https://vimeo.com') ? $videoId : null;
					}

					function getVideoUrl($url){
						$youtube = getYoutubeId($url);
						if ($youtube) return 'http://www.youtube.com/embed/'.$youtube.'?autoplay=0';
							else {
								$vimeo = getVimeoId($url);
								if ($vimeo) return 'https://player.vimeo.com/video/'.$vimeo;
								}
							}

							function getVideoImage($url){
								$youtube = getYoutubeId($url);
								if ($youtube) return 'http://img.youtube.com/vi/'.$youtube.'/0.jpg';
									else {
										$vimeo = getVimeoId($url);
										if ($vimeo) {
											$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vimeo.php"));
											return $hash[0]['thumbnail_medium'];
										}
									}
								}

								/*
								* ENVIO DE MAILS. LA CONFIGURACION ESTA EN EL ADMIN/VARIABLES.PHP
								* $to: Array de destinatarios separados por ,
								* $subject: Asunto del mail
								* $content: Contenido del mail
								* $archivos = array(): Array con los archivos que se van a adjuntar
								*/
								function sendEmail($to, $subject, $content, $archivos = array()){
									$mail = new PHPMailer();
									$mail->From = NO_REPLY_EMAIL;
									$mail->FromName = NO_REPLY_NAME;
									$tos = explode(',', $to);
									foreach ($tos as $to) $mail->AddAddress($to);
									$mail->IsHTML(true);
									$mail->Subject = $subject;
									$mail->Body = $content;
									foreach ($archivos as $nombre => $archivo){
										if (file_exists($factura)) $mail->addStringAttachment(file_get_contents($archivo),$nombre);
									}

									if (SMAIL_SMTP){
										$mail->IsSMTP();
										$mail->Host = SMAIL_HOST;
										$mail->Port = SMAIL_PORT;
										$mail->SMTPAuth = SMAIL_AUTH ? true : false;
										if ($mail->SMTPAuth){
											$mail->Username = SMAIL_USERNAME;
											$mail->Password = SMAIL_PASSWORD;
										}
										$mail->SMTPDebug = SMAIL_DEBUG;
									}
									$mail->Send();
								}
								?>
