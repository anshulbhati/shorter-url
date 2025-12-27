<?php

namespace App\Observers;

use App\Models\ShorterLink;

class ShorterLinkObserver
{
    public function clicked(ShorterLink $shorterLink): void
    {
        $shorterLink->increment('click_count');
    }

    public function retrieved(ShorterLink $shorterLink): void
    {
        // $shorterLink->increment('click_count');
    }
    /**
     * Handle the ShorterLink "created" event.
     */
    public function created(ShorterLink $shorterLink): void
    {
        //
    }

    /**
     * Handle the ShorterLink "updated" event.
     */
    public function updated(ShorterLink $shorterLink): void
    {
        //
    }

    /**
     * Handle the ShorterLink "deleted" event.
     */
    public function deleted(ShorterLink $shorterLink): void
    {
        //
    }

    /**
     * Handle the ShorterLink "restored" event.
     */
    public function restored(ShorterLink $shorterLink): void
    {
        //
    }

    /**
     * Handle the ShorterLink "force deleted" event.
     */
    public function forceDeleted(ShorterLink $shorterLink): void
    {
        //
    }
}
