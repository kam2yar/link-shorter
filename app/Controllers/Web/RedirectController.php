<?php

namespace App\Controllers\Web;

use App\Repositories\LinkRepository;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class RedirectController
{
    public function redirect(string $short): void
    {
        $repository = new LinkRepository();

        $long = $repository->findByShortLink($short);

        if (!$long) {
            throw new NotFoundHttpException();
        }

        redirect($long, 302);
    }
}