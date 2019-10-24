<?php

class API{
	protected $apiKey = 'cb6e8442bc390cb55c37de5073e3011f';
	protected $apiYoutube = 'https://www.youtube.com/watch?v=';
	protected $apiLanguage = '&language=pt-BR';
	protected $noPoster = '../res/imgs/no-poster.png';
	protected $noBackdrop = '../res/imgs/no-backdrop.png';
	protected $noBackdropSlide = '../res/imgs/no-backdrop-slide.png';

	public function getNoBackdropSlide()
	{
	    return $this->noBackdropSlide;
	}
	public function getNoBackdrop()
	{
	    return $this->noBackdrop;
	}
	public function getNoPoster()
	{
	    return $this->noPoster;
	}

	public function getKey(){
		return $this->apiKey;
	}
	
	public function setKey($apiKey){
		$this->apiKey = $apiKey;
	}

	public function getLanguage(){
		return $this->apiLanguage;
	}
	
	public function setLanguage($apiLanguage){
		$this->apiLanguage = $apiLanguage;
	}

	public function getApiYoutube(){
		return $this->apiYoutube;
	}
	
	public function setApiYoutube($apiYoutube){
		$this->apiYoutube = $apiYoutube;
	}
	
	public function getCategorias(){
		
		$url = 'https://api.themoviedb.org/3/genre/movie/list?api_key=' . $this->getKey() . $this->getLanguage();
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		return $json_data['genres'];
	}

	public function getPopulares($page){
		
		$url = "https://api.themoviedb.org/3/movie/popular?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$totalPages = $json_data['total_pages'];



		foreach($json_data['results'] as $index=>$filme)
		{	
			$overview = addslashes(htmlspecialchars(empty($filme['overview']) ? "Sinopse não disponível em Português(Brasil)" : $filme['overview']));
			$title = htmlspecialchars($filme['title']);
			$poster = empty($filme['poster_path']) ? $this->getNoPoster() : $this->getApiImg($filme['poster_path'], 500);

			echo '<a href="../filme/detalhe.php?id='.$filme['id'].'">
		        		<div class="item rounded img-fluid" data-w="200" data-h="300">
		                	<center>
		                		<div id="loader-'.$index.'" class="loader-image">
		                			<img id="img-'.$index.'" src="'.$poster.'">
	                			</div>
		                	</center>
		                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$title.'<br>
		                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.mb_strimwidth($overview, 0, 90, "...").'</div></div>

		        		</div>
				</a>';
			
	 	}
 		echo '<input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />';
 		echo '<input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
	}
	public function getLancamentos($page){
		$url = "https://api.themoviedb.org/3/movie/upcoming?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page&region=BR";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$totalPages = $json_data['total_pages'];

		foreach($json_data['results'] as $index=>$filme)
		{	
			$overview = addslashes(htmlspecialchars(empty($filme['overview']) ? "Sinopse não disponível em Português(Brasil)" : $filme['overview']));
			$title = htmlspecialchars($filme['title']);
			$poster = empty($filme['poster_path']) ? $this->getNoPoster() : $this->getApiImg($filme['poster_path'], 500);

			echo '<a href="../filme/detalhe.php?id='.$filme['id'].'">
		        		<div class="item rounded img-fluid" data-w="200" data-h="300">
		                	<center>
		                		<div id="loader-'.$index.'" class="loader-image">
		                			<img id="img-'.$index.'" src="'.$poster.'">
	                			</div>
		                	</center>
		                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$title.'<br>
		                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.mb_strimwidth($overview, 0, 90, "...").'</div></div>

		        		</div>
				</a>';
		}
		echo '<input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />';
		echo '<input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
	}
	public function getCartaz($page){
		$url = "https://api.themoviedb.org/3/movie/now_playing?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page&region=BR";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$totalPages = $json_data['total_pages'];

		foreach($json_data['results'] as $index=>$filme)
		{	
			$overview = addslashes(htmlspecialchars(empty($filme['overview']) ? "Sinopse não disponível em Português(Brasil)" : $filme['overview']));
			$title = htmlspecialchars($filme['title']);
			$poster = empty($filme['poster_path']) ? $this->getNoPoster() : $this->getApiImg($filme['poster_path'], 500);

			echo '<a href="../filme/detalhe.php?id='.$filme['id'].'">
		        		<div class="item rounded img-fluid" data-w="200" data-h="300">
		                	<center>
		                		<div id="loader-'.$index.'" class="loader-image">
		                			<img id="img-'.$index.'" src="'.$poster.'">
	                			</div>
		                	</center>
		                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$title.'<br>
		                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.mb_strimwidth($overview, 0, 90, "...").'</div></div>

		        		</div>
				</a>';
		}
		echo '<input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />';
		echo '<input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
	}
	public function getAvaliados($page){
		$url = "https://api.themoviedb.org/3/movie/top_rated?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$totalPages = $json_data['total_pages'];

		foreach($json_data['results'] as $index=>$filme)
		{	
			$overview = addslashes(htmlspecialchars(empty($filme['overview']) ? "Sinopse não disponível em Português(Brasil)" : $filme['overview']));
			$title = htmlspecialchars($filme['title']);
			$poster = empty($filme['poster_path']) ? $this->getNoPoster() : $this->getApiImg($filme['poster_path'], 500);

			echo '<a href="../filme/detalhe.php?id='.$filme['id'].'">
		        		<div class="item rounded img-fluid" data-w="200" data-h="300">
		                	<center>
		                		<div id="loader-'.$index.'" class="loader-image">
		                			<img id="img-'.$index.'" src="'.$poster.'">
	                			</div>
		                	</center>
		                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$title.'<br>
		                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.mb_strimwidth($overview, 0, 90, "...").'</div></div>

		        		</div>
				</a>';
		}
		echo '<input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />';
		echo '<input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
	}
	public function getEquipeTecnica($id){

		$url = "https://api.themoviedb.org/3/movie/" . $id . "/credits?api_key=" . $this->getKey() . $this->getLanguage();
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		
		if(empty($json_data['crew']))
		{
			echo '<div class="text-center"><i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
				  <b style="color: #5bc0de"> Não há dados sobre a equipe técnica.</b></div>
				  <input type="hidden" name="max-equipe-tecnica" id="max-equipe-tecnica" value="' . count($json_data['crew']) . '" />';
		  	return;
		}
		foreach($json_data['crew'] as $index=>$crew)
		{	
			$name = $crew['name'];
			$profile = is_null($crew['profile_path']) ? $crew['profile_path'] = '../res/imgs/unknown_person.png' : $this->getApiImg($crew['profile_path'], 185);
			$job = $crew['job'];
			echo '<a id="equipe-tecnica-' . $index . '" href="../pessoa/detalhe.php?id='.$crew['id'].'"  class="itens">
		        		<div class="item rounded img-fluid" data-w="186" data-h="280">
		                	<center>
		                		<div id="loader-equipe-tecnica-'.$index.'" class="loader-image">
		                			<img id="img-equipe-tecnica-'.$index.'"src="'.$profile.'">
	                			</div>
		                	</center>
		                	<div class="over" style="text-align: center; font-weight: bold; font-size: 15px; ">'. $name .
	                		'<div style="text-align: center; font-weight: normal; font-size: 13px; ">' . $job . '</div></div>
		        		</div>
				</a>';
			
	 	}
	 	echo '<input type="hidden" name="max-equipe-tecnica" id="max-equipe-tecnica" value="' . count($json_data['crew']) . '" />';
	}

