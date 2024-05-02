<?php

namespace App\Enums;

enum LaunchType: String
{
    case RESOURCE_LINK = 'LtiResourceLinkRequest';
    case DEEP_LINK = 'LtiDeepLinkingRequest';
}
