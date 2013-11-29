<?php
class Allocine
{
    private $_api_url = 'http://www.allocine.fr';
    private $_user_agent = 'Dalvik/1.6.0 (Linux; U; Android 4.2.2; Nexus 4 Build/JDQ39E)';


     private function _do_request($method, $params)
    {
		$inter = '';
		$ext = '.html';
		if($method=="recherche"){
			$inter = '?';
			$ext = '';
		}
        // build the URL
        $query_url = $this->_api_url.'/'.$method;
        // new algo to build the query
        
        $query_url .= '/'.$inter.http_build_query($params).$ext;

		$parametres=array('Referer'=>'', 'Proxy'=>'', 'BrowserName'=>'Mozilla/4.0 (compatible; MSIE 6.0;Windows NT 5.0)');
		$params='';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $query_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->_user_agent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $html = curl_exec($ch);
        curl_close($ch);
		/*
		echo $response;
		if ($parametres['Referer']!="") $params.='-e '.$parametres['Referer'];
		if ($parametres['Proxy']!="") $params.='-x '.$parametres['Proxy'];
		if ($parametres['BrowserName']!="") $params.='-A "'.$parametres['BrowserName'].'"';
		$html = (`curl $params $query_url`);
		echo $html;
		*/
		
        return $html;
    } 

    public function search($query)
    {
        // build the params
        $params = array(
            'q' => $query,
        );
        // do the request
        $sortie_html = $this->_do_request('recherche', $params);

		//$movie est un string, on veut le transformer en array
		$response = $this->infos_recherche($sortie_html);
		
        return $response;
    }

    public function get_movie($id)
    {
        // build the params
        // $params = array(
            // 'fichefilm_gen_cfilm' => $id,
        // );

        // do the request
        // $sortie_html = $this->_do_request('film', $params);
		

		// $movie est un string, on veut le transformer en array
		// $response = $this->infos_film($sortie_html);

 
		$movie_temp = $this->json('movie',$id);

		$response = str_replace('"$"', '"value"', $movie_temp);
		
		$movie_object = json_decode($response, false);
		$movie = $movie_object->movie;
		
		
        return $movie;
    }

    public function get_person($id, $profile)
    {
        // build the params
        // $params = array(
            // 'partner' => $this->_partner_key,
            // 'code' => $id,
            // 'profile' => $profile,
            // 'filter' => 'person',
            // 'striptags' => 'synopsis,synopsisshort',
            // 'format' => 'json',
        // );

        // do the request
        // $response_encode = $this->_do_request('person', $params);
		$response_encode =$this->json('person',$id);
		
		$response_encode = str_replace('"$"', '"value"', $response_encode);
		//$person est un string, on veut le transformer en array
		$response_decode = json_decode($response_encode);
		$response = $response_decode->person;
			
        return $response;
    }
	

