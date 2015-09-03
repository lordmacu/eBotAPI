<?php

namespace Reflex\Database\Traits;

trait MatchStatusTrait
{
	public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return self::STATUS_NOT_STARTED;
                break;
            case 1:
                return self::STATUS_STARTING;
                break;
            case 2:
                return self::STATUS_KNIFE_WARMUP;
                break;
            case 3:
                return self::STATUS_KNIFE_ROUND;
                break;
            case 4:
                return self::STATUS_KNIFE_FINISHED;
                break;
            case 5:
                return self::STATUS_FIRST_SIDE_WARMUP;
                break;
            case 6:
                return self::STATUS_FIRST_SIDE;
                break;
            case 7:
                return self::STATUS_SECOND_SIDE_WARMUP;
                break;
            case 8:
                return self::STATUS_SECOND_SIDE;
                break;
            case 9:
                return self::STATUS_OT_FIRST_SIDE_WARMUP;
                break;
            case 10:
                return self::STATUS_OT_FIRST_SIDE;
                break;
            case 11:
                return self::STATUS_OT_SECOND_SIDE_WARMUP;
                break;
            case 12:
                return self::STATUS_OT_SECOND_SIDE;
                break;
            case 13:
                return self::STATUS_FINISHED;
                break;
            case 14:
                return self::STATUS_ARCHIVED;
                break;
            default:
                return self::STATUS_UNKNOWN;
                break;
        }
    }

	public function getFriendly()
    {
        switch ($this->getStatus()) {
            case self::STATUS_NOT_STARTED:
                return 'Not Started';
                break;
            case self::STATUS_STARTING:
                return 'Starting...';
                break;
            case self::STATUS_KNIFE_WARMUP:
                return 'Knife Round Warmup';
                break;
            case self::STATUS_KNIFE_ROUND:
                return 'Knife Round';
                break;
            case self::STATUS_KNIFE_FINISHED:
                return 'Waiting for Knife Round winner to choose side...';
                break;
            case self::STATUS_FIRST_SIDE_WARMUP:
                return 'First Side Warmup';
                break;
            case self::STATUS_FIRST_SIDE:
                return "First Side - {$this->score_a}-{$this->score_b}";
                break;
            case self::STATUS_SECOND_SIDE_WARMUP:
                return 'Second Side Warmup';
                break;
            case self::STATUS_SECOND_SIDE:
                return "Second Side - {$this->score_a}-{$this->score_b}";
                break;
            case self::STATUS_OT_FIRST_SIDE_WARMUP:
                return 'First Side Overtime Warmup';
                break;
            case self::STATUS_OT_FIRST_SIDE:
                return "First Side Overtime - {$this->score_a}-{$this->score_b}";
                break;
            case self::STATUS_OT_SECOND_SIDE_WARMUP:
                return 'Second Side Overtime Warmup';
                break;
            case self::STATUS_OT_SECOND_SIDE:
                return "Second Side Overtime - {$this->score_a}-{$this->score_b}";
                break;
            case self::STATUS_FINISHED:
                return 'Match Finished';
                break;
            case self::STATUS_ARCHIVED:
                return 'Match Finished';
                break;
            case self::STATUS_UNKNOWN:
                return 'Unknown';
                break;
        }
    }
}