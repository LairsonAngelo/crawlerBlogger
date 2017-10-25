<?php
  Class Noticia {

      public static function SalvaNoticiaObjeto($link){
            $html = file_get_html($link);
            foreach($html->find('.fontBODYTITULOS',0) as $element){
              if(@$element->plaintext != ''){
                $objeto['Corpo'][] =  substr(@$element->plaintext,0,strlen(@$element->plaintext) - 242);
            //    $pattern = '\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}';
                $strings  =  substr(@$element->plaintext,strlen(@$element->plaintext) - 264,strlen(@$element->plaintext));
                $objeto['Data'][] = substr($strings,0,strlen($strings) - 254);
                $strings   =  substr(@$element->plaintext,strlen(@$element->plaintext) - 250,strlen(@$element->plaintext));
                $objeto['Hora'][] = substr($strings,0,strlen($strings) - 242);
                }

            }

            foreach($html->find('.fontBODYTITULOS') as $element)
              $objeto['Titulo'][] = @$element->plaintext;

            foreach($html->find('#imgefeito') as $element){
                if(substr(@$element->src,0,6) == "upload"){
                  $objeto['Imagem'][] = $imgurl = "http://www.danielnoblog.com.br/".@$element->src;
                }else{
                    $objeto['Imagem'][] = $imgurl = @$element->src;
                }
                  echo substr(@$element->src,0,6);
                //  echo $imgurl."\n\n\n";
                  $imagename= basename($imgurl);
                  $image = Noticia::pegarIMG($imgurl);
                  file_put_contents('./imagens/'.$imagename,$image);
            }

                  gravar("<titulo>".$objeto['Titulo'][0]."</titulo>\n");
                  gravar("<imagem>".$objeto['Imagem'][0]."</imagem>\n");
                  gravar("<data>".$objeto['Data'][0]."</data>\n");
                  gravar("<hora>".$objeto['Hora'][0]."</hora>\n");
                  gravar("<corpo>".$objeto['Corpo'][0]."</corpo>\n");
      }

      function Run($pagina){
          $sitePrincipal = 'http://www.danielnoblog.com.br/index.php?pg='.$pagina;
          $html = file_get_html($sitePrincipal);

          foreach($html->find('.fontBODYTITULOS > a ') as $element){
                  $link =  substr($element->href, 1, strlen($element->href));
                  $linknoticia = ("http://www.danielnoblog.com.br/".$link);
                  Noticia::SalvaNoticiaObjeto($linknoticia);

          }

          if(@$html->find("[title='Antigas']")[0] == ''){
            echo "Fim!!!!";
          }else{
            $pagina = $pagina + 1;
            Noticia::Run($pagina);
          }
      }



    public static function pegarImg($url) {
        $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $useragent = 'php';
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERAGENT, $useragent);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }

  }
