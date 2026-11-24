<?php
//hago una funcion para comprobar usuario y contraseña
//el usuario tiene que tener 8 o + caracteres
//la contraseña es nombre del usuario al reves

function usuarioOk($usuario, $contraseña) :bool {
  //strlen cuenta los caracteres, strrev da la vuelta al texto
   return strlen($usuario) >= 8 && $contraseña == strrev($usuario);
    
}

//creo una funcion de anlizar el texto para ver las palabras repes
function analizarTexto (string $texto): array{
   //mb_strlen cuenta caracteres total 
   $longitud= mb_strlen($texto);

   //str_word_count devuelve un array con las palabras
   $palabras= str_word_count($texto,1, "áéíóúüñÁÉÍÓÚÜÑ");

   //si no hay ninguna palabra no se puede calcular lo demas
   if(count($palabras) == 0){
      return ["longitud" => $longitud, 
               "palabras" => 0,
               "letra" => "-",
               "palabraRep" => "-",
               "masLarga" => "-",
               "vocales" => 0];
   }

   //saco la palabra mas repetida array_count_values cuento cuantas veces sale
   //cada valor y max() me da el numero mas alto y array_search busca cual es esa palabra
   $repPalabras= array_count_values($palabras);
   $palabraRep= array_search(max($repPalabras), $repPalabras);

   //Letra mas repetida: mb_strtolower paso todo a minusculas para que las cuente igual a todas
   //preg_replace borrar todo lo que NO sea letra como espacios,comas...
   //mb_str_Split parte el texto en un array de caracteres sueltos
   $soloLetras= preg_replace('/[^a-zñáéíóúü]/u', '', mb_strtolower($texto));
   $repLetras= array_count_values(mb_str_split($soloLetras));
   $letra= array_search(max($repLetras), $repLetras);

   //Palabra mas larga
   $masLarga="";
   foreach ($palabras as $p){
      if (mb_strlen($p) > mb_strlen($masLarga)) $masLarga= $p;

   }
   //numero de vocales preg_match_all me dice cuantas veces encuentra el /patron/iu
   //la i ignira mayusculas y la u por las tildes
   $vocales= preg_match_all('/[aeiouáéíóúü]/iu', $texto);
   //devuelvo todo en un  array de clave -> valor
   return ["longitud" => $longitud,
            "palabras" => count($palabras),
            "letra" => $letra,
            "palabraRep" => $palabraRep,
            "masLarga" => $masLarga,
            "vocales" => $vocales];
}