	public function getElenco($id){

		$url = "https://api.themoviedb.org/3/movie/" . $id . "/credits?api_key=" . $this->getKey() . $this->getLanguage();
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		if(empty($json_data['cast']))
		{
			echo '<div class="text-center"><i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
				  <b style="color: #5bc0de"> Não há dados sobre o elenco.</b></div>
				  <input type="hidden" name="max-elenco" id="max-elenco" value="' . count($json_data['cast']) . '" />';
		  	return;
		}
		foreach($json_data['cast'] as $index=>$cast)
		{	
			$name = $cast['name'];
			$character = $cast['character'];
			$profile = is_null($cast['profile_path']) ? $cast['profile_path'] = '../res/imgs/unknown_person.png' : $this->getApiImg($cast['profile_path'], 185);
			echo '<a id="elenco-' . $index . '" href="../pessoa/detalhe.php?id='.$cast['id'].'" class="itens">
		        		<div class="item rounded img-fluid" data-w="186" data-h="280">
		                	<center>
			                	<div id="loader-elenco-'.$index.'" class="loader-image">
		                			<img id="img-elenco-'.$index.'"src="'.$profile.'">
	                			</div>
		                	</center>
		                	<div class="over" style="text-align: center; font-weight: bold; font-size: 15px; ">'. $name .
	                		'<div style="text-align: center; font-weight: normal; font-size: 13px; ">' . $character . '</div></div>
		        		</div>
				</a>';
	 	}
	 	echo '<input type="hidden" name="max-elenco" id="max-elenco" value="' . count($json_data['cast']) . '" />';
	}

	public function getMoviePosters($id){

		$url = "https://api.themoviedb.org/3/movie/" . $id . "/images?api_key=" . $this->getKey();
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		if(count($json_data['posters']) == 0)
		{
			echo '<a style="color: #ffbb33; text-decoration: none;" href="javascript:;">
					<b>Nenhum poster disponível</b>
				</a>';
			echo '<input type="hidden" id="count-posters" value="' . count($json_data['posters']) . '">';
			return;
		}
		foreach($json_data['posters'] as $index=>$poster)
		{	
			$poster_path = $this->getApiImg($poster['file_path'], 500);
			if($index == 0)
			{
				echo '<a class="media" id="poster-' . $index . '" href="' . $poster_path . '" data-fancybox="gallery-posters">
					<b>Ver posters</b>
					<img src="'. $poster_path.'" hidden>
				</a>';
			}
			else
			{
				echo '<a id="poster-' . $index . '" href="' . $poster_path . '" data-fancybox="gallery-posters" hidden>
						<img src="'. $poster_path.'">
					</a>';
			}
	 	}
	 	echo '<input type="hidden" id="count-posters" value="' . count($json_data['posters']) . '">';
	}
	public function getMovieBackdrops($id){

		$url = "https://api.themoviedb.org/3/movie/" . $id . "/images?api_key=" . $this->getKey();
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(count($json_data['backdrops']) == 0)
		{
			echo '<a style="color: #ffbb33; text-decoration: none;" href="javascript:;">
					<b>Nenhuma imagem de fundo disponível</b>
				</a>';
			echo '<input type="hidden" id="count-backdrops" value="' . count($json_data['backdrops']) . '">';
			return;
		}
		foreach($json_data['backdrops'] as $index=>$backdrop)
		{	
			$backdrop_path = $this->getApiImg($backdrop['file_path'], 1280);
			if($index == 0)
			{
				echo '<a class="media" id="backdrop-' . $index . '" href="' . $backdrop_path . '" data-fancybox="gallery-backdrops">
						<b>Ver imagens de fundo</b>
						<img src="'. $backdrop_path.'" hidden>
					</a>';
			}
			else
			{
				echo '<a id="backdrop-' . $index . '" href="' . $backdrop_path . '" data-fancybox="gallery-backdrops" hidden>
						<img src="'. $backdrop_path.'">
					</a>';
			}
	 	}
	 	echo '<input type="hidden" id="count-backdrops" value="' . count($json_data['backdrops']) . '">';
	}
	public function getMovieVideos($id){

		$url = "https://api.themoviedb.org/3/movie/" . $id . "/videos?api_key=" . $this->getKey() . $this->getLanguage(); 
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(empty($json_data['results']))//get default language
		{
			$url = "https://api.themoviedb.org/3/movie/" . $id . "/videos?api_key=" . $this->getKey();
			$json = file_get_contents($url);
			$json_data = json_decode($json, true);

			if(empty($json_data['results']))
			{
				echo '<a style="color: #ffbb33; text-decoration: none;" href="javascript:;">
						<b>Nenhum vídeo disponível</b>
					</a>';
				echo '<input type="hidden" id="count-videos" value="' . count($json_data['results']) . '">';
				return;
			}
			else
			{

				foreach($json_data['results'] as $index=>$video)
				{	
					$url = $this->getApiYoutube() . $video['key'] . '?autoplay=0';
					if($index == 0)
					{
						echo '<a class="media" id="video-' . $index . '" href="' . $url . '" data-fancybox="gallery-videos">
								<b>Ver vídeos</b>
							</a>';
					}
					else
					{
						echo '<a id="video-' . $index . '" href="' . $url . '" data-fancybox="gallery-videos" hidden>
							</a>';
					}
			 	}
			}
		}
		else
		{
			foreach($json_data['results'] as $index=>$video)
			{	
				$url = $this->getApiYoutube() . $video['key'] . '?autoplay=0';
				if($index == 0)
				{
					echo '<a class="media" id="video-' . $index . '" href="' . $url . '" data-fancybox="gallery-videos">
							<b>Ver vídeos</b>
						</a>';
				}
				else
				{
					echo '<a id="video-' . $index . '" href="' . $url . '" data-fancybox="gallery-videos" hidden>
						</a>';
				}
		 	}
		}
		echo '<input type="hidden" id="count-videos" value="' . count($json_data['results']) . '">';
	}

