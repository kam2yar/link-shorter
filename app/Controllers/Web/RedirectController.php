<?php

namespace App\Controllers\Web;

use App\Controllers\Controller;
use App\Repositories\LinkRepository;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class RedirectController extends Controller
{
    public function redirect(string $short): void
    {
        $repository = new LinkRepository();

        $link = $repository->findByShortLink($short);

        if (!$link) {
            throw new NotFoundHttpException();
        }

        redirect($link['long'], 302);
    }
}