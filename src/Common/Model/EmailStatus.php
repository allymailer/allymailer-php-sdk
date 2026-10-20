<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

/**
 * EmailStatus
 */
enum EmailStatus: string
{
    case Sent = 'sent';
    case Delivered = 'delivered';
    case Opened = 'opened';
    case Clicked = 'clicked';
    case Unsubscribed = 'unsubscribed';
    case Subscribed = 'subscribed';
    case SoftBounced = 'soft_bounced';
    case HardBounced = 'hard_bounced';
    case Spam = 'spam';
}