	public function getPersonPhotos($id){

		$url = "https://api.themoviedb.org/3/person/" . $id . "/images?api_key=" . $this->getKey();
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(count($json_data['profiles']) == 0)
		{
			echo '<a style="color: #ffbb33; text-decoration: none;" href="javascript:;">
					<b>Nenhuma foto disponível</b>
				</a>';
			echo '<input type="hidden" id="count-fotos" value="' . count($json_data['profiles']) . '">';
			return;
		}
		foreach($json_data['profiles'] as $index=>$foto)
		{	
			$foto_path = $this->getApiImg($foto['file_path'], 500);
			if($index == 0)
			{
				echo '<a class="media" id="foto-' . $index . '" href="' . $foto_path . '" data-fancybox="gallery-fotos">
					<b>Ver fotos</b>
					<img src="'. $foto_path.'" hidden>
				</a>';
			}
			else
			{
				echo '<a id="foto-' . $index . '" href="' . $foto_path . '" data-fancybox="gallery-fotos" hidden>
						<img src="'. $foto_path.'">
					</a>';
			}
	 	}
	 	echo '<input type="hidden" id="count-fotos" value="' . count($json_data['profiles']) . '">';
	}

	public function getDetailMovie($movie_id){
		$movieArray = array();
		$url = "https://api.themoviedb.org/3/movie/" . $movie_id . "?api_key=" . $this->getKey() . $this->getLanguage();
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		array_push($movieArray, $json_data);
		$movieArray[0]['changed'] = 0;

		if(empty($movieArray[0]['overview']))//get default language
		{
			$url = "https://api.themoviedb.org/3/movie/" . $movie_id . "?api_key=" . $this->getKey();
			$json = file_get_contents($url);
			$json_data = json_decode($json, true);
			$movieArray[0]['overview'] = $json_data['overview'];
			$movieArray[0]['changed'] = 1;
		}
		$movieArray[0]['status'] = $this->transtaleStatus($movieArray[0]['status']);
		return $movieArray[0];
	}

	public function getDetailPerson($person_id){
		$personArray = array();
		$url = "https://api.themoviedb.org/3/person/" . $person_id . "?api_key=" . $this->getKey() . $this->getLanguage();
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		array_push($personArray, $json_data);
		$personArray[0]['changed'] = 0;

		if(empty($personArray[0]['biography']))//get default language
		{
			$url = "https://api.themoviedb.org/3/person/" . $person_id . "?api_key=" . $this->getKey();
			$json = file_get_contents($url);
			$json_data = json_decode($json, true);
			$personArray[0]['biography'] = $json_data['biography'];
			$personArray[0]['changed'] = 1;
		}
		return $personArray[0];
	}

