<?php

namespace TCS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TCSUserBundle extends Bundle
{
    public function getParent(){
        return 'FOSUserBundle';
    }
}
