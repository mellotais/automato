<?php

class Pilha {
    private $pilha;

    public function __construct() {
        $this->pilha = array();
    }

    public function empilha($elemento) {
        array_push($this->pilha, $elemento);
    }

    public function desempilha() {
        if (!$this->estaVazia()) {
            array_pop($this->pilha);
        }
    }

    public function getTopo() {
        if (!$this->estaVazia()) {
            return end($this->pilha);
        }
        return null;
    }

    public function estaVazia() {
        return empty($this->pilha);
    }

    public function __toString() {
        return implode(' ', $this->pilha);
    }
}

$F = array(4);

$delta = array(
    array('0', 'ε', 'Z0', '1', 'Z0'),
    array('1', 'ε', 'Z0', '2', 'Z0'),
    array('2', 'ε', 'Z0', '3', 'Z0'),
    array('3', 'ε', 'Z0', '4', 'ε'),
    array('1', 'ε', 'programa', '1', 'id(<declaracao>) <comandos>'),
    array('1', 'ε', '<comandos>', '1', '<comando> <comandos>'),
    array('1', 'ε', '<comandos>', '1', '<comando>'),
    array('1', 'ε', '<comando>', '1', '<declaracoes>'),
    array('1', 'ε', '<comando>', '1', 'if'),
    array('1', 'ε', '<comando>', '1', 'return'),
    array('1', 'ε', '<comando>', '1', '<atribuicao>'),
    array('1', 'ε', '<declaracoes>', '1', 'id : <tipo>'),
    array('1', 'ε', '<tipo>', '1', 'char'),
    array('1', 'ε', '<tipo>', '1', 'int'),
    array('1', 'ε', '<tipo>', '1', 'vetor'),
    array('1', 'ε', 'if', '1', 'if (<expressao>) { <comandos> } else { <comandos> }'),
    array('1', 'ε', '<expressao>', '1', 'id <op> <constante>')
);

$p = new Pilha();
$p->empilha('Z0');
$estado = 0; // estado inicial
$entrada = "programa id(id: int){
   id: int;
   if (id > 0){
         id = id / 2;
   } else{
        id = 0;
   }
  return id;
}";

$i = 0;

while ($i < strlen($entrada)) {
    echo $p;
    $trans = null;
    foreach ($delta as $d) {
        if ($d[0] == $estado && $d[1] == 'ε' && $d[2] == $p->getTopo()) {
            $trans = $d;
            break;
        }
    }
    if (!$trans) {
        break;
    }
    $estado = $trans[3];
    $p->desempilha();
    if ($trans[4] != 'ε') {
        $elementos = explode(' ', $trans[4]);
        for ($j = count($elementos) - 1; $j >= 0; $j--) {
            $p->empilha($elementos[$j]);
        }
    }
    $i++;
}

if (in_array($estado, $F) && $p->estaVazia()) {
    echo "\nLinguagem Aceita";
} else {
    echo "\nLinguagem Não Aceita";
}

?>