	public function getWorksPerson($id)
	{
		
			
		$url = "https://api.themoviedb.org/3/person/" . $id . "/movie_credits?api_key=" . $this->getKey() . $this->getLanguage();

		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		$elenco = $json_data['cast'];
		$equipe_tecnica = $json_data['crew'];

		if(empty($elenco) && empty($equipe_tecnica))
		{
			echo '<div class="text-center"><i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
				  <b style="color: #5bc0de"> Não há dados sobre os trabalhos desta pessoa.</b></div>';
			return;
		}

		if(!empty($elenco))
		{
			echo '<h4 style="color: white;"><span class="fas fa-video"></span> Atuação</h4>
				<hr style="background-color: white" />';
			echo '<table id="itens" class="table table-hover table-dark">
	                <thead class="thead-dark">
	                  <tr class="d-flex">
	                    <th class="col-2 col-sm-2 col-md-2 col-lg-2 text-center">Ano</th>
	                    <th class="col-8 col-sm-8 col-md-8 col-lg-9">Filme</th>
	                    <th class="col-2 col-sm-2 col-md-2 col-lg-1 text-center"><span class="fas fa-star"></span></th>
	                </tr>
	                </thead>
	                <tbody>';


			foreach ($elenco as $movie) 
			{
				$date = empty($movie['release_date']) ? '-' : date('Y', strtotime($movie['release_date']));
				$title = $movie['title'];
				$id = $movie['id'];
				$character = $movie['character'];
				$vote_average = $movie['vote_average'];

				if(!empty($character))
				{
					echo '<tr class="d-flex">
			          <td class="text-center col-2 col-sm-2 col-md-2 col-lg-2">
			            ' . $date .'
			          </td>
			          <td class="col-8 col-sm-8 col-md-8 col-lg-9">
			                <a href="../filme/detalhe.php?id='. $id .'" style="font-weight: bold; color: white;">
			                ' . $title . ' <div style="font-weight: normal; display: inline;">como </div>' . '<div style="color: rgb(92,184,92); font-weight: normal; display: inline;">' . $character .'
			                </div></a>
			          </td>
			          <td class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">
			                ' . $vote_average .'
			          </td>
			        </tr>';
				}
				else
				{
					echo '<tr class="d-flex">
			          <td class="text-center col-2 col-sm-2 col-md-2 col-lg-2">
			            ' . $date .'
			          </td>
			          <td class="col-8 col-sm-8 col-md-8 col-lg-9">
			                <a href="../filme/detalhe.php?id='. $id .'" style="font-weight: bold; color: white;">
			                ' . $title . '
			                </div></a>
			          </td>
			          <td class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">
			                ' . $vote_average .'
			          </td>
			        </tr>';
				}
			}

			echo '</tbody>
	          	</table>';
		}

		if(!empty($equipe_tecnica))
		{

	        $title = empty($elenco) ? 'Trabalhos' : 'Outros trabalhos';

	      	echo '<h4 style="color: white;"><span class="fas fa-briefcase"></span> ' . $title . '</h4>
					<hr style="background-color: white" />';
			echo '<table id="itens" class="table table-hover table-dark">
	                <thead class="thead-dark">
	                  <tr class="d-flex">
	                    <th class="col-2 col-sm-2 col-md-2 col-lg-2 text-center">Ano</th>
	                    <th class="col-8 col-sm-8 col-md-8 col-lg-9">Filme</th>
	                    <th class="col-2 col-sm-2 col-md-2 col-lg-1 text-center"><span class="fas fa-star"></span></th>
	                </tr>
	                </thead>
	                <tbody>';


			foreach ($equipe_tecnica as $movie) 
			{
				$date = empty($movie['release_date']) ? '-' : date('Y', strtotime($movie['release_date']));
				$title = $movie['title'];
				$id = $movie['id'];
				$job = $movie['job'];
				$vote_average = $movie['vote_average'];
				if(!empty($job))
				{
					echo '<tr class="d-flex">
			          <td class="text-center col-2 col-sm-2 col-md-2 col-lg-2">
			            ' . $date .'
			          </td>
			          <td class="col-8 col-sm-8 col-md-8 col-lg-9">
			                <a href="../filme/detalhe.php?id='. $id .'" style="font-weight: bold; color: white;">
			                ' . $title . ' <div style="font-weight: normal; display: inline;">como </div>' . '<div style="color: rgb(92,184,92); font-weight: normal; display: inline;">' . $job .'
			                </div></a>
			          </td>
			          <td class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">
			                ' . $vote_average .'
			          </td>
			        </tr>';
				}
				else
				{
					echo '<tr class="d-flex">
			          <td class="text-center col-2 col-sm-2 col-md-2 col-lg-2">
			            ' . $date .'
			          </td>
			          <td class="col-8 col-sm-8 col-md-8 col-lg-9">
			                <a href="../filme/detalhe.php?id='. $id .'" style="font-weight: bold; color: white;">
			                ' . $title . '
			                </div></a>
			          </td>
			          <td class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">
			                ' . $vote_average .'
			          </td>
			        </tr>';
				}
			}

			echo '</tbody>
	          	</table>';
      	}
 	}

 	public function getPopularPeople($page){
		
		$url = "https://api.themoviedb.org/3/person/popular?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$totalPages = $json_data['total_pages'];

		foreach($json_data['results'] as $index=>$person)
		{	
			$movies = array();
			$name = htmlspecialchars($person['name']);
			$poster = empty($person['profile_path']) ? $this->getNoPoster() : $this->getApiImg($person['profile_path'], 500);

			foreach($person['known_for'] as $index=>$movie)
			{
				if(!empty($movie['title']))
					array_push($movies, addslashes(htmlspecialchars($movie['title'])));
				else if(!empty($movie['original_title']))
					array_push($movies, addslashes(htmlspecialchars($movie['original_title'])));
			}

			echo '<a href="detalhe.php?id='.$person['id'].'">
		        		<div class="item rounded img-fluid" data-w="200" data-h="300">
		                	<center>
		                		<div id="loader-'.$index.'" class="loader-image">
		                			<img id="img-'.$index.'" src="'.$poster.'">
	                			</div>
		                	</center>
		                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$name.'<br>
		                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.implode(", ", $movies).'</div></div>

		        		</div>
				</a>';
			
	 	}
 		echo '<input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />';
 		echo '<input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
	}

