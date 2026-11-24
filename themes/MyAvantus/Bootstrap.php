<?php declare(strict_types=1);
namespace Template\MyAvantus;

/** All functions and plugin hooks are inherited from the parent. */
class Bootstrap extends \Template\Avantus\Bootstrap
{
    public function boot(): void
    {
        parent::boot();
        $this->getSmarty()->assign('myAvantusBaseURL', $this->getTemplate()->getPaths()->getBaseURL());
    }
}
