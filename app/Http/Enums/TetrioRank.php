<?php

namespace App\Http\Enums;

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
}