	public function getRecomendations($movie_id){
		$url = "https://api.themoviedb.org/3/movie/" . $movie_id . "/recommendations?api_key=" . $this->getKey() . $this->getLanguage() . "&page=1";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(empty($json_data['results']))//get default language
		{
			$url = "https://api.themoviedb.org/3/movie/" . $movie_id . "/recommendations?api_key=" . $this->getKey() . "&page=1";
			$json = file_get_contents($url);
			$json_data = json_decode($json, true);

			if(empty($json_data['results']))
			{
				echo '<div class="text-center"><i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
    				  <b style="color: #5bc0de"> Não há dados suficientes para sugerir filmes baseado neste.</b></div>
    				  <input type="hidden" name="max-recomendacoes" id="max-recomendacoes" value="'. count($json_data['results']) . '" />';
			  	return;
			}

			echo '<div id="recommended" class="carousel slide" data-ride="carousel">';                      
			echo '<ol class="carousel-indicators">';
			foreach($json_data['results'] as $index=>$recomendation)
			{
				if($index == 0)
					echo '<li data-target="#recommended" data-slide-to="' . $index .'" class="active"></li>';
				else
					echo '<li data-target="#recommended" data-slide-to="' . $index .'"></li>';
			}
			echo '</ol>';
			echo '<div class="carousel-inner">';
			foreach($json_data['results'] as $index=>$recomendation)
			{
				$id = $recomendation['id'];
				$backdrop = empty($recomendation['backdrop_path']) ? $this->getNoBackdropSlide() : $this->getApiImg($recomendation['backdrop_path'], 780);
				$title = $recomendation['title'];
				$vote_average = $recomendation['vote_average'];
				if($index == 0)
				{
					echo '<div class="carousel-item active">
							<a href="detalhe.php?id='. $id .'">
	                    	<div style="width:100%;height:0; padding-top:50%;position:relative;">
								<img src="' . $backdrop . '" style="position:absolute; top:0; left:0; width:100%; opacity: 0.7;" class="d-block w-100">
							</div>
	                    	<div class="carousel-caption d-none d-md-block">
	                      		<h5>'. $title .'</h5>
	                      		<i class="fas fa-star"></i> ' . $vote_average . '
                    		</div>
                    		</a>
	                  	</div>';
				}
				else
				{
					echo '<div class="carousel-item">
							<a href="detalhe.php?id='.$recomendation['id'].'">
	                    	<div style="width:100%;height:0; padding-top:50%;position:relative;">
								<img src="' . $backdrop . '" style="position:absolute; top:0; left:0; width:100%; opacity: 0.7;" class="d-block w-100">
							</div>
                    		<div class="carousel-caption d-none d-md-block">
	                      		<h5>'. $recomendation['title'] .'</h5>
	                      		<i class="fas fa-star"></i> ' . $recomendation['vote_average'] . '
	                    	</div>
	                    	</a>
	                    </div>';
				}
			}
			echo '</div>';
            echo '<a class="carousel-control-prev" href="#recommended" role="button" data-slide="prev">
                  	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  	<span class="sr-only">Próximo</span>
            	</a>
                <a class="carousel-control-next" href="#recommended" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Anterior</span>
                </a>';
            echo '</div>';
		}
		else
		{
		 	echo '<div id="recommended" class="carousel slide" data-ride="carousel">';                      
			echo '<ol class="carousel-indicators">';
			foreach($json_data['results'] as $index=>$recomendation)
			{
				if($index == 0)
					echo '<li data-target="#recommended" data-slide-to="' . $index .'" class="active"></li>';
				else
					echo '<li data-target="#recommended" data-slide-to="' . $index .'"></li>';
			}
			echo '</ol>';
			echo '<div class="carousel-inner">';
			foreach($json_data['results'] as $index=>$recomendation)
			{
				$id = $recomendation['id'];
				$backdrop = empty($recomendation['backdrop_path']) ? $this->getNoBackdropSlide() : $this->getApiImg($recomendation['backdrop_path'], 780);
				$title = $recomendation['title'];
				$vote_average = $recomendation['vote_average'];

				if($index == 0)
				{
					echo '<div class="carousel-item active">
							<a href="detalhe.php?id='. $id .'">
							<div style="width:100%;height:0; padding-top:50%;position:relative;">
								<img src="' . $backdrop . '" style="position:absolute; top:0; left:0; width:100%; opacity: 0.7;" class="d-block w-100">
							</div>
	                    	<div class="carousel-caption d-none d-md-block">
	                      		<h5>'. $title .'</h5>
	                      		<i class="fas fa-star"></i> ' . $vote_average . '
                    		</div>
                    		</a>
	                  	</div>';
				}
				else
				{
					echo '<div class="carousel-item">
							<a href="detalhe.php?id='. $id .'">
	                    	<div style="width:100%;height:0; padding-top:50%;position:relative;">
								<img src="' . $backdrop . '" style="position:absolute; top:0; left:0; width:100%; opacity: 0.7;" class="d-block w-100">
							</div>
                    		<div class="carousel-caption d-none d-md-block">
	                      		<h5>'. $title .'</h5>
	                      		<i class="fas fa-star"></i> ' . $vote_average . '
	                    	</div>
	                    	</a>
	                    </div>';
				}
			}
			echo '</div>';	
            echo '<a class="carousel-control-prev" href="#recommended" role="button" data-slide="prev">
                  	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  	<span class="sr-only">Próximo</span>
            	</a>
                <a class="carousel-control-next" href="#recommended" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Anterior</span>
                </a>';
            echo '</div>';
		}
		echo '<input type="hidden" name="max-recomendacoes" id="max-recomendacoes" value="' . count($json_data['results']) . '" />';
	}

