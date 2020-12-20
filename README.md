<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://icon-library.com/images/zombie-icon-png/zombie-icon-png-18.jpg" width="200"></a></p>

<h4 align="center">
API REST LARAVEL <br> CASO APOCALIPSE ZOMBIE ACONTEÇA
</h4>

## Primeiros passos
### RUN:
```
compose install
```
```
php artisan migrate
```
```
php artisan serve
```
## GET
```
/api/survivor
```
```
/api/survivor/{id}
```
## POST
```
/api/survivor
```
## PUT
```
/api/survivor/{id}
```
## DELETE
```
/api/survivor/{id}
```

## RELATORIO
```
[GET]

/api/relatorio
```
## INVENTARIO
```
ITEM
ÁGUA - 4 pontos equivale a 1 agua (WATER).
COMIDA - 3 pontos de comida equivale a 1 comida (FOOD).
MEDICAMENTO - 2 pontos equivalem a 1 medicamento (MEDICAMENT).
MUNIÇÃO - 1  ponto equivalem a 1 munição (AMMUNITION).
```
## TROCAS
```
Sobreviventes conseguem trocar seus pontos de cada item
do inventario por outros items.
```
### TROCANDO (ITEM)
```
ENVIE UM [POST] /api/items/trocas contendo:

    {
        "survivor_troca": "item",
        "id_survivor_1": ,
        "id_survivor_2": 
    } 
  
 1. troca = Aqui você deve informar quais dos items do inventario deseja fazer a troca, já que estamos trocando o item do inventario colocamos "item".
 2. id_survivor_1 = Aqui você deve informar o id da pessoa que quer fazer a troca.
 3. id_survivor_2 = Aqui deve informar o id da pessoa que aceitou a troca.

```

```
obs: Sobreviventes infectados não podem fazer trocas !
```
### TROCANDO (AGUA)
```
ENVIE UM [POST] /api/items/trocas contendo:
  ex:
    {
        "survivor_troca": "W-F",
        "id_survivor_1": 1 ,
        "id_survivor_2": 2,
        "quantity": 1
    }
    
W-F - TROCAR AGUA POR COMIDA.
W-M - TROCAR AGUA POR MEDICAMENTO.
W-A - TROCAR AGUA POR MUNIÇÃO

1. id_survivor_1 = Aqui você deve informar o id da pessoa que quer fazer a troca.
2. id_survivor_2 = Aqui deve informar o id da pessoa que aceitou a troca.
3. quantity: Quantidade que deseja trocar.
```
### COMIDA
```
EM BREVE
```
### MEDICAMENTO
```
EM BREVE
```
### MUNIÇÃO
```
EM BREVE
```


