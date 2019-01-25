<?php

namespace App\Interfaces;

interface HasInvitationInterface
{
    public function getInviteUrl($userId);
}
