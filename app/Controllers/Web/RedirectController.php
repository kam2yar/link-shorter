<?php

namespace App\Controllers\Web;

use App\Controllers\Controller;
use App\Services\LinkService;

class RedirectController extends Controller
{
    public function redirect(string $short): void
    {
        $linkService = new LinkService();
        
        $link = $linkService->findOrFail($short);

        redirect($link['original'], 302);
    }
}