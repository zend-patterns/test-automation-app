<?php
namespace Zf1Compat\View;

interface ViewFactoryInterface
{
    public function createView(): View;

    public function injectViewVars(View $view);
}
