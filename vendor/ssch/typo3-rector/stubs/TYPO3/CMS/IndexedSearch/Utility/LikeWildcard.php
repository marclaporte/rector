<?php

namespace RectorPrefix20211031\TYPO3\CMS\IndexedSearch\Utility;

if (\class_exists('TYPO3\\CMS\\IndexedSearch\\Utility\\LikeWildcard')) {
    return;
}
class LikeWildcard
{
    const WILDCARD_LEFT = 'foo';
    const WILDCARD_RIGHT = 'foo';
}