	public function getSimilars($movie_id){
		$url = "https://api.themoviedb.org/3/movie/" . $movie_id . "/similar?api_key=" . $this->getKey() . $this->getLanguage() . "&page=1";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(empty($json_data['results']))//get default language
		{
			$url = "https://api.themoviedb.org/3/movie/" . $movie_id . "/similar?api_key=" . $this->getKey() . "&page=1";
			$json = file_get_contents($url);
			$json_data = json_decode($json, true);

			if(empty($json_data['results']))
			{
				echo '<div class="text-center"><i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
    				  <b style="color: #5bc0de"> Não há dados suficientes para sugerir filmes baseado neste.</b></div>
    				  <input type="hidden" name="max-similares" id="max-similares" value="'. count($json_data['results']) . '" />';
			  	return;
			}

			echo '<div id="similar" class="carousel slide" data-ride="carousel">';                      
			echo '<ol class="carousel-indicators">';
			foreach($json_data['results'] as $index=>$similar)
			{
				if($index == 0)
					echo '<li data-target="#similar" data-slide-to="' . $index .'" class="active"></li>';
				else
					echo '<li data-target="#similar" data-slide-to="' . $index .'"></li>';
			}
			echo '</ol>';
			echo '<div class="carousel-inner">';
			foreach($json_data['results'] as $index=>$similar)
			{
				$id = $similar['id'];
				$backdrop = empty($similar['backdrop_path']) ? $this->getNoBackdropSlide() : $this->getApiImg($similar['backdrop_path'], 780);
				$title = $similar['title'];
				$vote_average = $similar['vote_average'];
				if($index == 0)
				{
					echo '<div class="carousel-item active">
							<a href="detalhe.php?id='. $id .'">
	                    	<div style="width:100%;height:0; padding-top:50%;position:relative;">
								<img src="' . $backdrop . '" style="position:absolute; top:0; left:0; width:100%; opacity: 0.7;" class="d-block w-100">
							</div>
	                    	<div class="carousel-caption d-none d-md-block">
	                      		<h5>'. $title .'</h5>
	                      		<i class="fas fa-star"></i> ' . $vote_average . '
                    		</div>
                    		</a>
	                  	</div>';
				}
				else
				{
					echo '<div class="carousel-item">
							<a href="detalhe.php?id='.$similar['id'].'">
	                    	<div style="width:100%;height:0; padding-top:50%;position:relative;">
								<img src="' . $backdrop . '" style="position:absolute; top:0; left:0; width:100%; opacity: 0.7;" class="d-block w-100">
							</div>
                    		<div class="carousel-caption d-none d-md-block">
	                      		<h5>'. $similar['title'] .'</h5>
	                      		<i class="fas fa-star"></i> ' . $similar['vote_average'] . '
	                    	</div>
	                    	</a>
	                    </div>';
				}
			}
			echo '</div>';
            echo '<a class="carousel-control-prev" href="#similar" role="button" data-slide="prev">
                  	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  	<span class="sr-only">Próximo</span>
            	</a>
                <a class="carousel-control-next" href="#similar" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Anterior</span>
                </a>';
            echo '</div>';
		}
		else
		{
		 	echo '<div id="similar" class="carousel slide" data-ride="carousel">';                      
			echo '<ol class="carousel-indicators">';
			foreach($json_data['results'] as $index=>$similar)
			{
				if($index == 0)
					echo '<li data-target="#similar" data-slide-to="' . $index .'" class="active"></li>';
				else
					echo '<li data-target="#similar" data-slide-to="' . $index .'"></li>';
			}
			echo '</ol>';
			echo '<div class="carousel-inner">';
			foreach($json_data['results'] as $index=>$similar)
			{
				$id = $similar['id'];
				$backdrop = empty($similar['backdrop_path']) ? $this->getNoBackdropSlide() : $this->getApiImg($similar['backdrop_path'], 780);
				$title = $similar['title'];
				$vote_average = $similar['vote_average'];

				if($index == 0)
				{
					echo '<div class="carousel-item active">
							<a href="detalhe.php?id='. $id .'">
							<div style="width:100%;height:0; padding-top:50%;position:relative;">
								<img src="' . $backdrop . '" style="position:absolute; top:0; left:0; width:100%; opacity: 0.7;" class="d-block w-100">
							</div>
	                    	<div class="carousel-caption d-none d-md-block">
	                      		<h5>'. $title .'</h5>
	                      		<i class="fas fa-star"></i> ' . $vote_average . '
                    		</div>
                    		</a>
	                  	</div>';
				}
				else
				{
					echo '<div class="carousel-item">
							<a href="detalhe.php?id='. $id .'">
	                    	<div style="width:100%;height:0; padding-top:50%;position:relative;">
								<img src="' . $backdrop . '" style="position:absolute; top:0; left:0; width:100%; opacity: 0.7;" class="d-block w-100">
							</div>
                    		<div class="carousel-caption d-none d-md-block">
	                      		<h5>'. $title .'</h5>
	                      		<i class="fas fa-star"></i> ' . $vote_average . '
	                    	</div>
	                    	</a>
	                    </div>';
				}
			}
			echo '</div>';	
            echo '<a class="carousel-control-prev" href="#similar" role="button" data-slide="prev">
                  	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  	<span class="sr-only">Próximo</span>
            	</a>
                <a class="carousel-control-next" href="#similar" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Anterior</span>
                </a>';
            echo '</div>';
		}
		echo '<input type="hidden" name="max-similares" id="max-similares" value="' . count($json_data['results']) . '" />';
	}

	public function getByGenre($genre_id, $page, $cont_adulto)
	{
		$url = "https://api.themoviedb.org/3/discover/movie?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page" 
		. "&include_adult=$cont_adulto" . "&include_video=true" . "&with_genres=$genre_id";

		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(empty($json_data['results']))
		{
			echo '<br>
				  <div class="text-center"><h4><b style="color: #5bc0de"> 
				  <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i> Nenhum resultado encontrado para esta categoria.</b><h4>
				  </div>
				  <input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />
				  <input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
		  	return;
		}

		foreach($json_data['results'] as $index=>$filme)
		{	
			$overview = addslashes(htmlspecialchars(empty($filme['overview']) ? "Sinopse não disponível em Português(Brasil)" : $filme['overview']));
			$title = htmlspecialchars($filme['title']);
			$poster = empty($filme['poster_path']) ? $this->getNoPoster() : $this->getApiImg($filme['poster_path'], 500);

			echo '<a href="../filme/detalhe.php?id='.$filme['id'].'">
		        		<div class="item rounded img-fluid" data-w="200" data-h="300">
		                	<center>
		                		<div id="loader-'.$index.'" class="loader-image">
		                			<img id="img-'.$index.'" src="'.$poster.'">
	                			</div>
		                	</center>
		                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$title.'<br>
		                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.mb_strimwidth($overview, 0, 90, "...").'</div></div>

		        		</div>
				</a>';
			
	 	}
 		echo '<input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />';
 		echo '<input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
	}
	
