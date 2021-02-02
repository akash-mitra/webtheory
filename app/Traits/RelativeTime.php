<?php

namespace App\Traits;

trait RelativeTime
{

    /**
     * When was this created relative to now.
     *
     * @return null|string
     */
    public function getCreatedAgoAttribute(): ?string
    {
        return empty($this->created_at) ? null : $this->created_at->diffForHumans();
    }


    /**
     * When was this last updated relative to now.
     * @return null|string
     */
    public function getUpdatedAgoAttribute(): ?string
    {
        return empty($this->updated_at) ? null : $this->updated_at->diffForHumans();
    }
}
