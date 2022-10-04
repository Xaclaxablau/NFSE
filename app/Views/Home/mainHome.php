<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">

</head>
<body>
<style>
body{
  background-color: green;
  color:white;
  text-align: center;
}
</style>  
<img src="https://duimpweb.com.br/public/assets/imagens/logoshare.jpg" alt="" width="100px" height="100px">

   <h1> <?= $titulo ?></h1> 
   <form action="<?= base_url('Teste/consultar')?>">
     <label for="numero">NOTA</label>
       <input type="text" class="form-control m-2" name="numero">
     <button class="btn btn-success w-100 m-2" type="submit" >Enviar</button>
   </form>
</body>
</html>