	public function getBySearch($search, $page, $cont_adulto, $type)
	{
		$url = "https://api.themoviedb.org/3/search/$type?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page" 
		. "&include_adult=$cont_adulto" . "&query=$search";

		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(empty($json_data['results']))
		{
			echo '<br>
				  <div class="text-center"><h4><b style="color: #5bc0de"> 
				  <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i> Nenhum resultado encontrado para esta busca.</b><h4>
				  </div>
				  <input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />
				  <input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
		  	return;
		}

		if($type == 'movie')
		{
			foreach($json_data['results'] as $index=>$filme)
			{	
				$overview = addslashes(htmlspecialchars(empty($filme['overview']) ? "Sinopse não disponível em Português(Brasil)" : $filme['overview']));
				$title = htmlspecialchars($filme['title']);
				$poster = empty($filme['poster_path']) ? $this->getNoPoster() : $this->getApiImg($filme['poster_path'], 500);

				echo '<a href="../filme/detalhe.php?id='.$filme['id'].'">
			        		<div class="item rounded img-fluid" data-w="200" data-h="300">
			                	<center>
			                		<div id="loader-'.$index.'" class="loader-image">
			                			<img id="img-'.$index.'" src="'.$poster.'">
		                			</div>
			                	</center>
			                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$title.'<br>
			                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.mb_strimwidth($overview, 0, 90, "...").'</div></div>

			        		</div>
					</a>';
				
		 	}
		}
		else
		{
			foreach($json_data['results'] as $index=>$person)
			{	
				$movies = array();
				$name = htmlspecialchars($person['name']);
				$poster = empty($person['profile_path']) ? $this->getNoPoster() : $this->getApiImg($person['profile_path'], 500);

				foreach($person['known_for'] as $index=>$movie)
				{
					if(!empty($movie['title']))
						array_push($movies, addslashes(htmlspecialchars($movie['title'])));
					else if(!empty($movie['original_title']))
						array_push($movies, addslashes(htmlspecialchars($movie['original_title'])));
				}

				echo '<a href="../pessoa/detalhe.php?id='.$person['id'].'">
			        		<div class="item rounded img-fluid" data-w="200" data-h="300">
			                	<center>
			                		<div id="loader-'.$index.'" class="loader-image">
			                			<img id="img-'.$index.'" src="'.$poster.'">
		                			</div>
			                	</center>
			                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$name.'<br>
			                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.implode(", ", $movies).'</div></div>

			        		</div>
					</a>';
				
		 	}
		}
		
 		echo '<input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />';
 		echo '<input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
	}

	public function getBasedOnFavorites($genre_id, $page, $cont_adulto, $type)
	{

		$needYear = $this->yearNeeded($type) ? "&primary_release_date.gte=" . date("Y-m-d") : "";

		$type = $this->getType($type);
		
		$url = "https://api.themoviedb.org/3/discover/movie?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page&region=BR" 
		. "&include_adult=$cont_adulto" . "&include_video=true" . "&with_genres=$genre_id" . $type . $needYear;


		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(empty($json_data['results']))
		{
			echo '<br>
				  <div class="text-center"><h4><b style="color: #5bc0de"> 
				  <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i> Nenhum resultado encontrado para esta categoria.</b><h4>
				  </div>
				  <input type="hidden" name="items-page" id="items-page-' . $genre_id . '" value="' .count($json_data['results']). '" />
				  <input type="hidden" name="total-items" id="total-items-' . $genre_id . '" value="' .$json_data['total_results']. '" />';
		  	return;
		}

		foreach($json_data['results'] as $index=>$filme)
		{	
			$overview = addslashes(htmlspecialchars(empty($filme['overview']) ? "Sinopse não disponível em Português(Brasil)" : $filme['overview']));
			$title = htmlspecialchars($filme['title']);
			$poster = empty($filme['poster_path']) ? $this->getNoPoster() : $this->getApiImg($filme['poster_path'], 500);

			echo '<a href="../filme/detalhe.php?id='.$filme['id'].'">
		        		<div class="item rounded img-fluid" data-w="200" data-h="300">
		                	<center>
		                		<div id="loader-based-'.$index.'-' . $genre_id. '" class="loader-image">
		                			<img id="img-based-'.$index.'-' . $genre_id. '" src="'.$poster.'">
	                			</div>
		                	</center>
		                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$title.'<br>
		                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.mb_strimwidth($overview, 0, 90, "...").'</div></div>

		        		</div>
				</a>';
			
	 	}
 		echo '<input type="hidden" name="items-page" id="items-page-' . $genre_id . '" value="' . count($json_data['results']) . '" />';
 		echo '<input type="hidden" name="total-items" id="total-items-' . $genre_id . '" value="' . $json_data['total_results'] . '" />';
	}

	public function exploreMovie($page, $cont_adulto, $ano, $sort_by, $genre_ids)
	{
		
		$url = "https://api.themoviedb.org/3/discover/movie?api_key=" . $this->getKey() . $this->getLanguage() ."&page=$page" 
		. "&include_adult=$cont_adulto" . "&with_genres=$genre_ids" . "&primary_release_year=$ano" . "&sort_by=$sort_by";


		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		if(empty($json_data['results']))
		{
			echo '<br>
				  <div class="text-center"><h4><b style="color: #5bc0de"> 
				  <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i> Nenhum resultado encontrado para este filtro.</b><h4>
				  </div>
				  <input type="hidden" name="items-page" id="items-page" value="' .count($json_data['results']). '" />
				  <input type="hidden" name="total-items" id="total-items" value="' .$json_data['total_results']. '" />';
		  	return;
		}

		foreach($json_data['results'] as $index=>$filme)
		{	
			$overview = addslashes(htmlspecialchars(empty($filme['overview']) ? "Sinopse não disponível em Português(Brasil)" : $filme['overview']));
			$title = htmlspecialchars($filme['title']);
			$poster = empty($filme['poster_path']) ? $this->getNoPoster() : $this->getApiImg($filme['poster_path'], 500);

			echo '<a href="../filme/detalhe.php?id='.$filme['id'].'">
		        		<div class="item rounded img-fluid" data-w="200" data-h="300">
		                	<center>
		                		<div id="loader-img-'.$index.'" class="loader-image">
		                			<img id="img-'.$index.'" src="'.$poster.'">
	                			</div>
		                	</center>
		                	<div class="overbottom" style="text-align: center; font-weight: bold; font-size: 15px; color: rgb(92,184,92);">'.$title.'<br>
		                	<div style="text-align: center; font-size: 13px; font-weight: normal; color: white;">'.mb_strimwidth($overview, 0, 90, "...").'</div></div>

		        		</div>
				</a>';
			
	 	}
 		echo '<input type="hidden" name="items-page" id="items-page" value="' . count($json_data['results']) . '" />';
 		echo '<input type="hidden" name="total-items" id="total-items" value="' . $json_data['total_results'] . '" />';
	}

