# SimpleThumbPHP
Classe para gerar thumbnail personalizada


**Exemplo:**
```php

$mode = 'C'; //C (centered) || 'F' (full)
$modeFile = 'B'; //B (show to browser) || 'D' (download in browser) || 'S' (save to file) 

$myImg = new SimpleThumbPHP();
$myImg->create(string $imgPath, float $width, float $height, string $mode);
$myImg->save(string $modeFile, string $pathSave);
```
