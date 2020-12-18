<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://icons.iconarchive.com/icons/google/noto-emoji-people-stories/1024/10934-man-zombie-icon.png" width="200"></a></p>

<h4 align="center">
API REST LARAVEL <br> CASO APOCALIPSE ZOMBIE ACONTEÇA
</h4>

## Primeiros passos
###RUN:
```
compose install
```
```
php artisan migrate
```
```
php artisan serve
```
##GET
```
/api/survivor
```
```
/api/survivor/{id}
```
##POST
```
/api/survivor
```
##PUT
```
/api/survivor/{id}
```
##DELETE
```
/api/survivor/{id}
```

##RELATORIO
```
[GET]

/api/relatorio
```

##TROCAS
```
INVENTARIO DO SOBREVIVENTE:

ITEM
ÁGUA
COMIDA
MEDICAMENTO
MUNIÇÃO
```
<h5>ITEM:</h5>
```
POST:

{
    "troca":  [indique a categoria do inventario que você
    deseja trocar (ex: item, medicamento, agua...)
    "id": id da pessoa que solicitou a troca.
    "id_exchange": pessoa que vai fazer a troca.
}
```
```
Sobreviventes carregam consigo [armas, facas, etc...]
e eles podem fazer trocas desses objetos.
```
```
obs: Sobreviventes infectados não podem fazer trocas !
```
<h5>ÁGUA:</h5>
```
EM BREVE
```
<h5>COMIDA:</h5>
```
EM BREVE
```
<h5>MEDICAMENTO:</h5>
```
EM BREVE
```
<h5>MUNIÇÃO:</h5>
```
EM BREVE
```