	public function getFavoritos($ids, $idsInteresses)
	{
		$interesses = $idsInteresses;//cache
		foreach($ids as $id)
		{	
			
			$url = "https://api.themoviedb.org/3/movie/" . $id['idFilme'] . "?api_key=" . $this->getKey() . $this->getLanguage();

			$json = file_get_contents($url);
			$json_data = json_decode($json, true);

			$movie = $json_data;

			$disabled = false;

			foreach ($interesses as $interesse) 
			{
				if($id['idFilme'] == $interesse['idFilme'])
					$disabled = true;
			}

			$value = $disabled ? 'checked' : $id['idFilme'] ;
			$class = $disabled ? 'fas fa-check text-success' : 'fas fa-bookmark text-primary';

			echo '<tr class="d-flex">
              <th class="text-center col-2 col-sm-2 col-md-2 col-lg-1">
                <a onclick="add('. "'favoritos'" .' , '. $id['idFilme'] .', this)" href="javascript:;" value="'. $value .'">
                    <span class="'.$class.'" aria-hidden="true">
                      
                    </span>
                </a>
                <a onclick="check(this, '. "'favoritos'" .', '. $id['idFilme'] .')" href="javascript:;" value="' . $id['idFilme'] . '">
                  <span class="fas fa-times text-danger" aria-hidden="true">
                    
                  </span>
                </a>
              </th>
              <td class="col-6 col-sm-6 col-md-6 col-lg-9">
                    <a href="../filme/detalhe.php?id='. $id['idFilme'] .'" style="color: black; font-weight: bold;">' . $movie['title'] .'</a>
              </td>
              <td class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">
                    ' . date('Y', strtotime($movie['release_date'])) .'
              </td>
              <td class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">
                    ' . $movie['vote_average'] .'
              </td>
            </tr>';
	 	}

	}

	public function getInteresses($ids, $favoritos)
	{
		foreach($ids as $index=>$id)
		{	
			
			$url = "https://api.themoviedb.org/3/movie/" . $id['idFilme'] . "?api_key=" . $this->getKey() . $this->getLanguage();

			$json = file_get_contents($url);
			$json_data = json_decode($json, true);

			$movie = $json_data;

			$disabled = false;

			foreach ($favoritos as $favorito) {
				if($id['idFilme'] == $favorito['idFilme'])
					$disabled = true;
			}

			$value = $disabled ? 'checked' : $id['idFilme'] ;
			$class = $disabled ? 'fas fa-check text-success' : 'fas fa-heart text-danger';

			echo '<tr class="d-flex">
              <th class="text-center col-2 col-sm-2 col-md-2 col-lg-1">
                <a onclick="add('. "'interesses'" .' , '. $id['idFilme'] .', this)" href="javascript:;" value="'. $value .'">
                    <span class="'.$class.'" aria-hidden="true">
                      
                    </span>
                </a>
                <a onclick="check(this, '. "'interesses'" .', '. $id['idFilme'] .')" href="javascript:;" value="' . $id['idFilme'] . '">
                  <span class="fas fa-times text-danger" aria-hidden="true">
                    
                  </span>
                </a>
              </th>
              <td class="col-6 col-sm-6 col-md-6 col-lg-9">
                    <a href="../filme/detalhe.php?id='. $id['idFilme'] .'" style="color: black; font-weight: bold;">' . $movie['title'] .'</a>
              </td>
              <td class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">
                    ' . date('Y', strtotime($movie['release_date'])) .'
              </td>
              <td class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">
                    ' . $movie['vote_average'] .'
              </td>
            </tr>';
	 	}

	}

	public function yearNeeded($type)
	{
		switch ($type) {
			case 'populares':
				return false;
			case 'avaliados':
				return false;
			case 'lancamentos':
				return true;
			default:
				return false;
		}
	}

	public function getType($type)
	{
		switch ($type) {
			case 'populares':
				return '&sort_by=popularity.desc';
			case 'avaliados':
				return '&sort_by=vote_average.desc';
			case 'lancamentos':
				return '&sort_by=release_date.desc';
			default:
				return '';
		}
	}

	public function transtaleStatus($status)
	{
		switch ($status) {
			case 'Rumored':
				return 'Rumor';
			case 'Planned':
				return 'Planejado';
			case 'In Production':
				return 'Em produção';
			case 'Post Production':
				return 'Pós-produção';
			case 'Released':
				return 'Lançado';
			default://Canceled
				return 'Cancelado';
		}
	}
	public function getApiImg($url, $size)
	{
		switch ($size) {
			case 185:
				return 'https://image.tmdb.org/t/p/w185' . $url;
			case 250:
				return 'https://image.tmdb.org/t/p/w250_and_h141_face' . $url;
			case 500:
				return 'https://image.tmdb.org/t/p/w500' . $url;
			case 600:
				return 'https://image.tmdb.org/t/p/w600_and_h900_bestv2' . $url;
			case 780:
				return 'https://image.tmdb.org/t/p/w780' . $url;
			case 1280:
				return 'https://image.tmdb.org/t/p/w1280' . $url;
			case 1400:
				return 'https://image.tmdb.org/t/p/w1400_and_h450_face' . $url;
			default://original
				return 'https://image.tmdb.org/t/p/original' . $url;
		}
	}
	public function convertMins($time, $format = '%02d:%02d')
	{
	    if ($time < 1) {
	        return;
	    }
	    $hours = floor($time / 60);
	    $minutes = ($time % 60);
	    return sprintf($format, $hours, $minutes);
	}
}
?>