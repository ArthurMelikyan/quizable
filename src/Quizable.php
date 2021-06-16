<?php

namespace Arthurmelikyan\Quizable;

class Quizable
{
    public function sayHello($name){
        dd("it's ".now()->format('Y-m-d h:i:s')." o'clock and  i'll say you hello {$name}");
    }
}
