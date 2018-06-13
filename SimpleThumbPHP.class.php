<?php

/**
*@author Heiter Developer <dev@heiterdeveloper.com>
*@link https://github.com/HeiterDeveloper/SimpleThumbPHP
*@copyright 2018 Heiter Developer
*@license Aapache License 2.0
*@license https://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
**/

class SimpleThumbPHP{

  private $sizes;
  private $larg;
  private $alt;
  private $marginTop;
  private $marginLeft;
  private $imgBase;
  private $imgEdit;
  private $mimeTypeImg;

  public function create($img, $widthImg, $heightImg, $mode){

    $this->sizes = getimagesize($img);

    if($mode == 'C'){

      if($widthImg >= $heightImg){

        if($this->sizes[0] <= $this->sizes[1]){

          $this->larg =  ($heightImg / $this->sizes[1]) * $this->sizes[0];
          $this->alt = $heightImg;
          $this->marginLeft = ($widthImg - $this->larg) / 2;
          $this->marginTop = 0;

        }
        if($this->sizes[0] >= $this->sizes[1]){

          $larg = ($heightImg / $this->sizes[1]) * $this->sizes[0];
          $alt = $heightImg;
          $marginLeft = ($widthImg - $larg) / 2;
          $marginTop = 0;

          if($larg > $widthImg){

            $nvl = $larg - $widthImg;
            $larg = $widthImg;
            $alt = ($widthImg / $this->sizes[0]) * $this->sizes[1];
            $marginTop = ($heightImg - $alt) / 2;
            $marginLeft = 0;

          }

          $this->larg =  $larg;
          $this->alt = $alt;
          $this->marginLeft = $marginLeft;
          $this->marginTop = $marginTop;

        }

      }

      if($widthImg < $heightImg){

        if($this->sizes[0] <= $this->sizes[1]){

          $this->larg =  ($heightImg / $this->sizes[1]) * $this->sizes[0];
          $this->alt = $heightImg;
          $this->marginLeft = ($widthImg - $this->larg) / 2;
          $this->marginTop = 0;

        }

        if($this->sizes[0] >= $this->sizes[1]){

          $this->larg = $widthImg;
          $this->alt = ($widthImg / $this->sizes[0]) * $this->sizes[1];;
          $this->marginLeft = 0;
          $this->marginTop = ($heightImg - $this->alt) / 2;

        }

      }

    }

    if($mode == 'F'){

      if($heightImg >= $widthImg){

        $larg = ($heightImg / $this->sizes[1]) * $this->sizes[0];
        $alt = $heightImg;
        $marginTop = 0;

        if($widthImg > $larg){

          $nvl = $widthImg - $larg;
          $larg = $widthImg;
          $alt += $nvl;
          $marginTop = - ($nvl / 2);

        }

        $this->larg = $larg;
        $this->alt = $alt;
        $this->marginTop = $marginTop;
        $this->marginLeft = - ($this->larg - $widthImg) / 2;

      }
      if($heightImg < $widthImg){

          $larg = $widthImg;
          $alt = ($widthImg / $this->sizes[0]) * $this->sizes[1];
          $marginLeft = 0;
          $marginTop = - ($alt - $heightImg) / 2;

          if($heightImg > $alt){

            $alt = $heightImg;
            $larg = ($heightImg / $this->sizes[1]) * $this->sizes[0];
            $marginLeft = - ($larg - $widthImg) / 2;
            $marginTop = 0;

          }

          $this->larg = $larg;
          $this->alt = $alt;
          $this->marginLeft = $marginLeft;
          $this->marginTop = $marginTop;

      }
      if($heightImg == $widthImg){

        if($this->sizes[0] > $this->sizes[1]){

          $this->larg = ($heightImg / $this->sizes[1]) * $this->sizes[0];
          $this->alt = $heightImg;
          $this->marginLeft = - ($this->larg - $widthImg) / 2;
          $this->marginTop = 0;

        }
        else{

          $this->larg = $widthImg;
          $this->alt = ($widthImg / $this->sizes[0]) * $this->sizes[1];
          $this->marginLeft = 0;
          $this->marginTop = - ($this->alt - $heightImg) / 2;

        }
      }
    }

    $this->imgBase = imagecreatetruecolor($widthImg, $heightImg);

    switch(mime_content_type($img)){

      case "image/jpeg":
        $this->imgEdit = imagecreatefromjpeg($img);
        $this->mimeTypeImg = "image/jpeg";
        break;

      case "image/png":
        $this->imgEdit = imagecreatefrompng($img);
        $this->mimeTypeImg = "image/png";
        break;

      case "image/gif":
        $this->imgEdit = imagecreatefromgif($img);
        $this->mimeTypeImg = "image/gif";
        break;

    }

    imagecolortransparent($this->imgBase, imagecolorallocate(0,0,0));
    imagecopyresampled($this->imgBase, $this->imgEdit, $this->marginLeft, $this->marginTop, 0,0, $this->larg, $this->alt, $this->sizes[0],$this->sizes[1]);

  }

  public function save($modeFile, $pathSave=0){

    $file;
    $filename;
    $filenameSave;
    $ext = array("image/jpeg"=>"jpg", "image/png"=>"png", "image/gif"=>"gif");


    if($modeFile == "S"){
      $filenameSave = ($pathSave !== 0) ? $pathSave : NULL;
    }

    if($modeFile == "B" || $modeFile == "D" || $modeFile == "S"){

      if($modeFile == "B" || $modeFile == "D"){
        header("Content-Type: " . $this->mimeTypeImg);

        if($modeFile == "D"){
          $filename = ($pathSave !== 0) ? $pathSave : "thumbnail." . $ext[$this->mimeTypeImg];
          header("Content-Disposition: attachment; filename=\"". $filename . "\"");

        }

      }
      switch($this->mimeTypeImg){

        case "image/jpeg":
          imagejpeg($this->imgBase, $filenameSave);
          break;

        case "image/png":
          imagepng($this->imgBase, $filenameSave);
          break;

        case "image/gif":
          imagegif($this->imgBase, $filenameSave);
          break;

      }
    }
  }
}

?>
