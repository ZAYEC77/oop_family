<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */

require 'Human.php';
require 'Family.php';


$father = new Human('Father'); // був собі батько
$mother = new Human('Mother'); // і була собі мати

$family = new Family([$father, $mother]); // і вирішили вони створити сім'ю

$boy = $family->addChild(new Human('Boy')); // одного разу з'явився в них син
$boy2 = $family->addChild(new Human('Boy #2')); // а через деякий час ще один


$olderChild = $family->getOlderChild();

if ($boy === $olderChild){
    echo 'My older brother is me :/';
}