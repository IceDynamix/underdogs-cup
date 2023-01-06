<?php

namespace App\Enums;

enum TetrioRank: string
{
    case X = 'x';
    case U = 'u';
    case SS = 'ss';
    case SPlus = 's+';
    case S = 's';
    case SMinus = 's-';
    case APlus = 'a+';
    case A = 'a';
    case AMinus = 'a-';
    case BPlus = 'b+';
    case B = 'b';
    case BMinus = 'b-';
    case CPlus = 'c+';
    case C = 'c';
    case CMinus = 'c-';
    case DPlus = 'd+';
    case D = 'd';
    case Unranked = 'z';

    public function format(): string
    {
        return strtoupper($this->value);
    }

    public function rank(): int
    {
        if ($this == TetrioRank::Unranked) {
            return -1;
        }

        $list = [
            TetrioRank::D,
            TetrioRank::DPlus,
            TetrioRank::CMinus,
            TetrioRank::CPlus,
            TetrioRank::C,
            TetrioRank::BMinus,
            TetrioRank::B,
            TetrioRank::BPlus,
            TetrioRank::AMinus,
            TetrioRank::A,
            TetrioRank::APlus,
            TetrioRank::SMinus,
            TetrioRank::S,
            TetrioRank::SPlus,
            TetrioRank::SS,
            TetrioRank::U,
            TetrioRank::X,
        ];

        return array_search($this, $list);
    }
}
