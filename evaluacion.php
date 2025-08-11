<?php
function repartirCartas(){
    $nums = ["A", "K", "Q", "J", 10, 9, 8, 7, 6, 5, 4, 3, 2];
    $palos = ["picas", "diamantes", "trebol", "corazon"];
    $m = [];
    for($i=0;$i<5;$i++){
        $v = $nums[rand(0,12)];
        $p = $palos[rand(0,3)];
        $m[] = [$v,$p];
    }
    return $m;
}

function puntos($c){
    if($c=="A")return 14;
    if($c=="K")return 13;
    if($c=="Q")return 12;
    if($c=="J")return 11;
    return $c;
}

function evaluarMano($m){
    $val = [];
    $pal = [];
    for($i=0;$i<count($m);$i++){
        $val[] = puntos($m[$i][0]);
        $pal[] = $m[$i][1];
    }

    $col = false;
    $c1 = $pal[0];
    $ig = 0;
    for($i=0;$i<count($pal);$i++){
        if($pal[$i]==$c1){
            $ig++;
        }
    }
    if($ig==5)$col=true;

    $unicos = [];
    for($i=0;$i<count($val);$i++){
        if(!in_array($val[$i],$unicos)){
            $unicos[] = $val[$i];
        }
    }

    $esc = false;
    $min = min($val);
    $max = max($val);
    if(count($unicos)==5){
        $cseg = 0;
        for($x=$min;$x<=$max;$x++){
            if(in_array($x,$val))$cseg++;
        }
        if($cseg==5 || (in_array(14,$val)&&in_array(2,$val)&&in_array(3,$val)&&in_array(4,$val)&&in_array(5,$val))){
            $esc = true;
        }
    }

    $contv = [];
    for($i=0;$i<count($val);$i++){
        $rep=0;
        for($j=0;$j<count($val);$j++){
            if($val[$i]==$val[$j]){
                $rep++;
            }
        }
        $contv[$val[$i]] = $rep;
    }

    if($col && $esc && max($val)==14){
        echo "Escalera Real\n";
    } else if($col && $esc){
        echo "Escalera de Color\n";
    } else if(in_array(4,$contv)){
        echo "Poker\n";
    } else if(in_array(3,$contv) && in_array(2,$contv)){
        echo "Full House\n";
    } else if($col){
        echo "Color\n";
    } else if($esc){
        echo "Escalera\n";
    } else if(in_array(3,$contv)){
        echo "Trio\n";
    } else {
        $pares=0;
        foreach($contv as $x){
            if($x==2)$pares++;
        }
        if($pares==2){
            echo "Dos Pares\n";
        } else if($pares==1){
            echo "Par\n";
        } else {
            $vh = max($val);
            $ind = array_search($vh,$val);
            echo "Carta Alta: ".$m[$ind][0]."\n";
        }
    }
}

$mano = repartirCartas();
for($i=0;$i<count($mano);$i++){
    echo $mano[$i][0]." de ".$mano[$i][1]."\n";
}
evaluarMano($mano);