    public function infos_recherche($html)
    {
		$tab = Array();
		$pos1 = strpos($html, "dans les titres de films");
		if (!($pos1===FALSE)) {
			$pos2 = strpos($html,"</table>",$pos1);
			if (!($pos2===FALSE)) {
				// il existe ou moins un résultat
				$data_brut = substr($html,$pos1,$pos2-$pos1);
				$pos_ligne_video_1 = strpos($data_brut, "<tr><td");
				$pos_ligne_video_2 = strpos($data_brut, "</td></tr>",$pos_ligne_video_1);
				$nb_reponses=1;
				while ($pos_ligne_video_1 && $pos_ligne_video_2) {
					$tab[$nb_reponses] = Array();;
					$ligne_tot=substr($data_brut,$pos_ligne_video_1,$pos_ligne_video_2-$pos_ligne_video_1);
					
					$text = trim(strip_tags($ligne_tot));
					if ($text!='Plus...') {	
						$pos_ligne_1 = strpos($data_brut, "<tr><td",$pos_ligne_video_1);
						$pos_ligne_2 = strpos($data_brut, "</td><td",$pos_ligne_1);
						if ($pos_ligne_1 && $pos_ligne_2) {
							// le titre
							$url_img = '';
							$ligne=substr($data_brut,$pos_ligne_1,$pos_ligne_2-$pos_ligne_1);
							
							$text = trim(strip_tags($ligne));
							$pos_img_1 = strpos($ligne, "<img");
							$pos_img_1+=strlen("<img src='");
							$pos_img_2 = strpos($ligne, "'", $pos_img_1);
							if ($pos_img_1 && $pos_img_2) {
								//$pos_img_1+=strlen("<img src='");
								if ($ligne[$pos_img_1]=='/') $pos_img_1++; 
								$url_img = substr($ligne,$pos_img_1,$pos_img_2 - $pos_img_1);
								// on affiche le titre et on pré-coche le premier bouton radio
								// l'utilisateur pourra cliquer sur le titre et ouvrir une nouvelle 
								// fenêtre avec la fiche du film
							}
							
							// url associée
							// $pos_url_1 : position du 1er guillemet de A HREF
							// $pos_url_2 : position du 2eme guillemet de A HREF
							$pos_url_1 = strpos($ligne, "<a href='");
							$pos_url_2 = strpos($ligne, "'>", $pos_url_1);
							//echo $ligne;
							if ($pos_url_1 && $pos_url_2) {
								$pos_url_1+=strlen("<a href='");
								if ($ligne[$pos_url_1]=='/') $pos_url_1++; 
								$url = substr($ligne,$pos_url_1,$pos_url_2 - $pos_url_1);
								$pos_code_1 = strpos($url, "fichefilm_gen_cfilm=");
								$pos_code_2 = strpos($url, ".html", $pos_code_1);
								if ($pos_code_1 && $pos_code_2) {
									$pos_code_1+=strlen("fichefilm_gen_cfilm=");
									$code = substr($url,$pos_code_1,$pos_code_2 - $pos_code_1);
									// on affiche le titre et on pré-coche le premier bouton radio
									// l'utilisateur pourra cliquer sur le titre et ouvrir une nouvelle 
									// fenêtre avec la fiche du film
									$tab[$nb_reponses]['code'] = $code;
									$tab[$nb_reponses]['url_img'] = $url_img;
								}
							}
						}
						
						$pos_ligne_1 = $pos_ligne_2;
						$pos_ligne_2 = strpos($data_brut, "</td></tr>",$pos_ligne_1);
						if ($pos_ligne_1 && $pos_ligne_2) {
							// le titre
							$url_img = '';
							$ligne=substr($data_brut,$pos_ligne_1,$pos_ligne_2-$pos_ligne_1);
							
							$pos_titre_1 = strpos($ligne, "<a href='");
							$pos_titre_2 = strpos($ligne, "'>", $pos_titre_1);
							//echo $ligne;
							if ($pos_titre_1 && $pos_titre_2) { 
								$pos_titre_1 = $pos_titre_2+strlen("'>");
								$pos_titre_2 = strpos($ligne, "</a>", $pos_titre_1);
								$titre = substr($ligne,$pos_titre_1,$pos_titre_2 - $pos_titre_1);
								$pos_infos_1 = strpos($ligne, '<span class="fs11">', $pos_titre_2);
								$pos_infos_2 = strpos($ligne, "</span>", $pos_infos_1);
								if ($pos_infos_1 && $pos_infos_2) {
									$pos_infos_1+=strlen('<span class="fs11">');
									$infos = substr($ligne,$pos_infos_1,$pos_infos_2 - $pos_infos_1);
									
									$pos_annee_2 = strpos($infos, "<br />");
									$pos_annee_1 = 1;
									$annee = '';
									if ($pos_annee_2) {
										$annee = substr($infos,$pos_annee_1,$pos_annee_2 - $pos_annee_1);
										
									}
									
									$pos_real_1 = strpos($infos, "de ", $pos_annee_2);
									if(!$pos_real_1){
										$pos_real_1 = $pos_annee_2 + strlen("<br />");
										$pos_real_2 = strpos($infos, "<br />", $pos_real_1);
										$realisateur = '';
									}else{
										$pos_real_1 = $pos_real_1 + strlen("de ");
										$pos_real_2 = strpos($infos, "<br />", $pos_real_1);
										$realisateur = '';
										if ($pos_real_1 && $pos_real_2) {
											$realisateur = substr($infos,$pos_real_1,$pos_real_2 - $pos_real_1);
										}
									}
									
									$pos_act_1 = strpos($infos, "avec ", $pos_real_2);
									if(!$pos_act_1){
										$pos_act_1 = $pos_real_2 + strlen("<br />");
										$pos_act_2 = strpos($infos, "<br />", $pos_act_1);
										//$acteurs = Array();
										$liste_acteurs = '';
									}else{
										$pos_act_1 = $pos_act_1 + strlen("avec ");
										$pos_act_2 = strpos($infos, "<br />", $pos_act_1);
										$acteurs = Array();
										if ($pos_act_1 && $pos_act_2) {
											$liste_acteurs = substr($infos,$pos_act_1,$pos_act_2 - $pos_act_1);
											
											//$acteurs = explode(",",$liste_acteurs);
										}
									}
									// on affiche le titre et on pré-coche le premier bouton radio
									// l'utilisateur pourra cliquer sur le titre et ouvrir une nouvelle 
									// fenêtre avec la fiche du film
									$tab[$nb_reponses]['titre'] = trim(strip_tags($titre));
									$tab[$nb_reponses]['annee'] = $annee;
									$tab[$nb_reponses]['realisateur'] = $realisateur;
									$tab[$nb_reponses]['acteurs'] = $liste_acteurs;
								}
							}
						}
						
					
					}
					$nb_reponses++;
					$pos_ligne_video_1 = strpos($data_brut, "<tr><td",$pos_ligne_video_2);
					$pos_ligne_video_2 = strpos($data_brut, "</td></tr>",$pos_ligne_video_1);
				}
			}
		}
        return $tab;
    }
	
	
    public function infos_film($html)
    {
		$tab = Array();
		//Titre
		$tab['titre'] = '';
		$pos1 = strpos($html, '<div id="title"');
		$pos2 = strpos($html,"</div>",$pos1);
		if (!($pos1===FALSE) && !($pos2===FALSE)) {
			$data_brut = substr($html,$pos1,$pos2-$pos1);
			$pos_titre1 = strpos($data_brut, '<span');
			$pos_titre2 = strpos($data_brut,"</span>",$pos_titre1);
			if (!($pos1===FALSE) && !($pos2===FALSE)) {
				$titre=substr($data_brut,$pos_titre1,$pos_titre2-$pos_titre1);
				$tab['titre'] = trim(strip_tags($titre));
			}
		}
		
		//Genres et Annee sortie et Duree
		$tab['genre'] = Array();
		$tab['annee'] = '';
		$tab['duree'] = '';
		$pos1 = strpos($html, '<ul class="list_item_p2v">', $pos2);
		$pos2 = strpos($html,"</ul>",$pos1);
		if (!($pos1===FALSE) && !($pos2===FALSE)) {
			$data_brut = substr($html,$pos1,$pos2-$pos1);
			//Annee sortie
			$pos_annee1 = strpos($data_brut, '<span itemprop="datePublished" content="');
			$pos_annee2 = strpos($data_brut,'">',$pos_annee1);
			if (!($pos_annee1===FALSE) && !($pos_annee2===FALSE)) {
				$pos_annee1 = $pos_annee1+strlen('<span itemprop="datePublished" content="');
				$annee=substr($data_brut,$pos_annee1,$pos_annee2-$pos_annee1);
				$regs=Array();
				if (preg_match ("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $annee, $regs)) {
					$tab['annee'] = trim(strip_tags($regs[1]));
				}
			}
			//Duree
			$pos_duree1 = strpos($data_brut, '<span itemprop="duration"');
			$pos_duree2 = strpos($data_brut,'</span>',$pos_duree1);
			if (!($pos_duree1===FALSE) && !($pos_duree2===FALSE)) {
				$duree=substr($data_brut,$pos_duree1,$pos_duree2-$pos_duree1);
				$regs=Array();
				if (preg_match ("/([0-9]{1})h ([0-9]{1,2})min/", $duree, $regs)) {
					$tab['duree'] = (trim(strip_tags($regs[1]))*60)+trim(strip_tags($regs[2]));
				}
			}
			//Genre
			$pos_genre1 = strpos($data_brut, '<span itemprop="genre">');
			$pos_genre2 = strpos($data_brut,"</span>",$pos_genre1);
			while ($pos_genre1 && $pos_genre2) {
				$pos_genre1 = $pos_genre1+strlen('<span itemprop="genre">');
				$genre=substr($data_brut,$pos_genre1,$pos_genre2-$pos_genre1);
				$tab['genre'][] = trim(strip_tags($genre));
				
				$pos_genre1 = strpos($data_brut, '<span itemprop="genre">',$pos_genre2);
				$pos_genre2 = strpos($data_brut, "</span>",$pos_genre1);
			}
		}
		
		//Resume et Avertissement
		$tab['resume'] = '';
		$pos1 = strpos($html, '<h2 id="synopsys_details"', $pos2);
		$pos2 = strpos($html,"</p>",$pos1);
		if (!($pos1===FALSE) && !($pos2===FALSE)) {
			$data_brut = substr($html,$pos1,$pos2-$pos1)."</p>";
			//Resume
			$pos_resume1 = strpos($data_brut, '<p itemprop="description">');
			$pos_resume2 = strpos($data_brut,"</p>",$pos_resume1);
			if (!($pos_resume1===FALSE) && !($pos_resume2===FALSE)) {
				$pos_resume1 = $pos_resume1+strlen('<p itemprop="description">');
				$resume=substr($data_brut,$pos_resume1,$pos_resume2-$pos_resume1);
				$tab['resume'] = trim(strip_tags($resume));
			}
			//Avertissement
			$pos_avert1 = strpos($data_brut, '<span class="insist">');
			$pos_avert2 = strpos($data_brut,"</span>",$pos_avert1);
			if (!($pos_avert1===FALSE) && !($pos_avert2===FALSE)) {
				$pos_avert1 = $pos_avert1+strlen('<span class="insist">');
				$avertissement=substr($data_brut,$pos_avert1,$pos_avert2-$pos_avert1);
				$tab['avertissement'] = trim(strip_tags($avertissement));
			}
		}
		
		//TitreOriginal
		$tab['titre_original'] = '';
		$pos1 = strpos($html, '<table', $pos2);
		$pos2 = strpos($html,"</table>",$pos1);
		if (!($pos1===FALSE) && !($pos2===FALSE)) {
			$data_brut = substr($html,$pos1,$pos2-$pos1);
			$pos_titreo1 = strpos($data_brut, 'Titre original');
			$pos_titreo2 = strpos($data_brut,"</td>",$pos_titreo1);
			if (!($pos_titreo1===FALSE) && !($pos_titreo2===FALSE)) {
				$pos_titreo1 = $pos_titreo1+strlen('Titre original');
				$titreOriginal=substr($data_brut,$pos_titreo1,$pos_titreo2-$pos_titreo1);
				$tab['titre_original'] = trim(strip_tags($titreOriginal));
			}
		}
		
		
		echo 'Titre: '.$tab['titre']."<br/>";
		echo 'Annee: '.$tab['annee']."<br/>";
		echo 'Duree: '.$tab['duree']."<br/>";
		echo 'Genre: '; print_r($tab['genre']); echo "<br/>";
		echo 'Avertissement: '.$tab['avertissement']."<br/>";
		echo 'Resume: '.$tab['resume']."<br/>";
		echo 'TitreOriginal: '.$tab['titre_original']."<br/>";
		
        return $tab;
    }
	
	function json($type, $data)
    {
		$nb_min = 10;
		$nb_max = 99;
		$nombre_aleatoire = mt_rand($nb_min,$nb_max);
		 
		 
			if( ($type == 'search') )
				{  
		echo 'search'; 
					if(!empty($_GET['page']))
						{
					$page = $_GET['page'];
						}
					else
						{
					$page = 1;
						}
		$data = str_replace(array('+'), ' ', $data);
				$parametres = array(
					'partner' => '100043982026',
					'filter' => 'movie,tvseries,theater,person,news',
					'count' => '25',
					'page' => $page,
					'q' => $data,
					'format' => 'json');
		//-------------
		// krumo($parametres);
		$url = 'http://api.allocine.fr/rest/v3/'.$type;
		$secret = '29d185d98c984a359e6e6f26a0474269';
		$USERAGENT = 'Dalvik/1.6.0 (Linux; U; Android 4.0.3; SGH-T989 Build/IML'.$nombre_aleatoire.'K)';
		 
				$sed = date('Ymd');
				$sig = urlencode(base64_encode(sha1($secret .http_build_query($parametres). '&sed=' .$sed, true)));
				$url .= '?' .http_build_query($parametres). '&sed=' .$sed. '&sig=' .$sig;
				// echo $url .= '?' .http_build_query($parametres). '&sed=' .$sed. '&sig=' .$sig;
				  
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_USERAGENT, $USERAGENT);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
				$informations = curl_exec($ch);
				curl_close($ch);
				 
				return $informations;
		//-------------
				}
			elseif(($type == 'movie') OR ($type == 'person') OR ($type == 'tvseries') OR ($type == 'season') OR ($type == 'episode') OR ($type == 'news') OR ($type == 'newslist') )
				{
					if($type == 'movie')
						{
		$data =  $data;
				$parametres = array(
					'partner' => '100043982026',
					'code' => $data,
					'profile' => 'large',
					'filter' => 'movie',
					'striptags' => 'synopsis,synopsisshort,trivia,person,news,tvseries',
					'format' => 'json');
						}
					elseif($type == 'person')
						{
		$data =  $data;
				$parametres = array(
					'partner' => '100043982026',
					'code' => $data,
					'profile' => 'large',
					'filter' => 'movie',
					'striptags' => 'synopsis,synopsisshort,trivia,person,news,tvseries',
					'format' => 'json');        
						}  
					elseif($type == 'tvseries')
						{
		$data =  $data;
				$parametres = array(
					'partner' => '100043982026',
					'code' => $data,
					'profile' => 'large',
					'filter' => 'movie,tvseries',
					'format' => 'json');        
						}  
					elseif($type == 'season')
						{
		$data =  $data;
				$parametres = array(
					'partner' => '100043982026',
					'code' => $data,
					'profile' => 'large',
					'striptags' => 'synopsis,synopsisshort',
					'format' => 'json');        
						}      
					elseif($type == 'episode')
						{
		$data =  $data;
				$parametres = array(
					'partner' => '100043982026',
					'code' => $data,
					'profile' => 'large',
					'striptags' => 'synopsis,synopsisshort',
					'format' => 'json');        
						}      
					elseif($type == 'news')
						{
		$data =  $data;
				$parametres = array(
					'partner' => '100043982026',
					'code' => $data,
					'profile' => 'large',
					'striptags' => 'synopsis,synopsisshort',
					'format' => 'json');        
						}          
					elseif($type == 'newslist')
						{
		$data =  $data;
							if(!empty($_GET['page']))
								{
							$page = $_GET['page'];
								}
							else
								{
							$page = 1;
								}
								 
							if( (@$_GET['newsparpage'] == 5) OR (@$_GET['newsparpage'] == 25))
								{
							$newsparpage = $_GET['newsparpage'];
								}
							else
								{
							$newsparpage = 25;
								}
				$parametres = array(
					'partner' => '100043982026',
					'count' => $newsparpage,
					'page' => $page,
					'filter' => $data,
					'format' => 'json');        
						}  
					else
						{
						}
		 
		//-------------
		// krumo($parametres);
		$url = 'http://api.allocine.fr/rest/v3/'.$type;
		$secret = '29d185d98c984a359e6e6f26a0474269';
		$USERAGENT = 'Dalvik/1.6.0 (Linux; U; Android 4.0.3; SGH-T989 Build/IML'.$nombre_aleatoire.'K)';
		 
				$sed = date('Ymd');
				$sig = urlencode(base64_encode(sha1($secret .http_build_query($parametres). '&sed=' .$sed, true)));
				$url .= '?' .http_build_query($parametres). '&sed=' .$sed. '&sig=' .$sig;
				// echo $url .= '?' .http_build_query($parametres). '&sed=' .$sed. '&sig=' .$sig;
				  
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_USERAGENT, $USERAGENT);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
				$informations = curl_exec($ch);
				curl_close($ch);
				 
				return $informations;
		//-------------
		 
				}
			else
				{
		echo $informations = 'Erreur: les accès a l\'api ce font avec ces mots clé: search, movie, person, tvseries, season';
		 
		global $resultat;
		$resultat = 2;
		return $informations;
        }
// filter: movie,theater,person,news,tvseries,theater,person,news,tvseries
    }
	
	
}
/*
class Allocine
{
    private $_api_url = 'http://api.allocine.fr/rest/v3';
    private $_partner_key;
    private $_secret_key;
    private $_user_agent = 'Dalvik/1.6.0 (Linux; U; Android 4.2.2; Nexus 4 Build/JDQ39E)';

    public function __construct($partner_key, $secret_key)
    {
        $this->_partner_key = $partner_key;
        $this->_secret_key = $secret_key;
    }

    private function _do_request($method, $params)
    {
        // build the URL
        $query_url = $this->_api_url.'/'.$method;

        // new algo to build the query
        $sed = date('Ymd');
        $sig = urlencode(base64_encode(sha1($this->_secret_key.http_build_query($params).'&sed='.$sed, true)));
        $query_url .= '?'.http_build_query($params).'&sed='.$sed.'&sig='.$sig;

        // do the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $query_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->_user_agent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function search($query)
    {
        // build the params
        $params = array(
            'partner' => $this->_partner_key,
            'q' => $query,
            'format' => 'json',
            'filter' => 'movie'
        );

        // do the request
        $response_encode = $this->_do_request('search', $params);

		//$movie est un string, on veut le transformer en array
		$response_decode = json_decode($response_encode);
		
		$response = $response_decode->feed->movie;
		
        return $response;
    }

    public function get_movie($id, $profile)
    {
        // build the params
        $params = array(
            'partner' => $this->_partner_key,
            'code' => $id,
            'profile' => $profile,
            'filter' => 'movie',
            'striptags' => 'synopsis,synopsisshort',
            'format' => 'json',
        );

        // do the request
        $response_encode = $this->_do_request('movie', $params);

		$response_encode = str_replace('"$"', '"value"', $response_encode);
		//$movie est un string, on veut le transformer en array
		$response_decode = json_decode($response_encode);
		$response = $response_decode->movie;
			
        return $response;
    }

    public function get_person($id, $profile)
    {
        // build the params
        $params = array(
            'partner' => $this->_partner_key,
            'code' => $id,
            'profile' => $profile,
            'filter' => 'person',
            'striptags' => 'synopsis,synopsisshort',
            'format' => 'json',
        );

        // do the request
        $response_encode = $this->_do_request('person', $params);

		$response_encode = str_replace('"$"', '"value"', $response_encode);
		//$person est un string, on veut le transformer en array
		$response_decode = json_decode($response_encode);
		$response = $response_decode->person;
			
        return $response;
    }
}
*/



