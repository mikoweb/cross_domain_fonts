# Cross Domain Fonts
Ten prosty skrypt został napisany dlatego, że na hostingu mydevil.net jest ignorowana reguła:

`Header set Access-Control-Allow-Origin "*"`

Co utrudnia wdrożenie @font-face w przypadku kiedy używamy serwerów CDN np. cloudflare.com.

W celu zainstalowania skryptu wystarczy wypakować wszystkie pliki na koncie FTP. Pliki z czcionkami należy wrzucać do folderu `fonts`.

Plik czcionki, który przykładowo znajduje się w lokalizacji: `/home/user/www/fonts/FontAwesome/fontawesome-webfont.woff` będzie dostępny pod nieco zmienionym adresem URL, który nie zawiera folderu `fonts`, czyli np. `http://domena.com/FontAwesome/fontawesome-webfont.woff`.

Skrypt dodaje nagłówek `Access-Control-Allow-Origin *`, zatem czcionki będą dostępne z dowolnego hosta.